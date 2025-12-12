<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Courses - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="gradient-bg">

    <?= view('templates/header') ?>

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-6xl w-full">

            <!-- Navigation -->
            <div class="w-full text-left mb-8">
                <a href="<?= site_url('dashboard') ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    System Courses
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Welcome, <span class="text-red-300"><?= esc($user_name) ?></span>! Manage all system courses here.
                </p>
                <a href="<?= site_url('admin/courses/create') ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Create New Course
                </a>
            </div>

            <!-- Courses Table -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-red-300 flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        All Courses
                    </h2>
                </div>

                <!-- Search Interface - At the top of the course list -->
                <div class="mb-6 pb-6 border-b border-white/20">
                    <form id="searchForm" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                        <input type="text" 
                               id="searchInput" 
                               name="q" 
                               placeholder="Search by first letter (e.g., type 'W' for courses starting with W)..." 
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               autocomplete="off">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Search
                            </button>
                            <button type="button" 
                                    id="clearSearch" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                Clear
                            </button>
                        </div>
                    </form>
                    <div id="searchResultsInfo" class="mt-4 text-white/70 text-sm hidden"></div>
                </div>

                <?php if (empty($courses)): ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-white/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="text-white/70 text-lg">No courses found.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="border-b border-white/20">
                                    <th class="text-left py-4 px-4 font-semibold text-red-300">Course Name</th>
                                    <th class="text-left py-4 px-4 font-semibold text-red-300">Instructor</th>
                                    <th class="text-left py-4 px-4 font-semibold text-red-300">Description</th>
                                    <th class="text-center py-4 px-4 font-semibold text-red-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="coursesTableBody">
                                <?php foreach ($courses as $course): ?>
                                    <tr class="course-row border-b border-white/10 hover:bg-white/5 transition duration-200" 
                                        data-course-name="<?= htmlspecialchars(strtolower($course['course_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                        data-course-code="<?= htmlspecialchars(strtolower($course['course_code'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                        data-description="<?= htmlspecialchars(strtolower($course['description'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                        <td class="py-4 px-4">
                                            <div class="font-semibold text-white"><?= esc($course['course_name']) ?></div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-white/80"><?= esc($course['instructor_name'] ?? 'Not assigned') ?></div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-white/80 truncate max-w-xs"><?= esc($course['description'] ?? 'No description') ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="<?= site_url('admin/courses/view/' . $course['id']) ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    View
                                                </a>
                                                <a href="<?= site_url('admin/courses/edit/' . $course['id']) ?>" class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                    Edit
                                                </a>
                                                <form action="<?= site_url('admin/courses/delete/' . $course['id']) ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- jQuery Scripts for Search Functionality -->
    <script>
        $(document).ready(function() {
            // Store original courses data for client-side filtering
            const originalCourses = $('.course-row').toArray();
            
            // Client-side filtering (instant feedback as user types)
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().toLowerCase().trim();
                filterCoursesClientSide(searchTerm);
            });
            
            // Client-side filtering function - Only matches courses that START WITH the typed letter
            function filterCoursesClientSide(searchTerm) {
                let visibleCount = 0;
                
                $('.course-row').each(function() {
                    const courseName = $(this).data('course-name') || '';
                    const courseCode = $(this).data('course-code') || '';
                    const description = $(this).data('description') || '';
                    
                    // Only show courses where the first letter matches (starts with)
                    const matches = searchTerm === '' || 
                                   courseName.startsWith(searchTerm) || 
                                   courseCode.startsWith(searchTerm) || 
                                   description.startsWith(searchTerm);
                    
                    if (matches) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });
                
                // Update results info
                updateResultsInfo(visibleCount, searchTerm, false);
            }
            
            // Server-side search via AJAX (when form is submitted)
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                
                const searchTerm = $('#searchInput').val().trim();
                
                if (searchTerm === '') {
                    // If empty, show all courses (client-side)
                    filterCoursesClientSide('');
                    return;
                }
                
                // Show loading state
                $('#searchResultsInfo').html('<span class="text-yellow-300">Searching...</span>').removeClass('hidden');
                
                // AJAX request to server
                $.ajax({
                    url: '<?= site_url('course/search') ?>',
                    type: 'POST',
                    data: {
                        q: searchTerm,
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Update table with search results
                            updateTableWithResults(response.results);
                            updateResultsInfo(response.count, searchTerm, true);
                        } else {
                            $('#searchResultsInfo').html('<span class="text-red-300">Search failed. Please try again.</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Search error:', error);
                        $('#searchResultsInfo').html('<span class="text-red-300">Error occurred during search. Please try again.</span>');
                    }
                });
            });
            
            // Update table with server-side search results
            function updateTableWithResults(results) {
                const tbody = $('#coursesTableBody');
                tbody.empty();
                
                if (results.length === 0) {
                    tbody.html('<tr><td colspan="4" class="py-8 text-center text-white/70">No courses found matching your search.</td></tr>');
                    return;
                }
                
                results.forEach(function(course) {
                    const courseName = escapeHtml(course.course_name || '').toLowerCase();
                    const courseCode = escapeHtml(course.course_code || '').toLowerCase();
                    const description = escapeHtml(course.description || '').toLowerCase();
                    
                    const row = `
                        <tr class="course-row border-b border-white/10 hover:bg-white/5 transition duration-200"
                            data-course-name="${courseName}"
                            data-course-code="${courseCode}"
                            data-description="${description}">
                            <td class="py-4 px-4">
                                <div class="font-semibold text-white">${escapeHtml(course.course_name || 'N/A')}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-white/80">${escapeHtml(course.instructor_name || 'Not assigned')}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-white/80 truncate max-w-xs">${escapeHtml(course.description || 'No description')}</div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex space-x-2 justify-center">
                                    <a href="<?= site_url('admin/courses/view/') ?>${course.id}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                        View
                                    </a>
                                    <a href="<?= site_url('admin/courses/edit/') ?>${course.id}" class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-1 px-3 rounded text-sm transition duration-200">
                                        Edit
                                    </a>
                                    <form action="<?= site_url('admin/courses/delete/') ?>${course.id}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
            
            // Update results info display
            function updateResultsInfo(count, searchTerm, isServerSide) {
                const infoDiv = $('#searchResultsInfo');
                if (searchTerm === '') {
                    infoDiv.addClass('hidden');
                    return;
                }
                
                const source = isServerSide ? 'server-side' : 'client-side';
                const message = count === 0 
                    ? `<span class="text-red-300">No courses found matching "${escapeHtml(searchTerm)}"</span>`
                    : `<span class="text-green-300">Found ${count} course(s) matching "${escapeHtml(searchTerm)}" (${source} search)</span>`;
                
                infoDiv.html(message).removeClass('hidden');
            }
            
            // Clear search functionality
            $('#clearSearch').on('click', function() {
                $('#searchInput').val('');
                filterCoursesClientSide('');
                $('#searchResultsInfo').addClass('hidden');
                
                // Reload page to show all courses
                window.location.href = '<?= site_url('admin/courses') ?>';
            });
            
            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
            }
        });
    </script>

</body>
</html>
