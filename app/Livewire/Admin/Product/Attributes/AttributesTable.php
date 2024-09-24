<?php

namespace App\Livewire\Admin\Product\Attributes;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use App\Models\ProductAttribute;

#[Layout('layouts.adminapp')]
class AttributesTable extends Component
{
    use WithPagination;
    public $modal_title = null;
    public $attribute_id = null;
    public $attribute = null;
    public $attr_name = null;
    public $attr_display_name = null;
    public $attr_type = null;
    public $position = null;

    public $perPage = 50;
    public $search = null;
    public $error_msg = [];
    public $categories = [];
    public $subcategories = [];
    public $category_id = null;
    public $subcategory_id = null;

    private function validateNewAttribute()
    {
        // we check if there is an attribute with the same name and attr_type. If there is, we throw an error
        $check = ProductAttribute::where('attr_name', $this->attr_name)->where('type', $this->attr_type)->count();
        if ($check > 0) {
            $this->adderror_msg('attr_name', 'Ez a tulajdonság már létezik ebben a termékkategóriában');
            return false;
        }
        $this->error_msg = [];
        return true;
    }

    private function adderror_msg($field, $msg)
    {
        $this->error_msg[$field] = $msg;
    }

    public function updatedAttrName()
    {
        $check = $this->validateNewAttribute();
        if ($check == true) {
            $this->attr_display_name = $this->attr_name;
        }
    }

    public function updated($property, $value)
    {
        if ($property == 'attr_type') {
            $this->validateNewAttribute();
        }
    }

    #[On('open-attr-modal-this')]
    public function openModal()
    {
        $this->resetAttributValues();
        $this->modal_title        = 'Új tulajdonság felvétele';
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
        $this->attr_name            = null;
        $this->attr_display_name    = null;
        $this->attr_type            = null;
        $this->position             = null;
        $this->attribute_id         = null;
        $this->subcategory_id       = null;
        $this->attribute            = null;
        $this->modal_title          = null;
    }

    #[On('open-attr-modal-edit')]
    public function selectedAttribute($attr_id)
    {
        $this->attribute_id             = $attr_id;
        $this->attribute                = ProductAttribute::find($attr_id);
        $this->attr_name                = $this->attribute->attr_name;
        $this->attr_display_name        = $this->attribute->attr_display_name;
        $this->attr_type                = $this->attribute->type;
        $this->position                 = $this->attribute->position;
        $this->modal_title              = 'Tulajdonság módosítása';

        $this->dispatch('open-admin-modal');
    }

    //#[On('save')]
    public function save()
    {
        if ($this->attribute_id == null) {
            $check = $this->validateNewAttribute();
            if ($check == false) {
                return;
            }

            $this->createAttribute();
        } else {
            $this->updateAttribute();
        }

        $this->dispatch('close-modal');
    }

    private function createAttribute()
    {
        $check = $this->validateNewAttribute();
        if ($check == false) {
            return;
        }
        $save = new ProductAttribute();
        $save->attr_name = $this->attr_name;
        $save->attr_display_name = $this->attr_display_name;
        $save->type = $this->attr_type;
        $save->position = $this->position;
        $save->category_id = $this->subcategory_id;
        $save->save();
        $this->resetAttributValues();
    }

    private function updateAttribute()
    {
        $update = ProductAttribute::find($this->attribute_id);
        $update->attr_name = $this->attr_name;
        $update->attr_display_name = $this->attr_display_name;
        $update->type = $this->attr_type;
        $update->position = $this->position;
        $update->update();
        $this->resetAttributValues();
    }

    public function updatedCategoryId($value)
    {
        $this->subcategories = Category::where('category_id', $value)->get();
    }

    public function updatedAttrType($value)
    {
        $this->categories = Category::where('type', $value)->where('category_id', null)->get();
    }

    #[On('deleteAttribute')]
    public function deleteAttribute($attr_id)
    {
        $delete = ProductAttribute::find($attr_id);
        $delete->delete();
    }

    public function render()
    {
        return view('livewire.admin.product.attributes.attributes-table', [
            'attributes' => ProductAttribute::search($this->search)
                ->paginate($this->perPage),
        ]);
    }
}
