<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesTableAddCourseNameAndCode extends Migration
{
    public function up()
    {
        // Add course_name column if it doesn't exist
        $fields = [
            'course_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'title',
            ],
            'course_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'after' => 'course_name',
            ],
        ];
        
        $this->forge->addColumn('courses', $fields);
        
        // If title column exists and has data, copy it to course_name
        // Then we can optionally drop title later if needed
        $this->db->query("UPDATE courses SET course_name = title WHERE course_name IS NULL AND title IS NOT NULL");
    }

    public function down()
    {
        // Remove the added columns
        $this->forge->dropColumn('courses', ['course_name', 'course_code']);
    }
}
