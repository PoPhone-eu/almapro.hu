<?php

namespace App\Livewire\Admin\Product\Products;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Facades\Validator;

#[Layout('layouts.adminapp')]
class AddNewProduct extends Component
{
    use WithFileUploads;

    #[Locked]
    public $user_id;

    public $shops;
    public $productshops = [];

    public $user;
    public $productattributes = [];
    public $selected_attributes = [];
    public $data = [];

    public $category;

    #[Rule('required')]
    public $delivery = false;
    #[Rule('required', message: 'Az eladási bruttó árat add meg')]
    public $price;
    // required_if:delivery,true
    #[Rule('required_if:delivery,true')]
    public $delivery_price = null;
    #[Rule('required')]
    public $local_pickup = true;

    #[Rule('nullable')]
    public $battery = null;

    #[Rule('required')]
    #[Rule('required', message: 'A termékmegnevezés kötelező')]
    public $product_name;

    public $product_name_lenght = 0;

    // #[Rule('image|mimes:jpeg,png|size:3072')]
    #[Rule('required', message: 'A kiemelt kép megadása kötelező')]
    public $mainimage;

    #[Rule(['photos.*' => 'nullable|image|max:3072'])]
    public $photos = [];

    #[Rule(['newphoto' => 'nullable|image|max:3072'])]
    public $newphoto;

    #[Rule('required', message: 'A termékleírás kötelező')]
    public $description = null;

    public $attr_type, $category_id, $subcategory_id;

    public function mount($user_id, $attr_type, $category_id, $subcategory_id = null)
    {
        $this->attr_type = $attr_type;
        $this->category_id = $category_id;
        $this->subcategory_id = $subcategory_id;
        $this->user_id = $user_id;
        $this->user = User::find($user_id);
        if ($this->subcategory_id != null) {
            $this->productattributes = ProductAttribute::where('type', $attr_type)->where('category_id', $this->subcategory_id)->get();
            if ($this->productattributes == null) {
                $this->productattributes = ProductAttribute::where('type', $attr_type)->where('category_id', $this->category_id)->get();
            } else {
                // we also add the attributes from the parent category but we don't overwrite the attributes from the subcategory so we need
                // the ones not in the subcategory:
                $parent_category_attributes = ProductAttribute::where('type', $attr_type)->where('category_id', $this->category_id)->get();
                // now we remove the ones that are already in the subcategory:
                if ($parent_category_attributes != null) {
                    foreach ($this->productattributes as $productattribute) {
                        foreach ($parent_category_attributes as $key => $parent_category_attribute) {
                            if ($productattribute->attr_name == $parent_category_attribute->attr_name) {
                                unset($parent_category_attributes[$key]);
                            }
                        }
                    }
                    // now we add the remaining attributes to $this->productattributes:
                    foreach ($parent_category_attributes as $parent_category_attribute) {
                        $this->productattributes[] = $parent_category_attribute;
                    }
                }
            }
        } else {
            $this->productattributes = ProductAttribute::where('type', $attr_type)->where('category_id', $this->category_id)->get();
        }
        // dd($this->productattributes);
        // loop through the productattributes and add them to $this->selected_attributes
        foreach ($this->productattributes as $productattribute) {
            $this->selected_attributes[$productattribute->id] = null;
        }
        $this->shops = $this->user->shops;
    }

    public function setThisData($value_id)
    {
        $this_value = ProductAttributeValue::find($value_id);
        $this_product_attribute = ProductAttribute::find($this_value->product_attribute_id);
        // check if $this->data[$this_product_attribute->attr_display_name] exists. If it does, we remove it first:
        if (isset($this->data[$this_product_attribute->id])) {
            $this->removeThisData($this_product_attribute->id);
        }
        // add this data to $this->data so later we can save it as json when submitted
        $this->data[$this_product_attribute->id] = [
            'value' => $this_value->value,
            'rgb'   => $this_value->rgb,
            'attr_id' => $this_value->product_attribute_id,
            'attr_type' => $this_product_attribute->type,
            'attr_name' => $this_product_attribute->attr_name,
            'attr_display_name' => $this_product_attribute->attr_display_name,
        ];
    }

    public function removeThisData($attr_id)
    {
        // remove this data where
        unset($this->data[$attr_id]);
    }

    public function clearMainimage()
    {
        $this->mainimage = null;
    }

    public function deletePhoto($key)
    {
        // remove the photo from the array
        unset($this->photos[$key]);
    }

    public function render()
    {
        /*  if ($this->mainimage) {
            dd($this->mainimage->temporaryUrl());
        }
 */
        //$this->dispatch('ckEditor');
        return view('livewire.admin.product.products.add-new-product');
    }

    public function updatedCategory()
    {
        if ($this->category == null) {
            $this->productattributes = [];
            $this->selected_attributes = [];
        } else {
            $this->productattributes = ProductAttribute::where('type', $this->category)->orWhere('type', 'all')->get();
            // loop through the productattributes and add them to $this->selected_attributes
            foreach ($this->productattributes as $productattribute) {
                $this->selected_attributes[$productattribute->id] = null;
            }
            // if ($this->category != null)  $this->dispatch('initializeCkEditor');
        }
        //dd($this->productattributes);
    }

    public function updatedSelectedAttributes()
    {
        // dd($this->selected_attributes);
    }

    public function updatedProductName()
    {
        $this->product_name_lenght = strlen($this->product_name);
    }

    public function submit()
    {
        $this->validate();
        //dd($this->description);

        // let's save the product
        $save = new Product();
        $save->name = $this->product_name;
        $save->type = $this->attr_type;
        $save->description = $this->description;
        $save->price = $this->price;
        $save->battery = $this->battery;
        $save->user_id = $this->user_id;
        $save->category_id = $this->category_id;
        $save->subcategory_id = $this->subcategory_id;
        $save->delivery = $this->delivery;
        $save->delivery_price = $this->delivery_price;
        $save->local_pickup = $this->local_pickup;
        if ($this->user->is_owner == false) {
            $save->is_owner = false;
        } else {
            $save->is_owner = true;
        }
        // we save the attributes into data jason:
        $data = [];
        $data['attributes'] = $this->data;

        //$save->data = json_encode($this->data);
        // STORE IMAGES
        // first we store the main image: $mainimage with livewire 3 methods:
        //$this->mainimage->store('mainimages', 's3');
        $data['mainimage'] = $this->mainimage->hashName();
        $save
            ->addMedia($this->mainimage->getRealPath())
            ->usingName($data['mainimage'])
            ->toMediaCollection('mainimage');
        // now we store the other images if there are any in $this->photos and we add the names to $this->data as 'gallery':
        if ($this->photos) {
            foreach ($this->photos as $photo) {
                $photo_name = $photo->hashName();
                $data['gallery'][] = $photo_name;
                $save
                    ->addMedia($photo->getRealPath())
                    ->usingName($photo_name)
                    ->toMediaCollection('gallery');
            }
        }

        $save->data = $data;
        $save->save();

        // we check if productshops array is not empty and if it is not, we save the productshops:
        if ($this->productshops) {
            foreach ($this->productshops as $shop_id) {
                $save->shops()->attach($shop_id);
            }
        }

        $this->redirect('/userproducts/' . $this->user_id);
    }
}
