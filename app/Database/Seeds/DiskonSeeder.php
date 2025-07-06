<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $today = new \DateTime('2025-07-01');

        for ($i = 0; $i < 10; $i++) {
            $tanggal = clone $today;
            $tanggal->modify("+$i day");

            $data[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'nominal' => 100000 + $i * 5000,
                'created_at' => $tanggal->format('Y-m-d 12:30:21'),
                'updated_at' => $tanggal->format('Y-m-d 12:30:21'),
            ];
        }

        $this->db->table('diskon')->insertBatch($data);
    }
}
