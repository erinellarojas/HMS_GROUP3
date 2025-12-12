<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enrollment - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: #7c3aed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-600 to-indigo-800">

    <?= view('templates/header') ?>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">
                    Course Enrollment
                </h1>
                <p class="text-indigo-200">Browse and enroll in available courses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (!empty($available_courses)): ?>
                    <?php foreach ($available_courses as $course): ?>
                        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-200">
                            <h3 class="text-xl font-bold text-white mb-2"><?= esc($course['course_name']) ?></h3>
                            <p class="text-indigo-100 mb-4"><?= esc($course['description']) ?></p>
                            <p class="text-sm text-indigo-200 mb-4">
                                <strong>Instructor:</strong> <?= esc($course['instructor_name']) ?>
                            </p>
                            <button
                                class="enroll-btn w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                                data-course-id="<?= $course['id'] ?>"
                                data-course-title="<?= esc($course['course_name']) ?>"
                            >
                                Enroll Now
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 text-center">
                        <p class="text-white">No courses available for enrollment at this time.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Success/Error Message Container -->
    <div id="message-container" class="fixed top-4 right-4 z-50 hidden">
        <div id="message-content" class="px-4 py-2 rounded-lg shadow-lg text-white"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('.enroll-btn').on('click', function() {
                const courseId = $(this).data('course-id');
                const courseTitle = $(this).data('course-title');
                const button = $(this);

                // Disable button and show loading state
                button.prop('disabled', true).text('Enrolling...');

                // Send AJAX request
                $.ajax({
                    url: '/course/enroll',
                    type: 'POST',
                    data: {
                        course_id: courseId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showMessage('Success: ' + response.message, 'success');
                            // Remove the course card or update it
                            button.closest('.bg-white\\/10').fadeOut(500, function() {
                                $(this).remove();
                                // Check if no courses left
                                if ($('.enroll-btn').length === 0) {
                                    location.reload();
                                }
                            });
                        } else {
                            showMessage('Error: ' + response.message, 'error');
                            button.prop('disabled', false).text('Enroll Now');
                        }
                    },
                    error: function() {
                        showMessage('Error: Failed to process enrollment request', 'error');
                        button.prop('disabled', false).text('Enroll Now');
                    }
                });
            });

            function showMessage(message, type) {
                const container = $('#message-container');
                const content = $('#message-content');

                content.removeClass('bg-green-500 bg-red-500').addClass(type === 'success' ? 'bg-green-500' : 'bg-red-500');
                content.text(message);

                container.removeClass('hidden').fadeIn();

                // Hide after 5 seconds
                setTimeout(function() {
                    container.fadeOut();
                }, 5000);
            }
        });
    </script>

</body>
</html>
