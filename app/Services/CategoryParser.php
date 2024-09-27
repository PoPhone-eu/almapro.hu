<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class CategoryParser
{
    public $categories_array;
    public $properties_array;

    public function __construct()
    {
        $xmlString = file_get_contents('https://pophone.eu/rrs/almapro-categories.xml');
        //$xmlString2 = file_get_contents('https://pophone.eu/rrs/almapro-feed.xml');
        // $xmlString = file_get_contents('http://almapro.test/almapro-categories.xml');
        $xmlObject = simplexml_load_string($xmlString);
        //$xmlObject2 = simplexml_load_string($xmlString2);

        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);
        $data = [];

        foreach ($phpArray['product'] as $key => $value) {
            $data[] = [
                'type' => $value['type_1'],
                'category_name' => $value['type_2'],
                'sub_category_name' => $value['type_3'],
                'name' => $value['name'],
                'id' => $value['id'],
                'properties' => $value['values'],

            ];
        }
        /*  $json2 = json_encode($xmlObject2);
        $phpArray2 = json_decode($json2, true);
        $data2 = [];
        foreach ($phpArray2['product'] as $key => $value) {
            $data2[] = [
                'type' => $value['type_1'],
                'category_name' => $value['type_2'],
                'sub_category_name' => $value['type_3'],
                'properties' => $value['attrs'],

            ];
        } */

        // we merge the two arrays
        // $data = array_merge($data, $data2);

        $this->categories_array = $data;
        $this->parse();
        $this->parseproperties();
    }

    private function parseproperties()
    {
        foreach ($this->categories_array as $key => $value) {
            // dd($value);
            if ($value['sub_category_name']  != null) {
                $category = Category::where('category_name', $value['category_name'])->where('type', $value['type'])->where('category_id', null)->first();
                if ($category) {
                    $subcategory = Category::where('category_name', $value['sub_category_name'])->where('type', $value['type'])->where('category_id', $category->id)->first();
                    if ($subcategory) {
                        $this->createProperties($value, $subcategory->id);
                    }
                }
            } elseif ($value['category_name'] !=  null) {
                $category = Category::where('category_name', $value['category_name'])->where('type', $value['type'])->where('category_id', null)->first();
                if ($category) {
                    $this->createProperties($value, $category->id);
                }
            }
        }
    }

    public function parse()
    {
        //$temp = [];
        // dd($this->categories_array);
        foreach ($this->categories_array as $key => $value) {
            // if $value['type'] starts with "i" or "I" we make sire it is not capital letter si we change "I" to "i"
            // if substr($value['type'] is array we continue:
            if (is_array($value['type'])) {
                continue;
            }
            if (substr($value['type'], 0, 1) == "I") {
                $this->categories_array[$key]['type'] = lcfirst($value['type']);
            }
            // if $value['type] == 'Felújított we remove this key/value
            if ($value['type'] == 'Felújított') {
                unset($this->categories_array[$key]);
            }
            if ($value['sub_category_name'] == 'Renewd- felújított') {
                $this->categories_array[$key]['sub_category_name'] = null;
            }
        }
        logger('CategoryParser started parsing...');
        foreach ($this->categories_array as $key => $value) {
            // dd($value);
            if ($value['type'] == 'Felújított') {
                continue;
            }
            if (!is_string($value['category_name'])) {
                continue;
            }
            if ($value['type'] == 'Apple') {
                $this->categories_array[$key]['type'] = $value['category_name'];
                $this->categories_array[$key]['category_name'] = $value['sub_category_name'];
                $this->categories_array[$key]['sub_category_name'] = null;
            }
            if ($value['type'] == 'Macbook') {
                $this->categories_array[$key]['type'] = 'MacBook';
            }

            // check if $this->categories_array[$key]['type'] is in the array of Product::TYPES_CHECK
            if (!in_array($value['type'], Product::TYPES_CHECK)) {
                continue;
            }

            $this->createFirstLevelCategory($value);
        }

        foreach ($this->categories_array as $key => $value) {
            $this->createSecondLevelCategory($value);
        }
        logger('CategoryParser finished parsing...');
    }

    private function createFirstLevelCategory($value)
    {
        $sub_category = Category::where('category_name', $value['category_name'])->where('type', $value['type'])->where('category_id', null)->first();
        if (!$sub_category) {
            $this->createNewMainCategoryChain($value);
        }
    }

    private function createSecondLevelCategory($value)
    {
        if (is_string($value['sub_category_name']) && $value['sub_category_name'] != null) {
            $category = Category::where('category_name', $value['category_name'])->where('type', $value['type'])->where('category_id', null)->first();
            if ($category) {
                $sub_sub_category = Category::where('category_name', $value['sub_category_name'])->where('type', $value['type'])->where('category_id', $category->id)->first();
                if (!$sub_sub_category) {
                    $sub_sub_category = new Category();
                    $sub_sub_category->category_name = $value['sub_category_name'];
                    $sub_sub_category->name = $value['name'];
                    $sub_sub_category->provider_id = $value['id'];
                    $sub_sub_category->type = $value['type'];
                    $sub_sub_category->category_id = $category->id;
                    $sub_sub_category->save();
                }
            }
        }
    }

    private function createNewMainCategoryChain($value)
    {
        // create sub category
        $sub_category = new Category();
        $sub_category->category_name = $value['category_name'];
        $sub_category->name = $value['name'];
        $sub_category->provider_id = $value['id'];
        $sub_category->type = $value['type'];
        $sub_category->category_id = null;
        $sub_category->save();

        if (isset($value['sub_category_name']) && is_string($value['sub_category_name'] && $value['sub_category_name'] != null)) {

            $sub_sub_category = new Category();
            $sub_sub_category->category_name = $value['sub_category_name'];
            $sub_category->name = $value['name'];
            $sub_category->provider_id = $value['id'];
            $sub_sub_category->type = $value['type'];
            $sub_sub_category->category_id = $sub_category->id;
            $sub_sub_category->save();
        }
    }

    private function createProperties($data, $category_id)
    {
        logger($data);
        //return;
        foreach ($data['properties'] as $key2 => $value2) {

            $attribute = ProductAttribute::where('attr_name', $key2)->where('category_id', $category_id)->first();
            //dd($attribute);
            if (!$attribute) {
                try {
                    if ($value2['value'] != []) {
                        $this->createSingleAttribute($key2, $value2['value'], $category_id);
                    }
                } catch (\Throwable $th) {
                    logger($value2);
                }
            } else {
                $attribute_values = $attribute->values;
                // check if values alredy exist or not. If not we add the new values
                foreach ($attribute_values as $key3 => $value3) {
                    $property_value = ProductAttributeValue::where('product_attribute_id', $attribute->id)->where('value', $value3)->first();
                    if (!$property_value) {
                        if (is_array($value3)) {
                            foreach ($value3 as $key => $value) {
                                $property_value = new ProductAttributeValue();
                                $property_value->product_attribute_id = $attribute->id;
                                $property_value->value = $value;
                                $property_value->save();
                            }
                        }
                    }
                }
            }
        }
    }

    private function createSingleAttribute($attr_name, $values, $category_id)
    {
        $type = Category::where('id', $category_id)->first()->type;
        $property = new ProductAttribute();
        $property->attr_name = $attr_name;
        $property->attr_display_name = $attr_name;
        $property->is_required = 0;
        $property->type = $type;
        $property->category_id = $category_id;
        $property->save();
        // add new Attribute values
        try {
            if (is_array($values)) {
                foreach ($values as $key => $value) {
                    $property_value = new ProductAttributeValue();
                    $property_value->product_attribute_id = $property->id;
                    $property_value->value = $value;
                    $property_value->save();
                }
            } else {
                $property_value = new ProductAttributeValue();
                $property_value->product_attribute_id = $property->id;
                $property_value->value = $values;
                $property_value->save();
            }
        } catch (\Exception $e) {
            logger($values);
        }
    }
}
