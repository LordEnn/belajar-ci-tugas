<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Elektronik','deskripsi' => 'Produk seperti gadget, TV, komputer.'
            ],
            [
                'nama' => 'Pakaian','deskripsi' => 'Baju, celana, jaket, dan aksesoris.'
            ],
            [
                'nama' => 'Makanan & Minuman','deskripsi' => 'Produk konsumsi sehari-hari.'
            ],
            [
                'nama' => 'Kecantikan','deskripsi' => 'Kosmetik dan perawatan tubuh.'
            ],
            [
                'nama' => 'Alat Tulis','deskripsi' => 'Pulpen, pensil, buku, dll.'
            ]
        ];
        $this->db->table('product_category')->insertBatch($data);
    }
}
