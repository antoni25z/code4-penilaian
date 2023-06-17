<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Resultrating extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'employee_id'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'month'       => [
                'type'           => 'INT',
                'constraint'     => 2
            ],
            'year'       => [
                'type'           => 'INT',
                'constraint'     => 4
            ],
            'result'       => [
                'type'           => 'FLOAT'
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('result_rating', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('result_rating');
    }
}
