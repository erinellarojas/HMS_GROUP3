<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Teacher extends Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    private function checkAccess()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($this->session->get('user_role') !== 'teacher') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access denied. Teacher access only.');
        }

        return true;
    }

    public function index()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        return view('teacher/index', $data);
    }

    public function classes()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        // Get classes from database
        $courseModel = new \App\Models\CourseModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();
        
        $teacherId = $this->session->get('user_id');
        $courses = $courseModel->getCoursesByInstructor($teacherId);
        
        // Get enrollment count for each course
        $classes = [];
        foreach ($courses as $course) {
            $enrollmentCount = $enrollmentModel->where('course_id', $course['id'])->countAllResults();
            $classes[] = [
                'id' => $course['id'],
                'name' => $course['course_name'],
                'code' => $course['course_code'] ?? 'N/A',
                'schedule' => 'TBA', // Can be added to courses table later
                'students_count' => $enrollmentCount,
                'status' => 'Active'
        ];
        }
        
        $data['classes'] = $classes;

        return view('teacher/classes', $data);
    }

    public function assignments()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        // Sample assignments data
        $data['assignments'] = [
            [
                'id' => 1,
                'title' => 'Build a Responsive Website',
                'course' => 'ITE311 - Web Development',
                'due_date' => '2024-01-15',
                'submissions' => 18,
                'total_students' => 25,
                'status' => 'Active'
            ],
            [
                'id' => 2,
                'title' => 'Database Design Project',
                'course' => 'ITE312 - Database Systems',
                'due_date' => '2024-01-20',
                'submissions' => 22,
                'total_students' => 22,
                'status' => 'Graded'
            ],
            [
                'id' => 3,
                'title' => 'Software Requirements Document',
                'course' => 'ITE313 - Software Engineering',
                'due_date' => '2024-01-25',
                'submissions' => 15,
                'total_students' => 20,
                'status' => 'Active'
            ]
        ];

        return view('teacher/assignments', $data);
    }

    public function grades()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        // Sample grade entry data
        $data['grade_entries'] = [
            [
                'assignment' => 'Build a Responsive Website',
                'course' => 'ITE311 - Web Development',
                'student' => 'Juan Dela Cruz',
                'submitted_date' => '2024-01-12',
                'current_grade' => '95',
                'status' => 'Graded'
            ],
            [
                'assignment' => 'Database Design Project',
                'course' => 'ITE312 - Database Systems',
                'student' => 'Maria Santos',
                'submitted_date' => '2024-01-18',
                'current_grade' => 'Pending',
                'status' => 'Pending Review'
            ],
            [
                'assignment' => 'Software Requirements Document',
                'course' => 'ITE313 - Software Engineering',
                'student' => 'Pedro Reyes',
                'submitted_date' => '2024-01-22',
                'current_grade' => '88',
                'status' => 'Graded'
            ]
        ];

        return view('teacher/grades', $data);
    }

    public function viewCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $teacherId = $this->session->get('user_id');
        $courseModel = new \App\Models\CourseModel();
        $materialModel = new \App\Models\MaterialModel();
        
        // Get course and verify teacher is the instructor
        $course = $courseModel->getCourseWithInstructor($courseId);

        if (!$course) {
            return redirect()->to(site_url('teacher/courses'))->with('error', 'Course not found');
        }

        // Security: Verify that the teacher is the instructor for this course
        if ($course['instructor_id'] != $teacherId) {
            return redirect()->to(site_url('teacher/courses'))->with('error', 'Access denied. You are not the instructor for this course.');
        }

        // Get materials for this course
        $materials = $materialModel->getMaterialsByCourse($courseId);

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'course' => $course,
            'materials' => $materials
        ];

        // Use the same view as admin (it works for both admin and teacher)
        return view('admin/view_course', $data);
    }
}
