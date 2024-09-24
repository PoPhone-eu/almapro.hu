<?php

namespace App\Livewire\Front\Menus;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Services\UserMessagesService;

class Productpage extends Component
{
    use WithPagination;

    public $product_id;
    public $product;
    public $mainimage;
    public $images;
    public $selected_image;
    public $data = [];
    public $all_images;
    public $user;
    public $seller_id;
    public $seller;
    public $selected_product_id;
    public $selected_product;
    public $selected_seller_id;
    #[Rule('required')]
    public $msg_body;
    public $is_order = false;
    public $title = 'Ajánlatot teszek';
    public $last_online;

    public function mount($product_id)
    {
        $this->product_id               = $product_id;
        $this->product                  = Product::find($product_id);
        $this->user                     = $this->product->user;
        $this->seller_id                = $this->user->id;
        $this->seller                   = $this->user;
        $this->data                     = $this->product->data;
        //dd($this->data);
        $this->mainimage                = $this->data['mainimage'];
        $this->selected_image           = $this->product->getMedia('mainimage')->first();
        $this->all_images               = $this->product->getMedia('gallery');
        if ($this->user->is_owner == true) {
            $this->last_online = 'nemrég';
        } else {
            $this->last_online = \Carbon\Carbon::parse($this->user->updated_at)->diffForHumans();
        }
        /*  if (isset($this->data['gallery']) && count($this->data['gallery']) > 0) {
            $this->images               = $this->data['gallery'];
            foreach ($this->images as $image) {
                $this->all_images[]     = $image;
            }
        } */
        // remove "background-color: rgb(255, 255, 255); color: rgb(38, 38, 35);" from $product->description
        $this->product->description = str_replace('background-color: rgb(255, 255, 255); color: rgb(38, 38, 35);', '', $this->product->description);
        /* $user = auth()->user();
        $customer = User::find(5); */
        /* $rating = $user->rating([
            'title' => $this->product->slug,
            'body' => 'Meg voltam elégedve a termékkel.',
            'rating' => 4.5,
            'recommend' => 'Yes',
            'approved' => true,
        ], $customer); */
    }

    public function handleSlider()
    {
        // we tak all images and only show 4 of them in the slider. So we cleate the slider image arry with the first 4 images. The first image is the main image at first
        // when user arives to the page, the main image is the first image in the slider. When user clicks on an image in the slider,
        // we change the main image to the selected image. When there are more then 4 images we show a down-arrow button in the slider.
        // When user clicks on the down-arrow button, we take the first image wand and the next image at the end of the array
    }

    public function setSelectedImage($image_id)
    {
        $this->selected_image = $this->all_images->where('id', $image_id)->first();
    }

    public function sendOrder($product_id)
    {
        // open modal for composing message to user with role=company
        // it is a similar message as a normal compose message, but the subject is different as it is an order.
        $this->selected_product_id = $product_id;
        $this->selected_product = Product::find($product_id);
        $this->selected_seller_id = $this->selected_product->user_id;
        $this->msg_body = 'Szeretném megrendelni a(z) ' . $this->selected_product->name . ' terméket.';
        $this->is_order = true;
        $this->title = 'Megrendelés';
        $this->dispatch('open-admin-modal');
    }

    public function submitorder()
    {
        $product_name = $this->selected_product->name;
        UserMessagesService::sendOrderMessage(auth()->user()->id, $this->selected_seller_id, $this->msg_body, $this->selected_product_id, "Megrendelés a(z) $product_name termékre");

        $this->cancelSubmit();
        $this->js("alert('A megrendelésedet elküldtük!')");
    }

    // addFavorite
    public function addFavorite($product_id)
    {
        $product = Product::find($product_id);
        $user = auth()->user();
        $favorite = $user->favorites()->where('product_id', $product_id)->first();
        if ($favorite) {
            $favorite->delete();
        } else {
            $user->favorites()->create([
                'product_id' => $product_id,
                'name' => $product->name,
            ]);
        }
    }

    public function compose($product_id)
    {
        $this->is_order = false;
        $this->title = 'Ajánlatot teszek';
        $this->selected_product_id = $product_id;
        $this->selected_product = Product::find($product_id);
        $this->selected_seller_id = $this->selected_product->user_id;
        $this->msg_body = null;
        // open modal for composing message
        $this->dispatch('open-admin-modal');
    }

    #[On('submit')]
    public function submit()
    {
        $this->validate([
            'msg_body' => 'required',
        ]);
        if ($this->msg_body == null) return;
        $product_name = $this->selected_product->name;
        UserMessagesService::sendMessage(auth()->user()->id, $this->selected_seller_id, $this->msg_body, $this->selected_product_id, "Érdeklődés a(z) $product_name termékkel kapcsolatban");

        $this->cancelSubmit();
    }

    public function cancelSubmit()
    {
        $this->is_order = false;
        $this->title = '';
        $this->msg_body = null;
        $this->selected_product_id = null;
        $this->selected_product = null;
        $this->selected_seller_id = null;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view(
            'livewire.front.menus.productpage',
            [
                'others_view_these' => Product::where('id', '!=', $this->product_id)->inRandomOrder()->limit(4)->get(),
                'kiegeszitok' => Product::where('type', 'others')->inRandomOrder()->limit(4)->get(),
            ]
        );
    }
}
