<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .enrolled-card {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .available-card {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .quick-access-btn {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            transition: all 0.3s ease;
        }

        .quick-access-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
        }
    </style>
</head>
<body class="min-h-screen">

    <?= view('templates/header') ?>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">
                    Welcome, <?= esc($user_name) ?>!
                    <span class="text-xl font-normal text-purple-200">(Student)</span>
                </h1>
                <p class="text-indigo-200">This is your student dashboard.</p>
            </div>

            <!-- Alert Messages -->
            <div id="alert-container" class="mb-6"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Enrolled Courses -->
                <div class="dashboard-card enrolled-card rounded-xl p-8 shadow-2xl">
                    <h2 class="text-3xl font-extrabold text-white mb-4 flex items-center">
                        <span class="mr-3">📚</span> My Enrolled Courses
                    </h2>
                    <div id="enrolled-courses">
                        <?php if (!empty($enrolledCourses)): ?>
                            <?php foreach ($enrolledCourses as $course): ?>
                                <div class="bg-white/20 rounded-lg p-4 mb-3 backdrop-blur-sm">
                                    <h3 class="text-white font-semibold"><?= esc($course['course_name']) ?></h3>
                                    <p class="text-green-100 text-sm"><?= esc($course['description']) ?></p>
                                    <p class="text-green-200 text-xs mt-1">Enrolled on: <?= date('M d, Y', strtotime($course['enrolled_at'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-green-100">You haven't enrolled in any courses yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Available Courses -->
                <div class="dashboard-card available-card rounded-xl p-8 shadow-2xl">
                    <h2 class="text-3xl font-extrabold text-white mb-4 flex items-center">
                        <span class="mr-3">🎓</span> Available Courses
                    </h2>
                    <div id="available-courses">
                        <?php if (!empty($availableCourses)): ?>
                            <?php foreach ($availableCourses as $course): ?>
                                <div class="bg-white/20 rounded-lg p-4 mb-3 backdrop-blur-sm">
                                    <h3 class="text-white font-semibold"><?= esc($course['course_name']) ?></h3>
                                    <p class="text-blue-100 text-sm mb-3"><?= esc($course['description']) ?></p>
                                    <button class="enroll-btn bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded transition duration-200 backdrop-blur-sm"
                                            data-course-id="<?= $course['id'] ?>">
                                        Enroll
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-blue-100">No courses available for enrollment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Access Links -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-white mb-4">Quick Access</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="/student/courses" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                        📚 My Courses
                    </a>
                    <a href="/student/assignments" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                        📝 Assignments
                    </a>
                    <a href="/student/grades" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                        📊 Grades
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.enroll-btn').on('click', function(e) {
                e.preventDefault();

                var courseId = $(this).data('course-id');
                var button = $(this);
                var courseCard = button.closest('.bg-white\\/20');

                // Disable button to prevent multiple clicks
                button.prop('disabled', true).text('Enrolling...');

                $.post('/course/enroll', { course_id: courseId }, function(response) {
                    if (response.status === 'success') {
                        // Show success message
                        showAlert('success', response.message);

                        // Move course to enrolled list
                        moveToEnrolled(courseCard, courseId);

                        // Remove from available courses
                        courseCard.fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        // Show error message
                        showAlert('error', response.message);

                        // Re-enable button
                        button.prop('disabled', false).text('Enroll');
                    }
                }).fail(function() {
                    showAlert('error', 'An error occurred. Please try again.');
                    button.prop('disabled', false).text('Enroll');
                });
            });

            function showAlert(type, message) {
                var alertClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                var alertHtml = '<div class="' + alertClass + ' text-white px-4 py-3 rounded mb-4">' + message + '</div>';

                $('#alert-container').html(alertHtml);

                // Auto-hide after 5 seconds
                setTimeout(function() {
                    $('#alert-container').fadeOut(300, function() {
                        $(this).html('');
                    });
                }, 5000);
            }

            function moveToEnrolled(courseCard, courseId) {
                var courseTitle = courseCard.find('h3').text();
                var courseDesc = courseCard.find('p').first().text();
                var currentDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

                var enrolledHtml = '<div class="bg-white/10 rounded-lg p-4 mb-3">' +
                    '<h3 class="text-white font-semibold">' + courseTitle + '</h3>' +
                    '<p class="text-green-100 text-sm">' + courseDesc + '</p>' +
                    '<p class="text-green-200 text-xs mt-1">Enrolled on: ' + currentDate + '</p>' +
                    '</div>';

                $('#enrolled-courses').append(enrolledHtml);
            }
        });
    </script>

</body>
</html>
