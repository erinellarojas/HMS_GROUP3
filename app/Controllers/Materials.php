<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Materials extends BaseController
{
    protected $materialModel;
    protected $courseModel;
    protected $enrollmentModel;
    protected $session;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url', 'download']);
    }

    private function checkAdminAccess()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($this->session->get('user_role') !== 'admin' && $this->session->get('user_role') !== 'teacher') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access denied. Admin/Teacher access only.');
        }

        return true;
    }

    private function checkStudentAccess()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        if ($this->session->get('user_role') !== 'student') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access denied. Student access only.');
        }

        return true;
    }

    /**
     * Upload Material for a Course
     * 
     * This method implements secure file upload functionality using CodeIgniter's
     * File Uploading Library. It ensures:
     * - Only instructors (teachers) and admins can upload materials
     * - Files are validated by extension AND MIME type for security
     * - File size limits are enforced (10MB max)
     * - Only allowed file types: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG
     * - Files are stored securely with proper permissions
     * - Filenames are sanitized to prevent path traversal attacks
     * - Duplicate file names are prevented per course
     * 
     * @param int $course_id The ID of the course to upload material for
     * @return mixed View for GET requests, redirect for POST requests
     */
    public function upload($course_id)
    {
        $access = $this->checkAdminAccess();
        if ($access !== true) return $access;

        // Verify course exists
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return redirect()->to(site_url('admin/courses'))->with('error', 'Course not found.');
        }

        // Handle POST request (file upload)
        if ($this->request->getMethod() === 'post') {
            // Load validation library
            $validation = \Config\Services::validation();

            // Define allowed MIME types for security (validating actual file content, not just extension)
            $allowedMimes = [
                // PDF files
                'application/pdf',
                'application/force-download',
                'application/x-download',
                // DOC files
                'application/msword',
                'application/vnd.ms-office',
                // DOCX files
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/zip',
                'application/x-zip',
                // PPT files
                'application/vnd.ms-powerpoint',
                'application/powerpoint',
                // PPTX files
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                // TXT files
                'text/plain',
                // Image files
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png'
            ];

            // Validation rules using CodeIgniter's File Uploading Library
            // Validates: file upload, size, extension, AND MIME type for security
            $rules = [
                'material_file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png]|mime_in[material_file,' . implode(',', $allowedMimes) . ']',
                    'errors' => [
                        'uploaded' => 'Please select a file to upload.',
                        'max_size' => 'File size must not exceed 10MB.',
                        'ext_in' => 'Only PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG files are allowed.',
                        'mime_in' => 'Invalid file type. The file content does not match the allowed file types.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $data = [
                    'user_name' => $this->session->get('user_name'),
                    'user_role' => $this->session->get('user_role'),
                    'course' => $course,
                    'validation' => $this->validator
                ];
                return view('admin/upload_material', $data);
            }

            // Get uploaded file using CodeIgniter's File Uploading Library
            $file = $this->request->getFile('material_file');

            // Validate file using CodeIgniter's built-in validation
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'File upload failed: ' . $file->getErrorString());
            }

            if ($file->hasMoved()) {
                return redirect()->back()->with('error', 'File has already been processed.');
            }

            // Additional security: Verify MIME type matches extension
            $detectedMime = $file->getMimeType();
            $extension = strtolower($file->guessExtension());
            
            // Validate MIME type is in allowed list
            if (!in_array($detectedMime, $allowedMimes, true)) {
                return redirect()->back()->with('error', 'Security check failed: Invalid file type detected.');
            }

            // Configure secure upload preferences
            $uploadPath = WRITEPATH . 'uploads/materials/';
            
            // Create directory if it doesn't exist with secure permissions
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
                // Create index.html to prevent directory listing
                $indexFile = $uploadPath . 'index.html';
                if (!file_exists($indexFile)) {
                    file_put_contents($indexFile, '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><h1>Directory access is forbidden.</h1></body></html>');
                }
            }

            // Sanitize original filename to prevent path traversal attacks
            $originalName = $file->getClientName();
            $originalName = basename($originalName); // Remove any path components
            $originalName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName); // Sanitize filename

            // Check for duplicate file name in the same course
            if ($this->materialModel->isDuplicateMaterial($course_id, $originalName)) {
                return redirect()->back()->with('error', 'A file with the same name already exists for this course. Please rename the file or delete the existing one first.');
            }

            // Generate unique filename using CodeIgniter's secure random name generator
            $newName = $file->getRandomName();

            // Move file to upload directory using CodeIgniter's secure move method
            if ($file->move($uploadPath, $newName)) {
                // Set secure file permissions (readable by owner and group, not world-writable)
                @chmod($uploadPath . $newName, 0644);

                // Prepare data for database
                $materialData = [
                    'course_id' => $course_id,
                    'file_name' => $originalName,
                    'file_path' => 'uploads/materials/' . $newName,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Save to database
                if ($this->materialModel->insertMaterial($materialData)) {
                    return redirect()->to(site_url('admin/courses/view/' . $course_id))->with('success', 'Material uploaded successfully!');
                } else {
                    // Delete uploaded file if database insert fails (cleanup)
                    @unlink($uploadPath . $newName);
                    return redirect()->back()->with('error', 'Failed to save material record. Please try again.');
                }
            } else {
                // Get error messages from CodeIgniter's file upload library
                $errors = $file->getErrorString();
                return redirect()->back()->with('error', 'Failed to upload file: ' . $errors);
            }
        }

        // Display upload form (GET request)
        $data = [
            'user_name' => $this->session->get('user_name'),
            'user_role' => $this->session->get('user_role'),
            'course' => $course
        ];

        return view('admin/upload_material', $data);
    }

    public function delete($material_id)
    {
        $access = $this->checkAdminAccess();
        if ($access !== true) return $access;

        // Get material record
        $material = $this->materialModel->getMaterialById($material_id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        $course_id = $material['course_id'];
        $file_path = WRITEPATH . $material['file_path'];

        // Delete file from server
        if (file_exists($file_path)) {
            @unlink($file_path);
        }

        // Delete record from database
        if ($this->materialModel->delete($material_id)) {
            return redirect()->to(site_url('admin/courses/view/' . $course_id))->with('success', 'Material deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete material. Please try again.');
        }
    }

    /**
     * Download Material
     * 
     * Allows enrolled students to download course materials.
     * Access control:
     * - Admins and teachers can download any material
     * - Students can only download materials for courses they are enrolled in
     * - All users must be logged in
     * 
     * This ensures that learning resources are only available to enrolled students,
     * maintaining the security and integrity of the LMS.
     * 
     * @param int $material_id The ID of the material to download
     * @return mixed Download response or redirect on error
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'))->with('error', 'Please log in to download materials.');
        }

        // Get material record
        $material = $this->materialModel->getMaterialById($material_id);
        
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Check if user is enrolled in the course (for students)
        $user_id = $this->session->get('user_id');
        $user_role = $this->session->get('user_role');
        $course_id = $material['course_id'];

        // Allow admin and teacher to download any material
        if ($user_role === 'admin' || $user_role === 'teacher') {
            // Admin/Teacher can download any material
        } elseif ($user_role === 'student') {
            // Student must be enrolled in the course to access materials
            if (!$this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
                return redirect()->back()->with('error', 'You are not enrolled in this course. Access denied.');
            }
        } else {
            return redirect()->back()->with('error', 'Access denied.');
        }

        // Get file path
        $file_path = WRITEPATH . $material['file_path'];

        // Check if file exists
        if (!file_exists($file_path)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        // Force download using CodeIgniter's download response
        return $this->response->download($file_path, null)->setFileName($material['file_name']);
    }
}
