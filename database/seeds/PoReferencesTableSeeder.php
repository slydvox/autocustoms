<?php

use Illuminate\Database\Seeder;

class PoReferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('po_references')->delete();

        $po_references = array(
            [
                "purchase_order_id"  => 1,
                "code" => "CO",
                'value' => "00000001",
            ],
            [
                "purchase_order_id"  => 1,
                "code" => "GK",
                'value' => "41088269-1",
            ],
            [
                "purchase_order_id"  => 1,
                "code" => "IA",
                'value' => 24,
            ],
            [
                "purchase_order_id"  => 2,
                "code" => "CO",
                'value' => "00000021",
            ],
            [
                "purchase_order_id"  => 2,
                "code" => "GK",
                'value' => "41088270-4",
            ],
        );

        // Run the seeder
        DB::table('po_references')->insert($po_references);
    }
}
