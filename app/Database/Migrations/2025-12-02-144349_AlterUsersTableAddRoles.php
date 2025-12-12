<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableAddRoles extends Migration
{
    public function up()
    {
        // Modify the 'role' column to include 'teacher' and change default to 'student'
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'teacher', 'student'],
                'default'    => 'student',
            ],
        ]);
    }

    public function down()
    {
        // Revert to original enum
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user',
            ],
        ]);
    }
}
