<?php

namespace App\Livewire\Admin\Product\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\MyFavorite;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.adminapp')]
class ProductsTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = null;

    public function deleteProduct($product_id)
    {
        $product = Product::withTrashed()->where('id', $product_id)->first();
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

    public function restoreProduct($product_id)
    {
        $product = Product::where('id', $product_id)->withTrashed()->first();
        $product->restore();
        session()->flash('success', 'A termék sikeresen vissza lett állítva.');
    }

    public function render()
    {
        /* $prod = Product::find(1);
        $images = $prod->getMedia('mainimage')->first();
        dd($images); */
        return view(
            'livewire.admin.product.products.products-table',
            [
                'products' => Product::search($this->search)->withTrashed()->orderBy('created_at', 'desc')->paginate($this->perPage),
            ]
        );
    }
}
