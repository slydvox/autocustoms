<?php

use Illuminate\Database\Seeder;

class PurchaseOrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('purchase_orders')->delete();

        $purchase_orders = array(
            [
                "purpose"  => "OO",
                "type" => "DS",
                "number" => "41088269-1",
                "date" => "20160523",
                "purchaser" => "BY",
                "currency_code" => "USD",
                "terms_type_code" => 14,
                "terms_basis_date_code" => 3,
                "date_time_qualifier" => "038",
                "qualifier_date" => "20160701",
                "transportation_type_code" => "M",
                "routing" => "UPS",
                "service_level_code_1" => "ST",
                "service_level_code_2" => "DS",
                "vendor_id" => 1,
                "customer_id" => 2,
                "bill_to_id" => 2,
                "ship_to_id" => 2,
                "sold_to_id" => null,
                "assigned_id" => "O",
                "quantity" => 1,
                "unit_measure" => "EA",
                "unit_price" => 180.05,
                "id_qualifier" => "IN",
                "item_id" => "298301",
                "id_qualifier2" => "VN",
                "item_id2" => "298301",
                "code" => "UP",
                "item_description_code" => "F",
                "item_class_code" => "08",
                "item_description" => "Test Item Description",
            ],
            [
                "purpose"  => "OO",
                "type" => "DS",
                "number" => "41088270-4",
                "date" => "20160523",
                "purchaser" => "BY",
                "currency_code" => "USD",
                "terms_type_code" => 14,
                "terms_basis_date_code" => 3,
                "date_time_qualifier" => "038",
                "qualifier_date" => "20160701",
                "transportation_type_code" => "A",
                "routing" => "Federal Express",
                "service_level_code_1" => "ON",
                "service_level_code_2" => "PX",
                "vendor_id" => 1,
                "customer_id" => 2,
                "bill_to_id" => 3,
                "ship_to_id" => 3,
                "sold_to_id" => null,
                "assigned_id" => "O",
                "quantity" => 1,
                "unit_measure" => "EA",
                "unit_price" => 122.50,
                "id_qualifier" => "IN",
                "item_id" => "203301",
                "id_qualifier2" => "VN",
                "item_id2" => "203301",
                "code" => "UP",
                "item_description_code" => "F",
                "item_class_code" => "08",
                "item_description" => "Test Other Description",
            ],
        );

        // Run the seeder
        DB::table('purchase_orders')->insert($purchase_orders);
    }
}
