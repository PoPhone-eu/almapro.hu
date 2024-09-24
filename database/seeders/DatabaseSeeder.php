<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductAttributeValue;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Kátai';
        $user->given_name = 'László';
        $user->full_name = 'Kátai László';
        $user->email = 'klp7311@gmail.com';
        $user->role = 'admin';
        $user->password = Hash::make('161173laca');
        $user->created_at = now();
        $user->save();

        $user = new User();
        $user->name = 'Molnár';
        $user->given_name = 'Miklós';
        $user->full_name = 'Molnár Miklós';
        $user->email = 'info@nomaddigital.hu';
        $user->role = 'admin';
        $user->password = Hash::make('nomaddigital');
        $user->created_at = now();
        $user->save();

        $user = new User();
        $user->name = 'Teszt';
        $user->given_name = 'Elek';
        $user->full_name = 'Teszt Elek';
        $user->email = 'info@gmail.com';
        $user->role = 'private';
        $user->password = Hash::make('password');
        $user->provider_id = 1;
        $user->created_at = now();
        $user->save();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        /*  Hibátlan

Összességében szép

Enyhén mikrokarcos

Enyhén kopott

Közepesen mikrokarcos

Közepesen kopott

Erősen mikrokarcos

Erősen kopott

Kiskarcos

Erősen kiskarcos

Erősen karcos
generate ProductAttribute with the values above (ProductAttributeValue model in relation), ProductAttribute->value = 'All' and category_id = null
*/
        $values_array = [
            'Hibátlan' => 'Hibátlan',
            'Összességében szép' => 'Összességében szép',
            'Enyhén mikrokarcos' => 'Enyhén mikrokarcos',
            'Enyhén kopott' => 'Enyhén kopott',
            'Közepesen mikrokarcos' => 'Közepesen mikrokarcos',
            'Közepesen kopott' => 'Közepesen kopott',
            'Erősen mikrokarcos' => 'Erősen mikrokarcos',
            'Erősen kopott' => 'Erősen kopott',
            'Kiskarcos' => 'Kiskarcos',
            'Erősen kiskarcos' => 'Erősen kiskarcos',
            'Erősen karcos' => 'Erősen karcos',
        ];

        $All = new ProductAttribute();
        $All->attr_name = 'allapot';
        $All->attr_display_name = 'Állapot';
        $All->type = 'All';
        $All->position = null;
        $All->category_id = null;
        $All->save();

        foreach ($values_array as $key => $value) {
            $attr_value = new ProductAttributeValue();
            $attr_value->product_attribute_id = $All->id;
            $attr_value->value = $value;
            $attr_value->save();
        }
    }
}
