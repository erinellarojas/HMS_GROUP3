<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        // Define fields for the notifications table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Define Foreign Key - Links to the users table
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        // Add index on user_id and is_read for better query performance
        $this->forge->addKey(['user_id', 'is_read']);

        $this->forge->createTable('notifications', true);
    }

    public function down()
    {
        $this->forge->dropTable('notifications', true);
    }
}
