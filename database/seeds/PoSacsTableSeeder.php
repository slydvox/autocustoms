<?php

use Illuminate\Database\Seeder;

class PoSacsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('po_sacs')->delete();

        $po_sacs = array(
            [
                "purchase_order_id"  => 1,
                "indicator" => "N",
                "code" => "C310",
                'amount' => 0,
            ],
            [
                "purchase_order_id"  => 1,
                "indicator" => "N",
                "code" => "H850",
                'amount' => 0,
            ],
            [
                "purchase_order_id"  => 2,
                "indicator" => "N",
                "code" => "C310",
                'amount' => 0,
            ],
            [
                "purchase_order_id"  => 2,
                "indicator" => "N",
                "code" => "G830",
                'amount' => 0,
            ],
        );

        // Run the seeder
        DB::table('po_sacs')->insert($po_sacs);
    }
}
