<?php

namespace App\Livewire\Front\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product_id;
    public $product;
    public $url_error = null;

    #[Locked]
    public $user_id;
    public $max_char = 55;
    public $shops;
    public $productshops = [];

    public $user;
    public $productattributes = [];
    public $selected_attributes = [];
    public $data = [];
    public $images;
    public $category;
    public $item_sold;
    #[Rule('nullable')]
    public $url;
    #[Rule('required')]
    public $delivery;

    #[Rule('required', message: 'Az eladási bruttó árat add meg')]
    public $price;

    // required_if:delivery,true
    #[Rule('required_if:delivery,1', message: 'A szállítási árat add meg, ha a szállítás igényelhető')]
    public $delivery_price = null;
    #[Rule('required')]
    public $local_pickup;

    #[Rule('required', message: 'A termék megnevezés kötelező. Minimum 3 karakter és maximum 55 karakter')]
    #[Rule('min:10', message: 'Minimum 10 karakter')]
    #[Rule('max:55', message: 'Maximum 55 karakter')]
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

    public function mount($product_id)
    {
        $this->product_id = $product_id;
        $this->product = Product::find($product_id);
        $this->setProperties();
    }

    private function setProperties()
    {
        $this->user_id = auth()->user()->id;
        $this->user = auth()->user();
        $this->productattributes = ProductAttribute::where('category_id', $this->subcategory_id)/* ->orWhere('category_id', null) */->get();
        foreach ($this->productattributes as $productattribute) {
            $this->selected_attributes[$productattribute->id] = null;
        }
        $this->data = $this->product->data;
        $this->shops = $this->user->shops;
        $this->delivery = $this->product->delivery;
        $this->price = $this->product->price;
        $this->delivery_price = $this->product->delivery_price;
        $this->local_pickup = $this->product->local_pickup;
        $this->product_name = $this->product->name;
        $this->product_name_lenght = strlen($this->product->name);
        $this->mainimage = $this->product->getMedia('mainimage')->first()?->getUrl();
        $this->description = $this->product->description;
        $this->category_id = $this->product->category_id;
        $this->subcategory_id = $this->product->subcategory_id;
        $this->url = $this->product->url;
        $this->item_sold = $this->product->is_sold;
        $this->images               = $this->product->getMedia('gallery');
        if ($this->product->shops->count() > 0) {
            foreach ($this->product->shops as $shop) {
                $this->productshops[] = $shop->id;
            }
        }
    }

    public function setLocalpickup()
    {
        if ($this->local_pickup == true) {
            $this->local_pickup = 0;
        } else {
            $this->local_pickup = 1;
        }
    }

    public function setDelivery()
    {
        if ($this->delivery == true) {
            $this->delivery = 0;
        } else {
            $this->delivery = 1;
        }
    }

    public function deletePhoto($file_id)
    {
        deleteFileByID($file_id);
        // remove the photo from the array
        //unset($this->photos[$key]);
    }

    public function deleteImages($file_id)
    {
        deleteFileByID($file_id);
        // $this->images[$key]->delete();
        $this->mount($this->product_id);
    }

    public function submit()
    {
        $this->validate();
        if ($this->delivery == 0) {
            $this->delivery_price = null;
        }
        // let's save the product
        $save = $this->product;
        $save->name = $this->product_name;
        $save->type = $this->product->type;
        $save->description = $this->description;
        $save->price = $this->price;
        $save->user_id = $this->user_id;
        $save->category_id = $this->category_id;
        $save->url = $this->url;
        $save->subcategory_id = $this->subcategory_id;
        $save->delivery = $this->delivery;
        $save->delivery_price = $this->delivery_price;
        $save->local_pickup = $this->local_pickup;
        $save->is_sold = $this->item_sold;
        if (auth()->user()->is_owner == false) {
            $save->is_owner = false;
        } else {
            $save->is_owner = true;
        }

        // we save the attributes into data jason:
        $data = [];
        $data = $this->data;

        if (isset($this->data['gallery']) && count($this->data['gallery']) > 0) {
            $data['gallery'] = $this->data['gallery'];
        }
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
        // dd($this->data);
        // $data['mainimage'] = $this->mainimage;
        // $data['attributes'] = $this->data['attributes'];
        $save->data = $data;
        $save->save();

        // we detach shops if not in the productshops array:
        if ($save->shops()->exists()) {
            foreach ($save->shops as $shop) {
                if (!in_array($shop->id, $this->productshops)) {
                    $save->shops()->detach($shop->id);
                }
            }
        }

        // we check if productshops array is not empty and if it is not, we save the productshops. We only attach what is not already attached:
        if ($this->productshops) {
            foreach ($this->productshops as $shop_id) {
                if (!$save->shops->contains($shop_id)) {
                    $save->shops()->attach($shop_id);
                }
            }
        }
        session()->flash('popup', 'A termék módosítása sikeres volt.');
        $this->redirect("/myproducts/{$save->id}/edit");
        /*  $this->redirectRoute('myproducts.edit', ['product_id' => $save->id]);
        $this->redirectRoute('myproducts.index', navigate: true); */
    }

    public function clearSuccessMsgSession()
    {
        session()->forget('popup');
    }

    public function updatedUrl($value)
    {
        if ($value == null) {
            $this->url_error = null;
            return;
        }
        if (urlValidation($value) == false) {
            $this->url_error = 'A termék url címe nem érvényes';
        } else {
            $this->url_error = null;
        }
    }

    public function updatedProductName()
    {
        $this->product_name_lenght = strlen($this->product_name);
    }

    public function render()
    {
        return view('livewire.front.products.edit-product');
    }
}
