<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiskonToPesanan extends Migration
{
    public function up()
{
    $this->forge->addColumn('transaction', [
        'diskon' => [
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0,
            'after'      => 'ongkir' // opsional
        ]
    ]);
      $this->forge->addColumn('product', [
        'diskon' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0,
        ]
    ]);
}


    public function down()
    {
        //
    }
}
