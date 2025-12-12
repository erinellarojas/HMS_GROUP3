<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableMakeIdNumberNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'id_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'unique'     => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('users', [
            'id_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
        ]);
    }
}
