<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'product_name' => 'Acer Gaming Computer i5',
                'quantity' => 163,
                'date_in' => '2025-01-01',
                'created_at' => '2025-01-07 04:35:15',
                'updated_at' => '2025-01-09 06:58:57',
            ],
            [
                'product_name' => 'Laptop Razer',
                'quantity' => 195,
                'date_in' => '2025-01-07',
                'created_at' => '2025-01-07 06:57:23',
                'updated_at' => '2025-01-08 07:19:31',
            ],
            [
                'product_name' => 'Komputer Gaming i5 VGA 1660 Super',
                'quantity' => 240,
                'date_in' => '2025-01-02',
                'created_at' => '2025-01-07 08:36:23',
                'updated_at' => '2025-01-07 08:36:23',
            ],
            [
                'product_name' => 'Dell Inspiron Laptop',
                'quantity' => 700,
                'date_in' => '2025-01-03',
                'created_at' => '2025-01-07 09:00:00',
                'updated_at' => '2025-01-09 07:23:25',
            ],
            [
                'product_name' => 'HP Pavilion x360',
                'quantity' => 150,
                'date_in' => '2025-01-04',
                'created_at' => '2025-01-07 09:30:00',
                'updated_at' => '2025-01-07 09:30:00',
            ],
            [
                'product_name' => 'Lenovo ThinkPad X1 Carbon',
                'quantity' => 85,
                'date_in' => '2025-01-05',
                'created_at' => '2025-01-07 10:00:00',
                'updated_at' => '2025-01-07 10:00:00',
            ],
            [
                'product_name' => 'Asus ROG Strix G15',
                'quantity' => 242,
                'date_in' => '2025-01-06',
                'created_at' => '2025-01-07 10:30:00',
                'updated_at' => '2025-01-08 07:30:47',
            ],
            [
                'product_name' => 'MSI GF63 Thin',
                'quantity' => 110,
                'date_in' => '2025-01-07',
                'created_at' => '2025-01-07 11:00:00',
                'updated_at' => '2025-01-07 11:00:00',
            ],
            [
                'product_name' => 'Apple Mac Mini M2',
                'quantity' => 55,
                'date_in' => '2025-01-01',
                'created_at' => '2025-01-07 11:30:00',
                'updated_at' => '2025-01-07 11:30:00',
            ],
            [
                'product_name' => 'Raspberry Pi 4 Model B',
                'quantity' => 320,
                'date_in' => '2025-01-02',
                'created_at' => '2025-01-07 12:00:00',
                'updated_at' => '2025-01-07 12:00:00',
            ],
            [
                'product_name' => 'Intel NUC Kit',
                'quantity' => 162,
                'date_in' => '2025-01-03',
                'created_at' => '2025-01-07 12:30:00',
                'updated_at' => '2025-01-08 07:19:55',
            ],
            [
                'product_name' => 'Gigabyte Brix S',
                'quantity' => 95,
                'date_in' => '2025-01-04',
                'created_at' => '2025-01-07 13:00:00',
                'updated_at' => '2025-01-07 13:00:00',
            ],
            [
                'product_name' => 'Corsair One i200',
                'quantity' => 75,
                'date_in' => '2025-01-05',
                'created_at' => '2025-01-07 13:30:00',
                'updated_at' => '2025-01-07 13:30:00',
            ],
            [
                'product_name' => 'HP Z2 Mini G5',
                'quantity' => 79,
                'date_in' => '2025-01-06',
                'created_at' => '2025-01-07 14:00:00',
                'updated_at' => '2025-01-08 07:31:30',
            ],
            [
                'product_name' => 'Dell OptiPlex 3080 Micro',
                'quantity' => 180,
                'date_in' => '2025-01-07',
                'created_at' => '2025-01-07 14:30:00',
                'updated_at' => '2025-01-07 14:30:00',
            ],
            [
                'product_name' => 'Lenovo IdeaCentre Mini 5i',
                'quantity' => 210,
                'date_in' => '2025-01-01',
                'created_at' => '2025-01-07 15:00:00',
                'updated_at' => '2025-01-07 15:00:00',
            ],
            [
                'product_name' => 'Acer Aspire C27',
                'quantity' => 219,
                'date_in' => '2025-01-02',
                'created_at' => '2025-01-07 15:30:00',
                'updated_at' => '2025-01-08 07:07:16',
            ],
            [
                'product_name' => 'Asus VivoPC',
                'quantity' => 130,
                'date_in' => '2025-01-03',
                'created_at' => '2025-01-07 16:00:00',
                'updated_at' => '2025-01-07 16:00:00',
            ],
            [
                'product_name' => 'MSI Pro DP20Z',
                'quantity' => 220,
                'date_in' => '2025-01-04',
                'created_at' => '2025-01-07 16:30:00',
                'updated_at' => '2025-01-07 16:30:00',
            ],
        ];

        // Insert data ke tabel warehouses
        Warehouse::insert($data);
    }
}
