<?php

namespace App\Livewire\User\Products;

use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyFavorite;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.adminapp')]
class UserProductsTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = null;
    public $modal_title = null;
    public $user_id;
    public $user;
    public $categories = [];
    public $subcategories = [];
    public $category_id = null;
    public $subcategory_id = null;
    public $attr_type = null;

    public function mount($id)
    {
        $this->attr_type = null;
        $this->user_id = $id;
        $this->user = User::find($id);

        //Storage::disk('public')->delete('mLmEzZ1ljrsiEM3Up4j50iRYmbrZROKMZhUEbAr7.webp');
    }

    public function deleteProduct($product_id)
    {
        $product = $this->user->products()->withTrashed()->where('id', $product_id)->first();
        MyFavorite::where('product_id', $product_id)->delete();
        // first we delete all images of the product. First we delete the main image from data['mainimage'] and then we delete the other images from data['photos'
        $data = $product->data;
        if (isset($data['mainimage'])) {
            $main_image_name = $data['mainimage'];
            try {
                Storage::disk('public')->delete($main_image_name);
            } catch (\Throwable $th) {
                logger($th);
            }
        }


        if (isset($data['gallery'])) {
            try {
                foreach ($data['gallery'] as $image) {
                    Storage::disk('public')->delete($image);
                }
            } catch (\Throwable $th) {
                logger($th);
            }
        }
        // we detach the shops of the product if exists
        if ($product->shops()->exists()) {
            $product->shops()->detach();
        }
        $product->forceDelete();
        session()->flash('success', 'A termék sikeresen törölve lett.');
    }

    #[On('open-attr-modal-this')]
    public function openModal()
    {
        $this->resetAttributValues();
        $this->modal_title        = 'Válaszd ki a termék kategóriáját';
        $this->dispatch('open-admin-modal');
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->resetAttributValues();
        $this->dispatch('close-modal');
    }

    private function resetAttributValues()
    {
        $this->attr_type            = null;
        $this->subcategory_id       = null;
        $this->modal_title          = null;
        $this->subcategories = [];
        $this->categories = [];
    }

    public function save()
    {
        // redirect to '/addproduct/ with the attr_type the category_id and subcategory_id
        $this->validate([
            'attr_type' => ['required'],
            'category_id' => ['required'],
            'subcategory_id' => ['required'],
        ]);
        $this->redirect('/addproduct/' . $this->user_id . '/' . $this->attr_type . '/' . $this->category_id . '/' . $this->subcategory_id);
    }

    public function updatedCategoryId($value)
    {
        if ($this->attr_type == null) {
            $this->category_id = null;
            $this->categories = [];
            $this->subcategories = [];
            return;
        }
        //$this->categories = Category::where('id', $value)->where('category_id', null)->where('type', $this->attr_type)->get();
        $this->subcategories = Category::where('category_id', $value)->where('type', $this->attr_type)->get();
        //dd($this->subcategories);
    }

    public function updatedAttrType($value)
    {
        if ($this->attr_type == null) {
            $this->category_id = null;
            $this->categories = [];
            $this->subcategories = [];
            return;
        }
        $this->categories = Category::where('type', $value)->where('category_id', null)->get();
        $this->subcategories = [];
    }

    public function restoreProduct($product_id)
    {
        $product = $this->user->products()->where('id', $product_id)->withTrashed()->first();
        $product->restore();
        session()->flash('success', 'A termék sikeresen vissza lett állítva.');
    }

    public function render()
    {
        return view('livewire.user.products.user-products-table', [
            'products' => $this->user->products()->withTrashed()->orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }
}
