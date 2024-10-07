<?php

namespace App\Livewire\Front\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\MyFavorite;
use App\Models\UserPoint;
use App\Models\SiteSetting;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;

class Myproducts extends Component
{
    use WithPagination;

    public $perPage = 35;
    public $search = null;
    public $modal_title = null;
    public $user_id;
    public $user;
    public $categories = [];
    public $subcategories = [];
    public $category_id = null;
    public $subcategory_id = null;
    public $attr_type = null;
    public $user_points = 0;
    public $siteSettings;
    public $termektipus;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->user = auth()->user();
        $this->user_points = getUserPoints($this->user_id);
        $this->siteSettings = SiteSetting::first();
        $this->termektipus = \App\Models\Product::TYPES;
        // check if there is Catefory type with all the termektipus (count them) and if any is zero we remove it from the termektipus array
        $categories = Category::where('category_id', null)->get();
        foreach ($this->termektipus as $key => $value) {
            $count = Category::where('type', $key)->count();
            if ($count == 0) {
                $termektipus_id_to_remove[] = $key;
            }
        }
        foreach ($termektipus_id_to_remove as $key) {
            unset($this->termektipus[$key]);
        }
        //Storage::disk('public')->delete('mLmEzZ1ljrsiEM3Up4j50iRYmbrZROKMZhUEbAr7.webp');
    }

    public function deleteProduct($slug)
    {
        $product = $this->user->products()->where('slug', $slug)->first();
        $product_id = $product->id;
        $product->delete();
        // we delete all MyFavoriteProduct records with the product_id
        MyFavorite::where('product_id', $product_id)->delete();
        session()->flash('success', 'A termék sikeresen törölve lett.');
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

    #[On('open-attr-modal-this')]
    public function openModal()
    {
        $this->resetAttributValues();
        $this->modal_title        = 'Válaszd ki a termék kategóriáját';
        $this->dispatch('open-admin-modal');
    }

    public function save()
    {
        if ($this->attr_type == 'Samsung'  || $this->attr_type == 'Android' || $this->attr_type == 'egyeb') {
            $this->redirectRoute('myproducts.create', ['attr_type' => $this->attr_type, 'category_id' => $this->category_id], navigate: true);
        } else {
            $this->validate([
                'attr_type' => ['required'],
                'category_id' => ['required'],
                'subcategory_id' => ['nullable'],
            ]);
        }
        // redirect to '/addproduct/ with the attr_type the category_id and subcategory_id

        $this->redirectRoute('myproducts.create', ['attr_type' => $this->attr_type, 'category_id' => $this->category_id, 'subcategory_id' => $this->subcategory_id], navigate: true);
    }

    public function updatedCategoryId($value)
    {
        $this->subcategories = Category::where('category_id', $value)->orderBy('position')->get();
    }

    public function updatedAttrType($value)
    {
        $this->categories = Category::where('type', $value)->where('category_id', null)->orderBy('position')->get();
        if ($this->attr_type == 'Samsung' || $this->attr_type == 'Android' || $this->attr_type == 'egyeb') {
            $cat = Category::where('type', $value)->where('category_id', null)->first();
            $this->category_id = $cat->id;
            $this->subcategory_id = null;
        }
    }

    public function makeFeatured($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product == null) {
            session()->flash('error', 'A termék nem található.');
            return;
        }
        if ($this->user_points < $this->siteSettings->featured_price) {
            // redirect to payment page
            return redirect()->to('/payment');
        }
        $point_model = getUserPointModel($this->user_id);
        $remaining_points = $point_model->points - $this->siteSettings->featured_price;
        // create new user point model and point is $point_model->points - 100
        UserPoint::create([
            'points' => $remaining_points,
            'description' => 'Pont felhasználása: kiemelés',
            'modified_by' => 'user',
            'user_id' => auth()->user()->id,
        ]);
        $product->is_featured = true;
        // update the featured_from and featured_to dates. featured_from is today, featured_to is today + 7 days
        $product->featured_from = now();
        $product->featured_to = now()->addDays($this->siteSettings->featured_days);
        $product->save();
        $this->dispatch('featuresuccess', remaining_points: $remaining_points);
    }

    public function render()
    {
        $search = $this->search;
        return view(
            'livewire.front.products.myproducts',
            [
                'products' => $this->user->products()
                    ->when($this->search, function ($query) use ($search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage),
            ]
        );
    }
}
