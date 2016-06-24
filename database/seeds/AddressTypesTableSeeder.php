<?php

use Illuminate\Database\Seeder;

class AddressTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('address_types')->delete();

        $address_types = array(
            [
                "description"  => "Bill To",
                "abbreviation" => "BT",
            ],
            [
                "description"  => "Ship To",
                "abbreviation" => "ST",
            ],
            [
                "description"  => "Sold To",
                "abbreviation" => "SO",
            ],
        );

        // Run the seeder
        DB::table('address_types')->insert($address_types);
    }
}
