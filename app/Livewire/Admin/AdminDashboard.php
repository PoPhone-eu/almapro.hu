<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class AdminDashboard extends Component
{
    public $site_settings;

    public function mount()
    {
        $this->site_settings = \App\Models\SiteSetting::first();
    }

    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
