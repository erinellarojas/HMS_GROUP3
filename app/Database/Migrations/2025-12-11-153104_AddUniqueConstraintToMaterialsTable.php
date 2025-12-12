<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueConstraintToMaterialsTable extends Migration
{
    public function up()
    {
        // Add unique constraint to prevent duplicate file names in the same course
        // Using raw SQL for adding unique key to existing table
        $this->db->query('ALTER TABLE `materials` ADD UNIQUE KEY `unique_course_file` (`course_id`, `file_name`)');
    }

    public function down()
    {
        // Remove the unique constraint
        $this->db->query('ALTER TABLE `materials` DROP INDEX `unique_course_file`');
    }
}
