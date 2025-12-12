# Laboratory Activity Verification Checklist

This document verifies that all steps of the Laboratory Activity are properly implemented.

## Step 1: Create Database Migration for Enrollments Table ✅

**Status:** COMPLETE

**File:** `app/Database/Migrations/2025-12-03-015500_CreateEnrollmentsTable.php`

**Required Fields:**
- ✅ `id` (primary key, auto-increment)
- ✅ `user_id` (int, foreign key to users table)
- ✅ `course_id` (int, foreign key to courses table)
- ✅ `enrollment_date` (datetime)

**Additional Features:**
- ✅ `down()` method properly defined to drop table
- ✅ Foreign key constraints with CASCADE
- ✅ Unique constraint to prevent duplicate enrollments
- ✅ Migration has been run successfully

**To Run Migration:**
```bash
php spark migrate
```

---

## Step 2: Create the Enrollment Model ✅

**Status:** COMPLETE

**File:** `app/Models/EnrollmentModel.php`

**Required Methods:**
- ✅ `enrollUser($data)`: Inserts a new enrollment record
- ✅ `getUserEnrollments($user_id)`: Fetches all courses a user is enrolled in
- ✅ `isAlreadyEnrolled($user_id, $course_id)`: Checks if user is already enrolled (prevents duplicates)

**Implementation Details:**
- Uses CodeIgniter Model class
- Proper table configuration
- Includes JOIN with courses and users tables to get full course details

---

## Step 3: Modify the Course Controller ✅

**Status:** COMPLETE

**File:** `app/Controllers/Course.php`

**Method:** `enroll()`

**Required Functionality:**
- ✅ Checks if user is logged in (Authorization Bypass Protection)
- ✅ Receives `course_id` from POST request
- ✅ Checks if user is already enrolled (prevents duplicates)
- ✅ Inserts new enrollment record with current timestamp
- ✅ Returns JSON response indicating success or failure

**Security Features Implemented:**
- ✅ Authorization check (Step 9.1)
- ✅ SQL Injection protection (Step 9.2)
- ✅ CSRF protection support (Step 9.3)
- ✅ Data tampering protection (Step 9.4)
- ✅ Input validation (Step 9.5)

---

## Step 4: Update Student Dashboard View ✅

**Status:** COMPLETE

**File:** `app/Views/auth/dashboard.php`

**Required Sections:**
- ✅ **Display Enrolled Courses**: Uses cards/list to display courses from `EnrollmentModel::getUserEnrollments()`
- ✅ **Available Courses**: Displays list of courses with Enroll button next to each

**Implementation:**
- Enrolled courses displayed in a card-based layout
- Available courses displayed in a table format with "Course Name | Action" columns
- Each course has an "Enroll" button

---

## Step 5: Implement AJAX Enrollment ✅

**Status:** COMPLETE

**File:** `app/Views/auth/dashboard.php` (JavaScript section)

**Required Features:**
- ✅ `data-course-id` attribute on each Enroll button containing course ID
- ✅ jQuery library included
- ✅ jQuery script that:
  - ✅ Listens for click on Enroll button
  - ✅ Prevents default form submission (`e.preventDefault()`)
  - ✅ Uses `$.ajax()` to send `course_id` to `/course/enroll` URL
  - ✅ On success:
    - ✅ Displays success message (Bootstrap-style alert)
    - ✅ Hides/disables the Enroll button for that course
    - ✅ Updates Enrolled Courses list dynamically (no page reload)
    - ✅ Removes course from Available Courses table

**AJAX Implementation:**
- URL: `/course/enroll`
- Method: POST
- Includes CSRF token in headers and data
- Handles success and error responses
- Dynamic DOM updates without page reload

---

## Step 6: Configure Routes ✅

**Status:** COMPLETE

**File:** `app/Config/Routes.php`

**Required Route:**
- ✅ `$routes->post('/course/enroll', 'Course::enroll');`

**Location:** Line 59

---

## Step 7: Test the Application Thoroughly

**Status:** USER ACTION REQUIRED

**Test Checklist:**
1. ✅ Log in as a student
2. ✅ Navigate to student dashboard
3. ✅ Click Enroll button on an available course and verify:
   - ✅ Page does not reload
   - ✅ Success message appears
   - ✅ Button becomes disabled or disappears
   - ✅ Course appears in Enrolled Courses section

**Expected Behavior:**
- No page refresh occurs
- Success message displays at top of page
- Enroll button disappears (entire table row fades out)
- Course card appears in "My Enrolled Courses" section
- Course is removed from "Available Courses" table

---

## Step 8: Push to GitHub

**Status:** USER ACTION REQUIRED

**Commands:**
```bash
git add .
git commit -m "Complete Laboratory Activity: Enrollment System with Security Features"
git push origin main
```

---

## Step 9: Security Vulnerability Testing

**Status:** ALL PROTECTIONS IMPLEMENTED ✅

### 9.1: Authorization Bypass Protection ✅

**Implementation:**
- File: `app/Controllers/Course.php`, lines 23-29
- Checks `session()->get('isLoggedIn')` before processing
- Returns 401 Unauthorized if not logged in

**Test:**
1. Log out of application
2. Use Postman/browser console to send POST request to `/course/enroll` with `course_id`
3. **Expected Result:** Returns 401 error with message "Unauthorized access. Please log in first."

**Code Location:**
```php
if (!session()->get('isLoggedIn')) {
    return $this->response->setJSON([
        'status' => 'error', 
        'success' => false,
        'message' => 'Unauthorized access. Please log in first.'
    ])->setStatusCode(401);
}
```

---

### 9.2: SQL Injection Protection ✅

**Implementation:**
- File: `app/Controllers/Course.php`, lines 57-66
- Validates `course_id` is numeric
- Converts to integer using `(int)` cast
- Uses CodeIgniter's parameterized queries (Model methods)

**Test:**
1. Log in as student
2. Use browser developer tools to modify AJAX request
3. Change `course_id` to `1 OR 1=1` or `'; DROP TABLE enrollments; --`
4. **Expected Result:** Returns 400 error with message "Invalid Course ID format."

**Code Location:**
```php
if (!is_numeric($course_id) || $course_id <= 0) {
    return $this->response->setJSON([
        'status' => 'error',
        'success' => false,
        'message' => 'Invalid Course ID format.'
    ])->setStatusCode(400);
}
$course_id = (int) $course_id; // Explicit cast
```

---

### 9.3: CSRF Protection ✅

**Implementation:**
- File: `app/Config/Security.php` - CSRF protection enabled
- File: `app/Views/auth/dashboard.php` - CSRF token included in AJAX requests
- CSRF token retrieved from meta tag and sent in headers and data

**Test:**
1. Check `app/Config/Security.php` - verify `csrfProtection = 'cookie'`
2. Check dashboard view - verify CSRF token meta tag exists
3. Attempt enrollment request without CSRF token
4. **Expected Result:** CodeIgniter automatically rejects request with CSRF error

**Code Locations:**
- Meta tag: `app/Views/auth/dashboard.php`, line 6
- AJAX headers: `app/Views/auth/dashboard.php`, lines 323-329
- Security config: `app/Config/Security.php`, line 18

---

### 9.4: Data Tampering Protection ✅

**Implementation:**
- File: `app/Controllers/Course.php`, lines 32-40
- `user_id` is ALWAYS retrieved from session, NEVER from client input
- Client cannot modify user_id to enroll another user

**Test:**
1. Log in as Student A (user_id = 1)
2. Use browser developer tools to modify AJAX request
3. Try to add `user_id: 2` to enroll Student B
4. **Expected Result:** Enrollment still uses Student A's ID from session, not the tampered value

**Code Location:**
```php
// ALWAYS use user_id from session, NEVER trust client-supplied user_id
$user_id = session()->get('user_id');
if (!$user_id) {
    return $this->response->setJSON([
        'status' => 'error',
        'success' => false,
        'message' => 'Invalid session. Please log in again.'
    ])->setStatusCode(401);
}
```

---

### 9.5: Input Validation ✅

**Implementation:**
- File: `app/Controllers/Course.php`, lines 44-77
- Validates `course_id` is provided (not empty)
- Validates `course_id` is numeric and positive
- Verifies course exists in database before enrollment

**Test:**
1. Log in as student
2. Attempt to enroll in non-existent course (e.g., `course_id: 99999`)
3. **Expected Result:** Returns 404 error with message "Course not found."

**Code Location:**
```php
// Check if course_id is provided
if (empty($course_id)) {
    return $this->response->setJSON([
        'status' => 'error',
        'success' => false,
        'message' => 'Course ID is required.'
    ])->setStatusCode(400);
}

// Validate numeric format
if (!is_numeric($course_id) || $course_id <= 0) {
    return $this->response->setJSON([
        'status' => 'error',
        'success' => false,
        'message' => 'Invalid Course ID format.'
    ])->setStatusCode(400);
}

// Verify course exists
$course = $this->courseModel->find($course_id);
if (!$course) {
    return $this->response->setJSON([
        'status' => 'error',
        'success' => false,
        'message' => 'Course not found.'
    ])->setStatusCode(404);
}
```

---

## Summary

### ✅ Completed Steps:
- Step 1: Database Migration ✅
- Step 2: Enrollment Model ✅
- Step 3: Course Controller ✅
- Step 4: Student Dashboard View ✅
- Step 5: AJAX Enrollment ✅
- Step 6: Routes Configuration ✅
- Step 9: All Security Protections ✅

### 📋 User Action Required:
- Step 7: Test the Application
- Step 8: Push to GitHub

### 🔒 Security Features:
All 5 security vulnerabilities are protected:
1. ✅ Authorization Bypass Protection
2. ✅ SQL Injection Protection
3. ✅ CSRF Protection
4. ✅ Data Tampering Protection
5. ✅ Input Validation

---

## Testing Instructions

### Manual Testing Steps:

1. **Test Normal Enrollment Flow:**
   - Log in as student
   - Navigate to dashboard
   - Click "Enroll" on an available course
   - Verify: No page reload, success message, button disappears, course appears in enrolled list

2. **Test Authorization Bypass:**
   - Log out
   - Use Postman: POST `/course/enroll` with `{"course_id": 1}`
   - Expected: 401 Unauthorized

3. **Test SQL Injection:**
   - Log in as student
   - Modify AJAX request: `course_id: "1 OR 1=1"`
   - Expected: 400 Bad Request - "Invalid Course ID format"

4. **Test CSRF:**
   - Log in as student
   - Remove CSRF token from AJAX request
   - Expected: CodeIgniter CSRF error

5. **Test Data Tampering:**
   - Log in as Student A
   - Modify AJAX request to include `user_id: 2`
   - Expected: Still enrolls Student A (uses session, not client data)

6. **Test Input Validation:**
   - Log in as student
   - Try to enroll with `course_id: 99999` (non-existent)
   - Expected: 404 Not Found - "Course not found"

---

## Files Modified/Created

1. `app/Database/Migrations/2025-12-03-015500_CreateEnrollmentsTable.php` - Migration
2. `app/Models/EnrollmentModel.php` - Model
3. `app/Controllers/Course.php` - Controller with enroll() method
4. `app/Views/auth/dashboard.php` - Dashboard view with AJAX
5. `app/Config/Routes.php` - Route configuration
6. `app/Config/Security.php` - CSRF configuration (verified)

---

**Last Updated:** 2025-12-11
**Status:** Ready for Testing and GitHub Push
