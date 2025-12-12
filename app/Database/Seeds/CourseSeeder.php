<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Check if courses already exist to avoid duplicates
        $existingCourses = $this->db->table('courses')->select('course_name')->get()->getResultArray();
        $existingNames = array_column($existingCourses, 'course_name');
        
        $data = [
            [
                'course_code' => 'ITE311',
                'course_name' => 'Web Development',
                'description' => 'Learn modern web development technologies including HTML, CSS, JavaScript, and PHP frameworks.',
                'instructor_id' => 2, // Assuming teacher user ID
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE312',
                'course_name' => 'Database Basics',
                'description' => 'Comprehensive study of database design, SQL, and database management systems.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE313',
                'course_name' => 'Software Engineering',
                'description' => 'Principles and practices of software development, including requirements analysis, design, and testing.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE314',
                'course_name' => 'Computer Networks',
                'description' => 'Introduction to computer networking concepts, protocols, and network security.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE315',
                'course_name' => 'Mobile App Development',
                'description' => 'Develop mobile applications for Android and iOS platforms using modern frameworks.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE316',
                'course_name' => 'Web Development Fundamentals',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, JavaScript, and modern frameworks.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE317',
                'course_name' => 'IT Fundamentals',
                'description' => 'Introduction to information technology concepts, computer systems, and basic programming.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_code' => 'ITE318',
                'course_name' => 'Database Systems Advanced',
                'description' => 'Comprehensive study of database design, SQL, data modeling, and database management systems.',
                'instructor_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Filter out courses that already exist
        $newCourses = array_filter($data, function($course) use ($existingNames) {
            return !in_array($course['course_name'], $existingNames);
        });
        
        // Update existing "Database Systems" to "Database Basics" if it exists
        $this->db->table('courses')
            ->where('course_name', 'Database Systems')
            ->update(['course_name' => 'Database Basics', 'updated_at' => date('Y-m-d H:i:s')]);
        
        // Insert only new courses
        if (!empty($newCourses)) {
            $this->db->table('courses')->insertBatch(array_values($newCourses));
        }
    }
}
