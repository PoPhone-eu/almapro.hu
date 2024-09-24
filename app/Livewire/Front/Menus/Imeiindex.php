<?php

namespace App\Livewire\Front\Menus;

use Livewire\Component;
use App\Models\UserPoint;
use App\Models\SiteSetting;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Log;

class Imeiindex extends Component
{
    public $phone_type = 'iPhone';
    public $IPhone_border = 'iphone-border';
    public $Samsung_border = '';
    public $imei_number;
    public $imei_result;
    public $API_URL = 'https://sickw.com/api.php?format=beta';
    public $API_USER = 'kovacs.szilvia@pophone.eu';
    public $API_KEY = 'GSP-9MU-HGJ-6RV-2SV-QEC-7ZW-F0N';
    public $api_result;
    public $imei_price;
    public $site_settings;
    public $user_id;
    public $user;
    public $user_points;
    public $api_result_array;
    public $api_result_error;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->user = auth()->user();
        $this->user_points = getUserPoints($this->user_id);
        $this->site_settings = SiteSetting::first();
        $this->imei_price = $this->site_settings->imei_price;
        $this->imei_number = null;
        $this->imei_result = null;
        $this->api_result = null;
        /*  $result = [
            'Model Description' => 'IPHONE 11 BLACK 64GB-LAE',
            'Model'             => 'iPhone 11 64GB Black Cellular [A2221] [iPhone12,1]',
            'IMEI'              => '356656420245275',
            'IMEI2'             => '356656420034778',
            'MEID'              => '35665642024527',
            'Serial Number'     => 'FFWJQYD9N735',
            'Warranty Status'   => 'Out Of Warranty',
            'Estimated Purchase Date' => '2022-12-21',
            'iCloud Lock'       => 'ON',
            'iCloud Status'     => 'Clean',
            'Demo Unit'         => 'No',
            'Loaner Device'     => 'No',
            'Replaced Device'   => 'No',
            'Replacement Device' => 'No',
            'Refurbished Device' => 'No',
            'Blacklist Status'  => 'Clean',
            'Purchase Country'  => 'Mexico',
            'Sim-Lock Status'   => 'Locked'
        ];
        $this->api_result['status'] = 'success';
        $this->api_result['result'] = $result; */
    }

    public function save()
    {
        $this->api_result_error = null;
        if ($this->user_points < $this->site_settings->imei_price) {
            // redirect to payment page
            return redirect()->to('/payment');
        }

        // 356656420245275  teszt IMEI
        $this->api_result = null;
        /* $this->validate([
            'imei_number' => ['required', 'string'],
        ]); */
        if ($this->imei_number == null) {
            $this->api_result_error = 'Írd be a telefon azonosítóját, IMEI számát vagy sorozatszámát!';
            return;
        }
        $service = '';
        $this->api_result  = null;
        $imei_number = $this->imei_number;
        $this->imei_number = null;
        if ($this->phone_type == 'iPhone') {
            // FREE - APPLE BASIC INFO
            $service = '30';
            $this->curl($service, $imei_number);
        } else {
            // samsung: 350000026537916
            $service = '80';
            $this->curl($service, $imei_number);
        }
        // teszt array from:
        /* $result = [
            'Model Description' => 'IPHONE 11 BLACK 64GB-LAE',
            'Model'             => 'iPhone 11 64GB Black Cellular [A2221] [iPhone12,1]',
            'IMEI'              => '356656420245275',
            'IMEI2'             => '356656420034778',
            'MEID'              => '35665642024527',
            'Serial Number'     => 'FFWJQYD9N735',
            'Warranty Status'   => 'Out Of Warranty',
            'Estimated Purchase Date' => '2022-12-21',
            'iCloud Lock'       => 'ON',
            'iCloud Status'     => 'Clean',
            'Demo Unit'         => 'No',
            'Loaner Device'     => 'No',
            'Replaced Device'   => 'No',
            'Replacement Device' => 'No',
            'Refurbished Device' => 'No',
            'Blacklist Status'  => 'Clean',
            'Purchase Country'  => 'Mexico',
            'Sim-Lock Status'   => 'Locked'
        ];
        $this->api_result = $result; */
        $this->api_result_array =  null;
        if ($this->api_result != null) {
            $this->dedactPoints();
            $this->api_result_array = [];
            if ($this->phone_type == 'iPhone') {
                foreach ($this->api_result as $key => $value) {
                    $this->api_result_array[\App\Models\Product::IMEI_30[$key]] = $value;
                }
            } else {
                foreach ($this->api_result as $key => $value) {
                    $this->api_result_array[\App\Models\Product::IMEI_80[$key]] = $value;
                }
            }
        } else {
            $this->api_result_error = 'A lekérdezés sikertelen volt, kérlek nézd meg, hogy a beírt IMEI szám/sorozatszám nincs
                    elgépelve stb. Pontok nem lettek levonva...';
        }
    }

    private function dedactPoints()
    {
        $point_model = getUserPointModel($this->user_id);
        $remaining_points = $point_model->points - $this->site_settings->imei_price;
        // create new user point model and point is $point_model->points - 100
        UserPoint::create([
            'points' => $remaining_points,
            'description' => 'Pont felhasználása: Telefon IMEI lekérdezés',
            'modified_by' => 'user',
            'user_id' => auth()->user()->id,
        ]);
        $this->user_points = getUserPoints($this->user_id);
    }

    private function curl($service, $imei_number)
    {
        $url = $this->API_URL . '&key=' . $this->API_KEY . '&imei=' . $imei_number . '&service=' . $service;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($curl);
        curl_close($curl);
        /*  if (isset($result['status']) && $result['status'] == 'success') {
            logger($result['result']);
            $this->api_result = $result['result'];
            logger($this->api_result);
            return;
        } */

        $result = json_decode($result, true);
        if (isset($result['result'])) {
            logger($result);
            $this->api_result = $result['result'];
            $this->site_settings->sickw_alance = $result['balance'];
            $this->site_settings->save();
        } else {
            $this->api_result = null;
        }
        /*  logger($result);
        logger($this->api_result); */
        return;
    }

    public function changePhoneType($value)
    {
        if ($value == 'iPhone') {
            $this->Samsung_border = '';
            $this->IPhone_border = 'iphone-border';
        } else {
            $this->IPhone_border = '';
            $this->Samsung_border = 'iphone-border';
        }
        $this->phone_type = $value;
    }

    public function updatedImeiNumber($value)
    {
        $this->api_result = null;
        $this->api_result_array = null;
        $this->api_result_error = null;
    }

    public function render()
    {
        return view('livewire.front.menus.imeiindex');
    }
}
