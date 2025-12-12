<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class User extends Controller
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

        if ($this->session->get('user_role') !== 'student') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access denied. Student access only.');
        }

        return true;
    }

    public function index()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');

        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();
        $userId = $this->session->get('user_id');

        $data['enrolledCourses'] = $enrollmentModel->getUserEnrollments($userId);

        $allCourses = $courseModel->getCoursesWithInstructor();
        $availableCourses = [];
        foreach ($allCourses as $course) {
            if (!$enrollmentModel->isAlreadyEnrolled($userId, $course['id'])) {
                $availableCourses[] = $course;
            }
        }
        $data['availableCourses'] = $availableCourses;

        return view('student/index', $data);
    }

    public function courses()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();

        $data['enrolled_courses'] = $enrollmentModel->getUserEnrollments($this->session->get('user_id'));

        $allCourses = $courseModel->getCoursesWithInstructor();
        $userId = $this->session->get('user_id');
        $availableCourses = [];

        foreach ($allCourses as $course) {
            if (!$enrollmentModel->isAlreadyEnrolled($userId, $course['id'])) {
                $availableCourses[] = $course;
            }
        }

        $data['available_courses'] = $availableCourses;

        return view('student/courses', $data);
    }

    public function viewCourse($courseId)
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $userId = $this->session->get('user_id');
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();

        // Verify student is enrolled in this course (security check)
        if (!$enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return redirect()->to(site_url('student/courses'))->with('error', 'You are not enrolled in this course.');
        }

        // Get course details with instructor information
        $course = $courseModel->getCourseWithInstructor($courseId);
        
        // If no instructor found, try getting course without instructor join
        if (!$course) {
            $course = $courseModel->find($courseId);
            if ($course) {
                $course['instructor_name'] = null;
            }
        }

        if (!$course) {
            return redirect()->to(site_url('student/courses'))->with('error', 'Course not found.');
        }

        // Get enrollment information
        $enrollment = $enrollmentModel->where('user_id', $userId)
                                     ->where('course_id', $courseId)
                                     ->first();

        // Get materials for this course
        $materialModel = new \App\Models\MaterialModel();
        $materials = $materialModel->getMaterialsByCourse($courseId);

        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'user_email' => $this->session->get('user_email'),
            'course' => $course,
            'enrollment' => $enrollment,
            'materials' => $materials
        ];

        return view('student/course_detail', $data);
    }

    public function enrollment()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        $courseModel = new \App\Models\CourseModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();

        $allCourses = $courseModel->getCoursesWithInstructor();
        $userId = $this->session->get('user_id');

        $availableCourses = [];
        foreach ($allCourses as $course) {
            if (!$enrollmentModel->isAlreadyEnrolled($userId, $course['id'])) {
                $availableCourses[] = $course;
            }
        }

        $data['available_courses'] = $availableCourses;

        return view('student/enrollment', $data);
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
                'status' => 'Pending',
                'description' => 'Create a responsive website using HTML, CSS, and JavaScript'
            ],
            [
                'id' => 2,
                'title' => 'Database Design Project',
                'course' => 'ITE312 - Database Systems',
                'due_date' => '2024-01-20',
                'status' => 'Submitted',
                'description' => 'Design and implement a database schema for a library management system'
            ],
            [
                'id' => 3,
                'title' => 'Software Requirements Document',
                'course' => 'ITE313 - Software Engineering',
                'due_date' => '2024-01-25',
                'status' => 'Pending',
                'description' => 'Write a comprehensive SRD for a student management system'
            ]
        ];

        return view('student/assignments', $data);
    }

    public function grades()
    {
        $access = $this->checkAccess();
        if ($access !== true) return $access;

        $data['user_name'] = $this->session->get('user_name');
        $data['user_role'] = $this->session->get('user_role');
        $data['user_email'] = $this->session->get('user_email');

        // Sample grades data
        $data['grades'] = [
            [
                'course' => 'ITE311 - Web Development',
                'midterm' => '95',
                'final' => '92',
                'overall' => '93',
                'grade' => 'A',
                'status' => 'Passed'
            ],
            [
                'course' => 'ITE312 - Database Systems',
                'midterm' => '88',
                'final' => '90',
                'overall' => '89',
                'grade' => 'B+',
                'status' => 'Passed'
            ],
            [
                'course' => 'ITE313 - Software Engineering',
                'midterm' => '92',
                'final' => 'Pending',
                'overall' => 'Pending',
                'grade' => 'Pending',
                'status' => 'In Progress'
            ]
        ];

        $completed_grades = array_filter($data['grades'], function($grade) {
            return $grade['overall'] !== 'Pending';
        });

        if (count($completed_grades) > 0) {
            $total_points = 0;
            foreach ($completed_grades as $grade) {
                $total_points += $this->gradeToPoints($grade['grade']);
            }
            $data['gpa'] = number_format($total_points / count($completed_grades), 2);
        } else {
            $data['gpa'] = 'N/A';
        }

        return view('student/grades', $data);
    }

    private function gradeToPoints($grade)
    {
        $gradeMap = [
            'A' => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B' => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C' => 2.0,
            'C-' => 1.7,
            'D' => 1.0,
            'F' => 0.0
        ];

        return isset($gradeMap[$grade]) ? $gradeMap[$grade] : 0.0;
    }
}
