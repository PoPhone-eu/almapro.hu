<?php

namespace App\Livewire\Admin\Banners;

use App\Models\Banner;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.adminapp')]
class BannersTable extends Component
{
    use WithPagination;
    public $perPage = 50;
    public $search = '';
    public $error_msg = [];

    public function deleteBanner($id)
    {
        $banner = Banner::find($id);
        // find the images and delete them too:
        if ($banner->normal_image != null) {
            Storage::disk('public')->delete($banner->normal_image);
        }
        $banner->delete();
        session()->flash('success', 'Banner sikeresen törölve!');
    }

    public function render()
    {
        /* $banner = Banner::where('id', 11)->first();
        dd($banner->positions); */
        $search = '%' . $this->search . '%';
        return view('livewire.admin.banners.banners-table', [
            'banners' => Banner::with('user', 'positions')
                ->when($this->search != '', function ($query) use ($search) {
                    return $query->whereHas('user', function ($query) use ($search) {
                        $query->where('full_name', 'like', $search)
                            ->orWhere('email', 'like', $search)
                            ->orWhere('banners.invoice_number', 'like', $search);
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
