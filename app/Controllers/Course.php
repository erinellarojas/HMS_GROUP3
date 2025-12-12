<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\NotificationModel;

class Course extends BaseController
{
    protected $courseModel;
    protected $enrollmentModel;
    protected $db;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->db = \Config\Database::connect();
    }

    public function enroll()
    {
        // Security: Step 9.1 - Authorization Bypass Protection
        // Check if user is logged in - prevents unauthorized access
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error', 
                'success' => false,
                'message' => 'Unauthorized access. Please log in first.'
            ])->setStatusCode(401);
        }

        // Security: Step 9.4 - Data Tampering Protection
        // ALWAYS use user_id from session, NEVER trust client-supplied user_id
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'Invalid session. Please log in again.'
            ])->setStatusCode(401);
        }

        // Security: Step 9.5 - Input Validation
        // Validate and sanitize course_id input
        $course_id = $this->request->getPost('course_id');
        
        // Check if course_id is provided
        if (empty($course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'Course ID is required.'
            ])->setStatusCode(400);
        }

        // Security: Step 9.2 - SQL Injection Protection
        // Validate that course_id is numeric (prevents SQL injection)
        if (!is_numeric($course_id) || $course_id <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'Invalid Course ID format.'
            ])->setStatusCode(400);
        }

        // Convert to integer to prevent any string-based injection
        $course_id = (int) $course_id;

        // Security: Step 9.5 - Verify course exists
        // Check if the course actually exists in the database
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'Course not found.'
            ])->setStatusCode(404);
        }

        // Check if user is already enrolled (prevents duplicate enrollments)
        if ($this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'You are already enrolled in this course.'
            ])->setStatusCode(409); // 409 Conflict
        }

        // Prepare enrollment data
        // Security: user_id comes from session, not from client input
        $current_datetime = date('Y-m-d H:i:s');
        $formatted_date = date('M d, Y');

        $enrollmentData = [
            'user_id' => $user_id, // From session - secure
            'course_id' => $course_id, // Validated and sanitized
            'enrollment_date' => $current_datetime
        ];

        // Attempt to enroll user
        try {
        if ($this->enrollmentModel->enrollUser($enrollmentData)) {
                // Create a notification for the student
                $notificationModel = new NotificationModel();
                $courseName = $course['course_name'] ?? 'Course';
                $notificationMessage = "You have been enrolled in " . $courseName;
                
                // Create notification (don't fail enrollment if notification creation fails)
                try {
                    $notificationModel->createNotification($user_id, $notificationMessage);
                } catch (\Exception $notifException) {
                    // Log notification error but don't fail enrollment
                    log_message('error', 'Notification creation failed: ' . $notifException->getMessage());
                }
                
                // Success - return course details
            return $this->response->setJSON([
                    'status' => 'success',
                'success' => true,
                'message' => 'Successfully enrolled in the course!',
                'enrollment_date_formatted' => $formatted_date,
                    'course_id' => $course_id,
                    'course_name' => $course['course_name'] ?? 'Course',
                    'course_description' => $course['description'] ?? ''
                ])->setStatusCode(200);
        } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'success' => false,
                    'message' => 'Failed to enroll in the course due to a database error.'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            // Log the error for debugging (but don't expose details to client)
            log_message('error', 'Enrollment failed: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'success' => false,
                'message' => 'An error occurred while processing your enrollment. Please try again.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Search Courses
     * 
     * Implements server-side search functionality using CodeIgniter's Query Builder.
     * Supports both AJAX (JSON) and regular (HTML) requests.
     * Searches course name, course code, and description fields using LIKE queries.
     * 
     * @return mixed JSON response for AJAX requests, or view for regular requests
     */
    public function search()
    {
        // Get search term from request
        $searchTerm = $this->request->getGet('q') ?? $this->request->getPost('q') ?? '';
        
        // Sanitize search term to prevent XSS (but keep it for LIKE query)
        $searchTerm = trim($searchTerm);
        
        // Check if this is an AJAX request
        $isAjax = $this->request->isAJAX();
        
        // Build search query using CodeIgniter's Query Builder
        $builder = $this->db->table('courses');
        
        // Start with select and join
        $builder->select('courses.*, users.name as instructor_name')
                ->join('users', 'users.id = courses.instructor_id', 'left');
        
        // Add search conditions if search term is provided
        // Only match courses that START WITH the typed letter (first letter match)
        if (!empty($searchTerm)) {
            // Use 'after' side to add % only at the end, making it match from the start
            $builder->groupStart()
                    ->like('courses.course_name', $searchTerm, 'after')
                    ->orLike('courses.course_code', $searchTerm, 'after')
                    ->orLike('courses.description', $searchTerm, 'after')
                    ->groupEnd();
        }
        
        // Order by creation date
        $builder->orderBy('courses.created_at', 'DESC');
        
        // Execute query
        $results = $builder->get()->getResultArray();
        
        // For AJAX requests, return JSON
        if ($isAjax) {
            return $this->response->setJSON([
                'status' => 'success',
                'results' => $results,
                'count' => count($results),
                'search_term' => esc($searchTerm)
            ]);
        }
        
        // For regular requests, return view with results
        $data = [
            'courses' => $results,
            'search_term' => esc($searchTerm),
            'user_name' => session()->get('user_name') ?? 'Guest',
            'user_role' => session()->get('user_role') ?? 'guest'
        ];
        
        // Determine which view to use based on user role
        $userRole = session()->get('user_role');
        if ($userRole === 'admin') {
            return view('admin/courses', $data);
        } elseif ($userRole === 'student') {
            return view('student/courses', $data);
        } else {
            // Default view or redirect
            return redirect()->to(site_url('dashboard'));
        }
    }

}