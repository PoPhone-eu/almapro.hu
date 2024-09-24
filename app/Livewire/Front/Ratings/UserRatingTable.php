<?php

namespace App\Livewire\Front\Ratings;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

class UserRatingTable extends Component
{
    use WithPagination;

    public $user_id;
    public $user;
    public $product;
    public $product_id;
    public $my_rating_content = null;
    public $my_rating = 5;
    public $already_rated = false;

    public function mount($seller_id, $product_id = null)
    {
        $this->user_id                  = $seller_id;
        $this->user                     = User::find($seller_id);
        if ($product_id != null) {
            $this->product_id               = $product_id;
            $this->product                  = Product::find($product_id);
            $this->checkIfAlreadyRated();
        } else {
            $this->product_id               = null;
            $this->product                  = null;
        }
    }

    public function addrating()
    {
        $this->checkIfAlreadyRated();
        if ($this->already_rated == false) {
            $this->resetFields();
            $this->dispatch('open-rating-modal');
        } else {
            $this->render();
        }
    }

    public function checkIfAlreadyRated()
    {   // check if user is logged in and auth()user() exists:
        if (auth()->user()) {
            $check = DB::table('reviews')->where('reviewrateable_id', $this->user_id)->where('author_id', auth()->user()->id)->where('title', $this->product->slug)->first();
            if ($check) {
                $this->already_rated = true;
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'my_rating_content' => 'nullable',
            'my_rating'         => 'required'
        ]);
        $visitor = auth()->user();
        $rating = $this->user->rating([
            'title' => $this->product->slug,
            'body' => $this->my_rating_content,
            'rating' => $this->my_rating,
            'approved' => false,
            'author_name' => $visitor->full_name,
            'seller_name' => $this->user->full_name,
        ], $visitor);

        $this->resetFields();
        $this->dispatch('close-rating-modal');
    }

    public function cancelSubmit()
    {
        $this->resetFields();
        $this->dispatch('close-rating-modal');
    }

    private function resetFields()
    {
        $this->my_rating_content        = null;
        $this->my_rating                = 5;
        $this->already_rated            = false;
    }

    public function render()
    {
        return view('livewire.front.ratings.user-rating-table', [
            'ratings' => DB::table('reviews')->where('reviewrateable_id', $this->user_id)->where('approved', true)->orderBy('created_at', 'desc')->paginate(3)
        ]);
    }
}
