<?php

namespace App\Services;

set_time_limit(0);

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class ProductParser
{
    public $products_array;
    public $products_count = 0;

    public function __construct()
    {
        $xmlString = file_get_contents('https://pophone.eu/rrs/almapro-feed.xml');
        $xmlObject = simplexml_load_string(
            $xmlString,
            null,
            LIBXML_NOCDATA
        );

        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);
        $data = [];
        // itarate through the array from https://pophone.eu/rrs/almapro-feed.xml file
        foreach ($phpArray['product'] as $key => $value) {
            $data[] = [
                'id' => $value['id'],
                'user_id' => $value['user_id'],
                'name' => $value['title'],
                'price' => $value['price_huf'],
                'brand' => $value['brand'],
                'type_1' => $value['type_1'],
                'type_2' => $value['type_2'],
                'type_3' => $value['type_3'],
                'description' => $value['description'],
                'images' => $value['images'],  // array of images
                'attrs' => $value['attrs'],
            ];
        }
        $this->products_array = $data;
        foreach ($this->products_array as $key => $value) {
            // if $value['type_1'] is array we skip it and write it in log.
            if (is_array($value['type_1'])) {
                logger('Eltávolítva a feltöltési listáról: ' . $value['id']);
                // we remove this element from the array
                unset($this->products_array[$key]);
                continue;
            }
            // if $value['type_1'] starts with "i" or "I" we make sure it is not capital letter si we change "I" to "i"
            if (substr($value['type_1'], 0, 1) == "I") {
                $value['type_1'] = lcfirst($value['type_1']);
            }
        }
        // get all product IDs where provider_id is not null:
        $product_ids = Product::whereNotNull('provider_id')->pluck('provider_id')->toArray();
        // we check $product_ids against $this->products_array and if an id if not in $this->products_array we remove it from the database.
        // $product_ids contains all product IDs from the database. we dont need to fetch it again...
        foreach ($product_ids as $id) {
            $found = false;
            foreach ($this->products_array as $product) {
                if ($product['id'] == $id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // we remove this product from the database.
                $product = Product::where('provider_id', $id)->first();
                if ($product) {
                    // logger('Törölve a termék id: ' . $product->id);
                    //logger('Törölve a termék provider_id: ' . $product->provider_id);
                    $product->delete();
                }
            }
        }

        $this->parse();
    }

    private function parse()
    {
        // logger($this->products_array);
        $i = 0;
        foreach ($this->products_array as $product) {
            $this->createProduct($product);
            /*  $i++;
            if ($i > 5) {
                break;
            } */
        }
        logger('Feltöltött termékek száma: ' . $this->products_count);
    }

    private function createProduct($product)
    {
        // check if the product id (provider_id) is already in the database. If it is, we skip it. (we don't want to duplicate products in the database.
        $thisproduct = Product::where('provider_id', $product['id'])->first();
        if ($thisproduct) {
            return;
        }
        // check if type_1 is in Product::TYPES. If it is not, we skip it.
        if (!array_key_exists($product['type_1'], Product::TYPES)) {

            return;
        }
        $category_id = null;
        $subcategory_id = null;
        $data = null;
        $thisuser = User::where('provider_id', 1)->first();

        if (!$thisuser) {
            $thisuser_id = 1;
        } else {
            $thisuser_id = $thisuser->id;
        }

        $description                = $product['description'];
        $Product                    = new Product;
        $Product->user_id           = $thisuser_id;
        $Product->is_owner          = true;
        $Product->description       = $description;
        $Product->name              = $product['name'];
        $Product->provider_id       = $product['id'];
        $Product->price             = (int)$product['price'];
        $Product->category_id       = null;
        $Product->subcategory_id    = null;
        $Product->type              = $product['type_1'];

        $attribute_cat_id_main = null;
        $attribute_cat_id_sub = null;
        if ($product['type_2'] != null) {
            $category_id = $this->getCategory($product);
            if ($category_id == null) {
                return;
            }
            $Product->category_id = $category_id;
            $attribute_cat_id_main = $category_id;
        } else {
            return;
        }

        if ($product['type_3'] != null && $category_id != null) {
            $subcategory_id = $this->getSubCategory($product, $category_id);
            $Product->subcategory_id = $subcategory_id;
            $attribute_cat_id_sub = $subcategory_id;
        }

        // we save the images links from the array. First we store the main image, it is the first in the array and if there are more we store them as gallery.
        // We need to get the images from an url and save it to the storage. Gallery images go into $image_links['gallery'].
        // first check if $product['images']['image_link'] exists. If not we skip this product.
        if (!isset($product['images']['image_link'])) {
            return;
        }
        foreach ($product['images']['image_link'] as $key => $url) {
            try {
                $image_name =  $Product->addMediaFromUrl($url)->toMediaCollection('gallery');
                $data['gallery'][] = $image_name['file_name'];
            } catch (\Throwable $th) {
                logger($th);
            }
        }
        // if there is no image we skip this product.
        if (!isset($data['gallery'])) {
            return;
        }

        $data['attributes'] = null;
        //$save->attrs            = $product['attrs'];

        // $product['attrs'] contains the attributes of the product. We have to save them in the database.
        foreach ($product['attrs'] as $key => $value) {
            if ($key  == 'Akkumulátor') {
                continue;
            }
            if ($key  == 'akkumulator') {
                continue;
            }
            if ($value == 'Important display message') {
                continue;
            }

            $attribute = null;
            // we check if this attribute for the category exists in the database. If it does, we use it, if not, we create it.
            if ($attribute_cat_id_sub != null) {
                $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_sub)->first();
                if ($attribute == null) {
                    $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_main)->first();
                }
            } elseif ($attribute_cat_id_main != null) {
                $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_main)->first();
            }
            $value = str_replace('"', '', $value);
            if ($key == "Kijelző") {
                $Product->kijelzo = $value;
            } elseif ($key == "Keret") {
                $Product->keret = $value;
            } elseif ($key == "Hátlap") {
                $Product->hatlap = $value;
            } elseif ($key == "Fedlap") {
                $Product->fedlap = $value;
            } elseif ($key == "Ház") {
                $Product->haz = $value;
            } elseif ($key == "allapot") {
                // we remove " sign from the value
                $value = str_replace('"', '', $value);
                $Product->device_state = $value;
            } else {
                if ($attribute) {
                    // we check if the value exists in the database.
                    $attribute_value = ProductAttributeValue::where('product_attribute_id', $attribute->id)->where('value', $value)->first();
                    if ($attribute_value) {
                        $data['attributes'][$attribute->id] =
                            [
                                'value' => $attribute_value->value,
                                'rgb'   => $attribute_value->rgb,
                                'attr_id' => $attribute_value->product_attribute_id,
                                'attr_type' => $attribute->type,
                                'attr_name' => $attribute->attr_name,
                                'attr_display_name' => $attribute->attr_display_name,
                            ];;
                    }
                }
            }
        }
        $Product->data             = $data;
        $Product->save();
        $this->products_count++;
    }

    private function getSubCategory($product, $category_id)
    {
        $category = Category::where('category_name', $product['type_3'])->where('category_id', $category_id)->first();
        if ($category) {
            return $category->id;
        } else {
            return  null;
            // we have to create this category:
            $save = new Category;
            $save->category_name = $product['type_3'];
            $save->type = $product['type_1'];
            $save->category_id = $category_id;
            $save->save();
            // logger('Új alkategória: ');
            // logger($save);
            return $save->id;
        }
    }

    private function getCategory($product)
    {
        $category = Category::where('category_name', $product['type_2'])->where('category_id', null)->first();
        if ($category) {
            return $category->id;
        } else {
            return null;
            // we have to create this category:
            /*  $save = new Category;
            $save->category_name = $product['type_2'];
            $save->type = $product['type_1'];
            $save->save();
            return $save->id; */
        }
    }
}
