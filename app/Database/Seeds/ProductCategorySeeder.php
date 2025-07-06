<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Electronics',
                'slug'        => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active'   => 1,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Clothing',
                'slug'        => 'clothing',
                'description' => 'Fashion items and apparel',
                'is_active'   => 1,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Books',
                'slug'        => 'books',
                'description' => 'Books and reading materials',
                'is_active'   => 1,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Home & Kitchen',
                'slug'        => 'home-kitchen',
                'description' => 'Home appliances and kitchen items',
                'is_active'   => 1,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Sports & Outdoors',
                'slug'        => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'is_active'   => 1,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
        ];

        // Insert data to table
        $this->db->table('product_category')->insertBatch($data);
    }
}