# Materials Upload/Download System - Simple Explanation

## What Was Built?

A complete file management system that allows:
- **Admins/Teachers** to upload course materials (PDFs, PowerPoints, documents)
- **Students** to download materials for courses they are enrolled in
- **Secure access control** to prevent unauthorized downloads

---

## How It Works - Step by Step

### Step 1: Database Setup ✅
**What:** Created a `materials` table to store file information

**Fields:**
- `id` - Unique identifier for each material
- `course_id` - Links material to a specific course
- `file_name` - Original name of the uploaded file
- `file_path` - Location where file is stored on server
- `created_at` - When the file was uploaded

**Result:** Database is ready to store material records

---

### Step 2: Model Created ✅
**What:** Created `MaterialModel.php` to interact with database

**Methods:**
- `insertMaterial()` - Saves new material to database
- `getMaterialsByCourse()` - Gets all materials for a course
- `getMaterialById()` - Gets a specific material
- `isDuplicateMaterial()` - Prevents duplicate file names in same course

**Result:** Easy way to work with materials data

---

### Step 3: Controller Created ✅
**What:** Created `Materials.php` controller with 3 main functions

**Methods:**
1. **`upload($course_id)`** - Handles file uploads
   - Shows upload form (GET request)
   - Processes file upload (POST request)
   - Validates file type and size
   - Saves file to server
   - Saves record to database

2. **`delete($material_id)`** - Removes materials
   - Deletes file from server
   - Removes record from database

3. **`download($material_id)`** - Handles downloads
   - Checks if user is logged in
   - Verifies student is enrolled (for students)
   - Allows admin/teacher to download any material
   - Sends file to user's browser

**Result:** Complete file management functionality

---

### Step 4: File Upload Implementation ✅
**What:** Secure file upload with validation

**Features:**
- **File Type Validation:** Only allows PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG
- **File Size Limit:** Maximum 10MB per file
- **Unique Filenames:** Prevents overwriting existing files
- **Duplicate Prevention:** Same filename cannot be uploaded twice to same course
- **Secure Storage:** Files stored in `writable/uploads/materials/` directory

**Process:**
1. User selects file
2. System validates file type and size
3. System checks for duplicates
4. File is saved with unique name
5. Database record is created
6. Success message shown

**Result:** Safe and secure file uploads

---

### Step 5: Upload View Created ✅
**What:** User-friendly form for uploading files

**Features:**
- Clean, modern design using Tailwind CSS
- File input with drag-and-drop support
- Clear instructions on allowed file types
- Error messages for validation failures
- Success messages for completed uploads

**Location:** `app/Views/admin/upload_material.php`

**Result:** Easy-to-use upload interface

---

### Step 6: Student Materials Display ✅
**What:** Shows downloadable materials to enrolled students

**Features:**
- Lists all materials for the course
- Shows file name and upload date
- Download button for each material
- Empty state message when no materials exist
- Integrated into course detail page

**Location:** `app/Views/student/course_detail.php`

**Result:** Students can easily see and access course materials

---

### Step 7: Download Security ✅
**What:** Secure download with access control

**Security Checks:**
1. User must be logged in
2. **For Students:** Must be enrolled in the course
3. **For Admin/Teacher:** Can download any material
4. File must exist on server
5. Secure file path handling

**Process:**
1. User clicks download
2. System checks enrollment status
3. If authorized, file is sent to browser
4. If not authorized, error message shown

**Result:** Only authorized users can download materials

---

### Step 8: Routes Configured ✅
**What:** URLs set up for all material functions

**Routes Added:**
- `GET /admin/course/{id}/upload` - Show upload form
- `POST /admin/course/{id}/upload` - Process upload
- `GET /materials/delete/{id}` - Delete material
- `GET /materials/download/{id}` - Download material

**Result:** All features accessible via URLs

---

### Step 9: Testing Checklist ✅
**What:** Complete testing guide

**Test Scenarios:**
1. ✅ Admin uploads file → File saved, record created
2. ✅ Student views course → Materials listed
3. ✅ Student downloads file → File downloads successfully
4. ✅ Non-enrolled student tries download → Access denied
5. ✅ Admin deletes material → File and record removed
6. ✅ Duplicate file upload → Error message shown

**Result:** System fully tested and working

---

## Key Features

### 🔒 Security Features
- **Access Control:** Only enrolled students can download
- **File Validation:** Only safe file types allowed
- **Size Limits:** Prevents server overload
- **Path Security:** Prevents directory traversal attacks
- **Duplicate Prevention:** Prevents same file twice in same course

### 📁 File Management
- **Organized Storage:** Files stored in dedicated folder
- **Unique Names:** No file overwrites
- **Easy Deletion:** Remove files and records together
- **Clean Interface:** User-friendly upload and download

### 👥 User Experience
- **Clear Messages:** Success and error notifications
- **Easy Navigation:** Simple links and buttons
- **Visual Feedback:** Icons and styling
- **Responsive Design:** Works on all devices

---

## File Structure

```
writable/
└── uploads/
    └── materials/          ← Files stored here
        ├── file1.pdf
        ├── file2.pptx
        └── ...

app/
├── Controllers/
│   └── Materials.php        ← Handles upload/download/delete
├── Models/
│   └── MaterialModel.php    ← Database operations
├── Views/
│   ├── admin/
│   │   ├── upload_material.php    ← Upload form
│   │   └── view_course.php         ← Shows materials list
│   └── student/
│       └── course_detail.php       ← Student materials view
└── Database/
    └── Migrations/
        └── CreateMaterialsTable.php ← Database structure
```

---

## How to Use

### For Admins/Teachers:

1. **Upload Material:**
   - Go to course details page
   - Click "Upload Material" button
   - Select file (PDF, PPT, DOC, etc.)
   - Click "Upload Material"
   - File is now available to students

2. **Delete Material:**
   - Go to course details page
   - Find material in list
   - Click "Delete" button
   - Confirm deletion
   - File and record removed

### For Students:

1. **View Materials:**
   - Go to "My Courses"
   - Click on a course
   - Scroll to "Course Materials" section
   - See all available materials

2. **Download Material:**
   - Click "Download" button next to material
   - File downloads to your computer
   - Open and use as needed

---

## Technical Details

### Allowed File Types:
- Documents: PDF, DOC, DOCX, TXT
- Presentations: PPT, PPTX
- Images: JPG, JPEG, PNG

### File Size Limit:
- Maximum: 10MB per file

### Storage Location:
- Server path: `writable/uploads/materials/`
- Files stored with unique random names
- Original filename saved in database

### Database Constraints:
- Unique constraint on `[course_id, file_name]`
- Prevents duplicate files in same course
- Foreign key to courses table

---

## Summary

✅ **Complete System:** All 9 steps implemented
✅ **Secure:** Access control and validation in place
✅ **User-Friendly:** Clean interface for all users
✅ **No Duplicates:** Prevention at database and application level
✅ **Tested:** Ready for production use

The materials system is fully functional and ready to use!
