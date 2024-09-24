<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\ApiSetting;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

class ApiKeysSetting extends Component
{
    public ApiSetting $ApiSetting;

    #[Rule('nullable|string')]
    public $stripe_key;

    #[Rule('nullable|string')]
    public $stripe_secret;

    #[Rule('nullable|string')]
    public $stripe_webhook_secret;

    #[Rule('nullable|string')]
    public $szamlazz_hu_api_key;

    public function mount()
    {
        // get ApiSetting first(), if null we create one.
        $this->ApiSetting = ApiSetting::firstOrCreate([
            'id' => 1,
        ]);
        $this->stripe_key = $this->ApiSetting->stripe_key;
        $this->stripe_secret = $this->ApiSetting->stripe_secret;
        $this->stripe_webhook_secret = $this->ApiSetting->stripe_webhook_secret;
        $this->szamlazz_hu_api_key = $this->ApiSetting->szamlazz_hu_api_key;
    }

    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view('livewire.admin.settings.api-keys-setting', [
            'settings' => $this->ApiSetting,
        ]);
    }


    public function updated($name, $value)
    {
        $this->ApiSetting->update([
            $name => $value,
        ]);
    }
}
