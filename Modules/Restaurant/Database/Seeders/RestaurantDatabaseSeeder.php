<?php

namespace Modules\Restaurant\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Restaurant\Database\Seeders\LaratrustSeeder;

class RestaurantDatabaseSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
    }
}