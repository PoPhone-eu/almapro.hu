<?php

namespace App\Livewire\Admin\Product\Attributes;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

#[Layout('layouts.adminapp')]
class AttributeValues extends Component
{
    use WithPagination;
    public $perPage = 30;
    public $search = '';
    public $attribute;
    public $attr_id;
    public $new_value_id = null;
    public $new_value = null;
    public $new_rgb = null;
    public $position = null;
    public $modal_title = null;
    public $error_msg = [];

    public function mount($attr_id)
    {
        $this->attribute = ProductAttribute::find($attr_id);
        $this->attr_id = $attr_id;
    }

    private function adderror_msg($field, $msg)
    {
        $this->error_msg[$field] = $msg;
    }

    #[On('open-value-modal-this')]
    public function openModal()
    {
        $this->resetAttributValues();
        $this->modal_title        = 'Új érték/megnevezés felvétele';
        $this->dispatch('open-admin-modal');
    }


    #[On('open-value-modal-edit')]
    public function selectedValue($value_id)
    {
        $this->new_value_id             = $value_id;
        $new_value                      = ProductAttributeValue::find($value_id);
        $this->new_value                = $new_value->value;
        $this->new_rgb                  = $new_value->rgb;
        $this->position                 = $new_value->position;
        $this->modal_title              = 'Érték/megnevezés módosítása';
        $this->dispatch('open-admin-modal');
    }

    private function resetAttributValues()
    {
        $this->new_value            = null;
        $this->new_rgb              = null;
        $this->position             = null;
        $this->new_value_id          = null;
        $this->modal_title          = null;
    }

    private function validateNewValue()
    {
        if ($this->new_value == null) {
            $this->adderror_msg('new_value', 'Adj meg egy értéket!');
            return false;
        }
        $this->error_msg = [];
        return true;
    }

    public function submit()
    {
        $this->validateNewValue();

        if ($this->new_value_id == null) {
            $check = $this->validateNewValue();
            if ($check == false) {
                return;
            }
            $this->createValue();
        } else {
            $this->updateValue();
        }

        $this->cancelSubmit();
    }

    private function updateValue()
    {
        $update = ProductAttributeValue::find($this->new_value_id);
        $update->value = $this->new_value;
        $update->rgb = $this->new_rgb;
        $update->update();
    }

    private function createValue()
    {
        $save = new ProductAttributeValue();
        $save->value = $this->new_value;
        $save->rgb = $this->new_rgb;
        $save->product_attribute_id = $this->attr_id;
        $save->position = getPositionForModelSingle('ProductAttributeValue');
        $save->save();
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->resetAttributValues();
        $this->dispatch('close-modal');
    }

    #[On('deleteValue')]
    public function deleteValue($value_id)
    {
        $delete = ProductAttributeValue::find($value_id);
        $delete->delete();
    }


    public function updateOrder($list)
    {
        foreach ($list as $item) {
            $update = ProductAttributeValue::findOrFail($item['value']);
            $update->position = $item['order'];
            $update->save();
        }
    }

    public function render()
    {
        return view('livewire.admin.product.attributes.attribute-values', [
            'attr_values' => ProductAttributeValue::search($this->search)->where('product_attribute_id', $this->attribute->id)->orderBy('position')->paginate($this->perPage),
        ]);
    }
}
