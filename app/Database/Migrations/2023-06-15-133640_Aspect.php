<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aspect extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255
            ],
            'core_weight'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'secondary_weight'       => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'weight'       => [
                'type'           => 'INT',
                'constraint'     => 2
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('aspect', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('aspect');
    }
}
