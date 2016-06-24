<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('addresses')->delete();

        $addresses = array(
            [
                "user_id"         => 1,
                "address_type_id" => 1,
                "address"         => "2303 S.E. 17th St.",
                "address2"        => "Ste 102",
                "city"            => "Ocala",
                "state"           => "FL",
                "zip"             => "34471",
                "country"         => "U.S.A.",
            ],
            [
                "user_id"         => 2,
                "address_type_id" => 1,
                "address"         => "240 Smith Road",
                "address2"        => null,
                "city"            => "Osteen",
                "state"           => "FL",
                "zip"             => "32764",
                "country"         => "U.S.A.",
            ],
            [
                "user_id"         => 2,
                "address_type_id" => 2,
                "address"         => "1234 This Street",
                "address2"        => "Ste 321",
                "city"            => "Orlando",
                "state"           => "FL",
                "zip"             => "32123",
                "country"         => "U.S.A.",
            ],
            [
                "user_id"         => 3,
                "address_type_id" => 1,
                "address"         => "1002 Maple Ave",
                "address2"        => null,
                "city"            => "Miami",
                "state"           => "FL",
                "zip"             => "33309",
                "country"         => "U.S.A.",
            ],
        );

        // Run the seeder
        DB::table('addresses')->insert($addresses);
    }
}
