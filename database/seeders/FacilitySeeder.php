<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\RealEstate\Models\Facility;
use Botble\RealEstate\Models\Property;
use Illuminate\Support\Facades\Artisan;

class FacilitySeeder extends BaseSeeder
{
    public function run()
    {
        Facility::truncate();

        $facilities = [
            [
                'name' => 'Hospital',
                'icon' => 'far fa-hospital',
            ],
            [
                'name' => 'Super Market',
                'icon' => 'fas fa-cart-plus',
            ],
            [
                'name' => 'School',
                'icon' => 'fas fa-school',
            ],
            [
                'name' => 'Entertainment',
                'icon' => 'fas fa-hotel',
            ],
            [
                'name' => 'Pharmacy',
                'icon' => 'fas fa-prescription-bottle-alt',
            ],
            [
                'name' => 'Airport',
                'icon' => 'fas fa-plane-departure',
            ],
            [
                'name' => 'Railways',
                'icon' => 'fas fa-subway',
            ],
            [
                'name' => 'Bus Stop',
                'icon' => 'fas fa-bus',
            ],
            [
                'name' => 'Beach',
                'icon' => 'fas fa-umbrella-beach',
            ],
            [
                'name' => 'Mall',
                'icon' => 'fas fa-cart-plus',
            ],
            [
                'name' => 'Bank',
                'icon' => 'fas fa-university',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Artisan::call('cms:language:sync', ['class' => Facility::class]);
        }

        foreach (Property::get() as $property) {
            $property->facilities()->detach();
            for ($i = 1; $i < 12; $i++) {
                $property->facilities()->attach($i, ['distance' => rand(1, 20) . 'km']);
            }
        }
    }
}
