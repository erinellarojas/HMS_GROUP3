# Duplicate Prevention Implementation Summary

This document summarizes all duplicate prevention mechanisms implemented in the system.

## ✅ Duplicate Prevention Mechanisms

### 1. Enrollments (User-Course Pairs) ✅

**Database Level:**
- ✅ Unique constraint on `[user_id, course_id]` in `enrollments` table
- ✅ Prevents duplicate enrollments at database level

**Application Level:**
- ✅ `EnrollmentModel::isAlreadyEnrolled()` method checks before enrollment
- ✅ `Course::enroll()` controller method validates before inserting
- ✅ Returns 409 Conflict status if duplicate detected

**Files:**
- `app/Database/Migrations/2025-12-03-015500_CreateEnrollmentsTable.php` (line 45)
- `app/Models/EnrollmentModel.php` (line 28-32)
- `app/Controllers/Course.php` (line 79-86)

---

### 2. Users (Email Addresses) ✅

**Database Level:**
- ✅ Unique constraint on `email` field in `users` table
- ✅ Prevents duplicate email addresses

**Application Level:**
- ✅ Validation rule: `is_unique[users.email]` in registration
- ✅ Validation rule: `is_unique[users.email]` in user update (with exclusion)

**Files:**
- `app/Database/Migrations/2024_01_01_000001_create_users_table.php`
- `app/Controllers/Admin.php` (line 132, 240)
- `app/Models/UserModel.php` (line 25)

---

### 3. Courses (Course Names and Codes) ✅

**Database Level:**
- ⚠️ No unique constraint (allows flexibility for future requirements)
- ✅ Application-level validation prevents duplicates

**Application Level:**
- ✅ `is_unique[courses.course_name]` validation rule in create
- ✅ `is_unique[courses.course_code]` validation rule in create
- ✅ Additional duplicate check in `storeCourse()` method
- ✅ Update validation excludes current course from uniqueness check
- ✅ Additional duplicate check in `updateCourse()` method

**Files:**
- `app/Controllers/Admin.php`:
  - `storeCourse()` method (lines 414-435)
  - `updateCourse()` method (lines 338-368)

**Implementation:**
```php
// Create Course
$rules = [
    'course_name' => 'required|min_length[3]|is_unique[courses.course_name]',
    'course_code' => 'required|min_length[2]|is_unique[courses.course_code]',
    // ... additional checks in code
];

// Update Course
// Dynamically adds is_unique only if value changed
if ($newCourseName !== $course['course_name']) {
    $rules['course_name'] .= '|is_unique[courses.course_name]';
}
```

---

### 4. Materials (File Names per Course) ✅

**Database Level:**
- ✅ Unique constraint on `[course_id, file_name]` in `materials` table
- ✅ Migration: `2025-12-11-153104_AddUniqueConstraintToMaterialsTable.php`
- ✅ Prevents duplicate file names in the same course

**Application Level:**
- ✅ `MaterialModel::isDuplicateMaterial()` method checks before upload
- ✅ `Materials::upload()` controller method validates before inserting
- ✅ Returns error message if duplicate detected

**Files:**
- `app/Database/Migrations/2025-12-11-153104_AddUniqueConstraintToMaterialsTable.php`
- `app/Models/MaterialModel.php` (line 32-37)
- `app/Controllers/Materials.php` (line 102-105)

**Implementation:**
```php
// Check for duplicate
if ($this->materialModel->isDuplicateMaterial($course_id, $originalName)) {
    return redirect()->back()->with('error', 
        'A file with the same name already exists for this course.');
}
```

**Note:** Same filename can exist in different courses, but not in the same course.

---

## Summary Table

| Entity | Duplicate Prevention | Database Constraint | Application Check | Status |
|--------|---------------------|---------------------|-------------------|--------|
| **Enrollments** | User-Course pair | ✅ Unique Key | ✅ `isAlreadyEnrolled()` | ✅ Complete |
| **Users** | Email address | ✅ Unique Key | ✅ `is_unique` validation | ✅ Complete |
| **Courses** | Course name | ❌ None | ✅ `is_unique` + code check | ✅ Complete |
| **Courses** | Course code | ❌ None | ✅ `is_unique` + code check | ✅ Complete |
| **Materials** | File name per course | ✅ Unique Key | ✅ `isDuplicateMaterial()` | ✅ Complete |

---

## Testing Duplicate Prevention

### Test Enrollments:
1. Enroll student in course
2. Try to enroll same student in same course again
3. **Expected:** Error message "You are already enrolled in this course" (409 Conflict)

### Test Users:
1. Register with email: `test@example.com`
2. Try to register again with same email
3. **Expected:** Validation error "This email address is already registered"

### Test Courses:
1. Create course with name "Web Development"
2. Try to create another course with same name
3. **Expected:** Validation error "A course with this name already exists"

### Test Materials:
1. Upload file "lesson1.pdf" to a course
2. Try to upload "lesson1.pdf" to same course again
3. **Expected:** Error message "A file with the same name already exists for this course"
4. Upload "lesson1.pdf" to different course
5. **Expected:** Success (allowed - different course)

---

## Migration Status

**Pending Migration:**
- `2025-12-11-153104_AddUniqueConstraintToMaterialsTable.php`
  - **Status:** Ready to run
  - **Note:** There's a separate issue with `schedule_time` migration that needs to be resolved first
  - **Action:** Run migration after resolving schedule_time issue, or run manually:
    ```sql
    ALTER TABLE `materials` ADD UNIQUE KEY `unique_course_file` (`course_id`, `file_name`);
    ```

---

## Code Locations

### Enrollment Duplicate Prevention:
- Migration: `app/Database/Migrations/2025-12-03-015500_CreateEnrollmentsTable.php:45`
- Model: `app/Models/EnrollmentModel.php:28-32`
- Controller: `app/Controllers/Course.php:79-86`

### User Duplicate Prevention:
- Migration: `app/Database/Migrations/2024_01_01_000001_create_users_table.php:21`
- Controller: `app/Controllers/Admin.php:132, 240`
- Model: `app/Models/UserModel.php:25`

### Course Duplicate Prevention:
- Controller: `app/Controllers/Admin.php:414-435` (create), `338-368` (update)

### Material Duplicate Prevention:
- Migration: `app/Database/Migrations/2025-12-11-153104_AddUniqueConstraintToMaterialsTable.php`
- Model: `app/Models/MaterialModel.php:32-37`
- Controller: `app/Controllers/Materials.php:102-105`

---

**Last Updated:** 2025-12-11
**Status:** All duplicate prevention mechanisms implemented ✅
