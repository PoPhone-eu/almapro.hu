<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('layouts.adminapp')]
class SiteSettingEdit extends Component
{
    public $min_points;
    public $featured_price;
    public $featured_days;
    public $register_award;
    public $register_awared_points;
    public $imei_price;

    public function mount()
    {
        $sitesettings = \App\Models\SiteSetting::first();
        $this->min_points = $sitesettings->min_points;
        $this->featured_price = $sitesettings->featured_price;
        $this->featured_days = $sitesettings->featured_days;
        $this->register_award = $sitesettings->register_award;
        $this->register_awared_points = $sitesettings->register_awared_points;
        $this->imei_price = $sitesettings->imei_price;
    }

    public function updated($property, $value)
    {
        if ($property != 'register_award' && $value == null) {
            return;
        }
        $this->$property = $value;
        $this->updateSiteSettingsData();
    }

    private function updateSiteSettingsData()
    {
        $sitesettings = \App\Models\SiteSetting::first();
        $sitesettings->update([
            'min_points' => $this->min_points,
            'featured_price' => $this->featured_price,
            'featured_days' => $this->featured_days,
            'register_award' => $this->register_award,
            'register_awared_points' => $this->register_awared_points,
            'imei_price' => $this->imei_price,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings.site-setting-edit', [
            'sitesettings' => \App\Models\SiteSetting::first()
        ]);
    }
}
