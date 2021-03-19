<?php

namespace Modules\Subscription\Database\Seeders;

use App\Account;
use App\Setting;
use App\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscription\Database\Seeders\LaratrustSeeder;

class SubscriptionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(LaratrustSeeder::class);

        $account = Account::newCustomer();

        $customer = Customer::create([
            'name' => 'عميل خاص',
            'phone' => '0900000000',
            'account_id' =>  $account->id,
        ]);

        $settings = Setting::create([
            'module' => 'subscriptions',
            'name' => 'background',
            'value' => 'subscriptions.jpg',
        ]);

        // $this->call("OthersTableSeeder");
    }
}
