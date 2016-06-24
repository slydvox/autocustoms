<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(AddressTypesTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(PurchaseOrdersTableSeeder::class);
        $this->call(PoReferencesTableSeeder::class);
        $this->call(PoSacsTableSeeder::class);

        Eloquent::reguard();
    }
}
