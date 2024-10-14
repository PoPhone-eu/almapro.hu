<?php

namespace App\Livewire\Front\Menus;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class Maincategory extends Component
{
    public $product_type;
    public $perPage = 16;

    #[Url(keep: true)]
    public $search = '';
    public $sidebar_items = [];
    public $selected_category_id;

    public $selected_category;
    public $filters = [];
    public $subfilters = [];
    public $title;
    public $ids_search = [];
    public $sidebarStyle = '';
    public $is_main_category = true;

    public $selected_filters = [];
    public $navigation_stack = []; // Added property for navigation history

    public function mount($product_type)
    {
        $this->product_type = $product_type;
        $this->title = $product_type;
        $this->sidebar_items = Category::where('type', $product_type)->where('category_id', null)->orderBy('position')->get();
    }
    public function loadMore()
    {
        $this->perPage += 16;
    }

    public function set_selected_category_id($category_id)
    { // Push current state to the navigation stack before changing it
        $this->navigation_stack[] = [
            'selected_category_id' => $this->selected_category_id,
            'selected_filters' => $this->selected_filters,
            'is_main_category' => $this->is_main_category,
            'title' => $this->title,
            'sidebar_items' => $this->sidebar_items,
            'filters' => $this->filters,
            'subfilters' => $this->subfilters,
            'ids_search' => $this->ids_search,
            'sidebarStyle' => $this->sidebarStyle,
        ];


        $this->selected_category_id = $category_id;
        $this->selected_category = Category::find($category_id);
        $cat = Category::find($category_id);
        if ($cat->category_id == null) {
            $this->is_main_category = true;
            $this->title = $this->product_type . '-' . $cat->category_name;
            $this->sidebar_items = Category::where('type', $this->product_type)->where('category_id', $category_id)->orderBy('position')->get();
            $sidebar_items_ids = Category::where('type', $this->product_type)->where('category_id', $category_id)->orderBy('position')->pluck('id')->toArray();
            $sidebar_items_ids = Arr::flatten($sidebar_items_ids);
            $this->filters = ProductAttribute::whereIn('category_id', $sidebar_items_ids)->orderBy('position')->get();
            $this->subfilters = [];
            // get all IDs of the selected category and its children
            $this->ids_search = Category::where('type', $this->product_type)->where('category_id', $category_id)->pluck('id')->toArray();
            $this->ids_search = Arr::flatten($this->ids_search);
            if ($this->sidebar_items->count() == 0) {
                $this->sidebarStyle = 'display: none;';
            } else {
                $this->sidebarStyle = '';
            }
        } else {
            $this->is_main_category = false;
            // get all IDs of the selected category and its parents all up
            $this->ids_search = [];
            $this->ids_search[] = $category_id;
            $this->ids_search[] = $cat->category_id;
            $IDs = Category::where('type', $this->product_type)->where('category_id', $cat->category_id)->orderBy('position')->pluck('id')->toArray();
            $IDs = Arr::flatten($IDs);
            $this->ids_search = array_merge($this->ids_search, $IDs);

            $sub = Category::find($cat->category_id);
            $this->title = $this->product_type . '-' . $sub->category_name . '-' . $cat->category_name;
            $this->filters = [];
            $this->sidebar_items = [];
            $this->sidebarStyle = '';
            $this->subfilters = ProductAttribute::where('category_id', $category_id)->orderBy('position')->get();
        }
    }

    public function set_selected_filter_id($attr_id, $prod_attr_value)
    {
        foreach ($this->selected_filters as $key => $value) {
            foreach ($value as $k => $v) {
                if ($key == $attr_id && $v == $prod_attr_value) {
                    unset($this->selected_filters[$key][$k]);
                    if (count($this->selected_filters[$key]) == 0) {
                        unset($this->selected_filters[$key]);
                    }
                    return;
                }
            }
        }
        $this->selected_filters[$attr_id][] = $prod_attr_value;

        return;
    }

    public function back()
    {
        // Check if there's a previous state in the stack
        if (count($this->navigation_stack) > 0) {
            // Pop the last state from the stack and restore it
            $last_state = array_pop($this->navigation_stack);

            $this->selected_category_id = $last_state['selected_category_id'];
            $this->selected_filters = $last_state['selected_filters'];
            $this->is_main_category = $last_state['is_main_category'];
            $this->title = $last_state['title'];
            $this->sidebar_items = $last_state['sidebar_items'];
            $this->filters = $last_state['filters'];
            $this->subfilters = $last_state['subfilters'];
            $this->ids_search = $last_state['ids_search'];
            $this->sidebarStyle = $last_state['sidebarStyle'];
        }
    }

    public function render()
    {
        $search = $this->search;
        $selected_filters = $this->selected_filters;
        $selected_category_id = $this->selected_category_id;
        // if $this->ids_search is not empty we merge it with the selected category id
        if (!empty($this->ids_search)) {
            $this->ids_search[] = $selected_category_id;
        }
        //dd($this->sidebar_items);
        $ids_search = $this->ids_search;
        if ($this->is_main_category == true) {
            return view('livewire.front.menus.maincategory', [
                'products' => Product::where('type', $this->product_type)
                    ->where('is_sold', false)
                    ->where('is_featured', false)
                    ->when($this->search  != null, function ($query) use ($search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->when($this->selected_category_id != null, function ($query) use ($selected_category_id) {
                        return $query->where('category_id', $selected_category_id);
                    })
                    ->when(count($this->selected_filters) > 0, function ($query) use ($selected_filters) {
                        return $query->where(function ($query) use ($selected_filters) {
                            foreach ($selected_filters as $filter_key => $filter) {
                                $filter_key = $filter_key . '->value';
                                foreach ($filter as $key => $value) {
                                    $query->orWhereJsonContains("data->attributes->$filter_key", $value);
                                }
                            }
                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage),
                'featured_products' => Product::where('is_featured', true)->where('is_sold', false)
                    ->where('type', $this->product_type)
                    // where today is between featured_from and featured_to dates:
                    ->whereDate('featured_from', '<=', now())->whereDate('featured_to', '>=', now())
                    ->when($this->selected_category_id != null, function ($query) use ($selected_category_id) {
                        return $query->where('category_id', $selected_category_id);
                    })
                    ->orderBy('featured_from', 'desc')->get()
            ]);
        } else {
            return view('livewire.front.menus.maincategory', [
                'products' => Product::where('type', $this->product_type)
                    ->where('is_sold', false)
                    ->where('is_featured', false)
                    ->when($this->search  != null, function ($query) use ($search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->when($this->selected_category_id != null, function ($query) use ($selected_category_id) {
                        return $query->where('subcategory_id', $selected_category_id);
                    })
                    ->when(count($this->selected_filters) > 0, function ($query) use ($selected_filters) {
                        return $query->where(function ($query) use ($selected_filters) {
                            foreach ($selected_filters as $filter_key => $filter) {
                                $filter_key = $filter_key . '->value';
                                foreach ($filter as $key => $value) {
                                    $query->orWhereJsonContains("data->attributes->$filter_key", $value);
                                }
                            }
                        });
                    })

                    ->orderBy('created_at', 'desc')
                    ->paginate($this->perPage),
                'featured_products' => Product::where('is_featured', true)->where('is_sold', false)
                    ->where('type', $this->product_type)
                    // where today is between featured_from and featured_to dates:
                    ->whereDate('featured_from', '<=', now())->whereDate('featured_to', '>=', now())
                    ->when($this->selected_category_id != null, function ($query) use ($selected_category_id) {
                        return $query->where('subcategory_id', $selected_category_id);
                    })
                    ->orderBy('featured_from', 'desc')->get()
            ]);
        }
    }
}
