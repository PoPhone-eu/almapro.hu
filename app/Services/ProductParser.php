<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class ProductParser
{
    public $products_array;

    public function __construct()
    {
        $xmlString = file_get_contents('https://pophone.eu/rrs/almapro-feed.xml');
        //$xmlString = file_get_contents('http://almapro.test/almapro-feed.xml');
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
            // if $value['type_1'] starts with "i" or "I" we make sire it is not capital letter si we change "I" to "i"
            if (substr($value['type_1'], 0, 1) == "I") {
                $value['type_1'] = lcfirst($value['type_1']);
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
            $i++;
            /*  if ($i > 10) {
                break;
            } */
        }
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
            return;
        }

        $description                = $product['description'];
        $Product                    = new Product;
        $Product->user_id           = $thisuser->id;
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
        }

        if ($product['type_3'] != null && $category_id != null) {
            $subcategory_id = $this->getSubCategory($product, $category_id);
            $Product->subcategory_id = $subcategory_id;
            $attribute_cat_id_sub = $subcategory_id;
        }

        // we save the images links from the array. First we store the main image, it is the first in the array and if there are more we store them as gallery.
        // We need to get the images from an url and save it to the storage. Gallery images go into $image_links['gallery'].
        foreach ($product['images']['image_link'] as $key => $url) {
            if ($key == 0) {
                // $image_links['mainimage'] is the main image.
                $image_name =  $Product->addMediaFromUrl($url)->toMediaCollection('mainimage');
                // we need the hashName
                $data['mainimage'] = $image_name['file_name'];
            } else {
                $image_name =  $Product->addMediaFromUrl($url)->toMediaCollection('gallery');
                // we need the hashName
                $data['gallery'][] = $image_name['file_name'];
            }
        }
        $data['attributes'] = null;
        //$save->attrs            = $product['attrs'];

        // $product['attrs'] contains the attributes of the product. We have to save them in the database.
        foreach ($product['attrs'] as $key => $value) {
            if ($key  == 'akkumulator') {
                continue;
            }
            if ($value == 'Important display message') {
                continue;
            }

            // we check if this attribute for the category exists in the database. If it does, we use it, if not, we create it.
            if ($attribute_cat_id_sub != null) {
                $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_sub)->first();
                if ($attribute == null) {
                    $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_main)->first();
                }
            } elseif ($attribute_cat_id_main != null) {
                $attribute = ProductAttribute::where('attr_name', $key)->where('category_id', $attribute_cat_id_main)->first();
            }

            //if ($attribute == null) return;

            /* if ($key == 'allapot') {
                ProductAttribute::where('attr_name', 'allapot')->where('type', 'All')->first();
            } else {
                $attribute = ProductAttribute::where('attr_name', $key)->where('type', $product['type_1'])->first();
            } */
            //$attribute = ProductAttribute::where('attr_name', $key)->where('type', $product['type_1'])->first();
            //we skipp this attribute if it is 'Important display message'

            // we strip any special chars from $value such as: '"' and "\n"
            $value = str_replace('"', '', $value);
            if ($attribute) {
                // we check if the value exists in the database.
                $attribute_value = ProductAttributeValue::where('product_attribute_id', $attribute->id)->where('value', $value)->first();
                /*  logger($attribute_cat_id_sub);
                logger($attribute_cat_id_main);
                logger($key);
                logger($attribute_value);
                logger($value);
                logger('**********************************'); */
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
                } else {
                    // return;
                    if ($value != null || !is_array($value)) {
                        $ProductAttributeValue = new ProductAttributeValue;
                        $ProductAttributeValue->product_attribute_id = $attribute->id;
                        $ProductAttributeValue->value = $value;
                        $ProductAttributeValue->save();
                        $data['attributes'][$attribute->id] =
                            [
                                'value' => $ProductAttributeValue->value,
                                'rgb'   => $ProductAttributeValue->rgb,
                                'attr_id' => $ProductAttributeValue->product_attribute_id,
                                'attr_type' => $attribute->type,
                                'attr_name' => $attribute->attr_name,
                                'attr_display_name' => $attribute->attr_display_name,
                                'category_id' => $Product->category_id,
                            ];
                    }
                }
            } else {
                // return;
                if ($value != null || !is_array($value)) {
                    $save = new ProductAttribute;
                    $save->attr_name = $key;
                    $save->type = $product['type_1'];
                    $save->attr_display_name = $key;
                    $save->category_id = $Product->category_id;
                    $save->save();
                    $ProductAttributeValue = new ProductAttributeValue;
                    $ProductAttributeValue->product_attribute_id = $save->id;
                    $ProductAttributeValue->value = $value;
                    $ProductAttributeValue->save();
                    $data['attributes'][$save->id] =
                        [
                            'value' => $ProductAttributeValue->value,
                            'rgb'   => $ProductAttributeValue->rgb,
                            'attr_id' => $ProductAttributeValue->product_attribute_id,
                            'attr_type' => $save->type,
                            'attr_name' => $save->attr_name,
                            'attr_display_name' => $save->attr_display_name,
                            'category_id' => $Product->category_id,
                        ];
                } else {

                    return;
                }
            }
        }
        $Product->data             = $data;
        $Product->save();
        // logger($Product);
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
            logger('Új alkategória: ');
            logger($save);
            return $save->id;
        }
    }

    private function getCategory($product)
    {
        $category = Category::where('category_name', $product['type_2'])->where('category_id', null)->first();
        /* logger($product);
        logger($category); */
        if ($category) {
            return $category->id;
        } else {
            //return  null;
            // we have to create this category:
            $save = new Category;
            $save->category_name = $product['type_2'];
            $save->type = $product['type_1'];
            $save->save();
            logger('Új kategória: ');
            logger($save);
            return $save->id;
        }
    }
}
