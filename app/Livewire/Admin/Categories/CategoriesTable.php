<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.adminapp')]
class CategoriesTable extends Component
{
    use WithPagination;
    public $modal_title             = null;
    public $category_id             = null;
    public $selected_category_id    = null;
    public $perPage                 = 15;
    public $search                  = null;
    public $error_msg               = [];
    public $categories              = [];
    public $category                = null;
    public $maincategory                = null;
    #[Rule('required', message: 'A megnevezés kötelező')]
    public $category_name           = null;
    public $category_type           = null;
    public $position                = null;

    #[On('open-category-modal-this')]
    public function openModal()
    {
        $this->resetCategoryValues();
        $this->modal_title        = 'Új kategória felvétele';
        $this->dispatch('open-admin-modal');
    }

    #[On('open-attr-modal-edit')]
    public function openEditModal($id)
    {
        $this->resetCategoryValues();
        $this->modal_title        = 'Kategória szerkesztése';
        //$this->category_id        = $id;
        $this->selected_category_id = $id;
        $this->category            = Category::find($id);
        $this->category_name       = $this->category->category_name;
        $this->maincategory        = $this->category->type;
        $this->position            = $this->category->position;
        $this->category_id         = $this->category->category_id;
        $this->updatedMaincategory($this->maincategory);
        $this->dispatch('open-admin-modal');
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->resetCategoryValues();
        $this->dispatch('close-modal');
    }

    public function save()
    {
        if ($this->category_name == null) return null;
        if ($this->selected_category_id == null) {
            $this->createCategory();
        } else {
            $this->updateCategory();
        }
    }

    private function updateCategory()
    {
        $save = Category::find($this->selected_category_id);
        $save->category_name = $this->category_name;
        $save->type = $this->maincategory;
        $save->position = $this->position;
        $save->save();
        $this->cancelSubmit();
    }

    private function createCategory()
    {
        $save = new Category;
        $save->category_name = $this->category_name;

        $save->type = $this->maincategory;
        $save->position = $this->position;
        if ($this->category_id != null) {
            $save->category_id = $this->category_id;
        }
        $save->save();
        $this->cancelSubmit();
    }

    private function resetCategoryValues()
    {
        $this->category_type        = null;
        $this->category             = null;
        $this->categories           = [];
        $this->position             = null;
        $this->modal_title          = null;
        $this->category_id          = null;
        $this->maincategory         = null;
        $this->category_name        = null;
    }

    public function render()
    {
        return view(
            'livewire.admin.categories.categories-table',
            [
                'all_categories' => Category::search($this->search)
                    ->paginate($this->perPage),
            ]
        );
    }

    public function updatedMaincategory($value)
    {
        $this->categories = Category::where('type', $value)->where('category_id', null)->get();
    }
}
