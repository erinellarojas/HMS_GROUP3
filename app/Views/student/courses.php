
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Classes - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: #ffffff;
        }
    </style>
</head>
<body class="gradient-bg">

    <?= view('templates/header') ?>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    My Courses
                    <span class="text-xl font-normal text-gray-600">(<?= esc($user_name) ?>)</span>
                </h1>
                <p class="text-gray-600">View your enrolled courses.</p>
            </div>

            <!-- Enrolled Courses Section -->
            <?php if (!empty($enrolled_courses)): ?>
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Enrolled Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($enrolled_courses as $course): ?>
                            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-md hover:shadow-lg transition duration-200">
                                <div class="flex items-center mb-4">
                                    <span class="text-3xl mr-3">📚</span>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800"><?= esc($course['course_name']) ?></h3>
                                        <p class="text-gray-600 text-sm">Instructor: <?= !empty($course['instructor_name']) ? esc($course['instructor_name']) : 'Not assigned' ?></p>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4"><?= esc($course['description']) ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 text-sm font-medium">Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'])) ?></span>
                                    <a href="<?= site_url('student/course/' . $course['id']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                    <?php else: ?>
                <!-- Empty State -->
                <div class="bg-white rounded-xl p-12 border border-gray-200 shadow-md text-center">
                            <span class="text-6xl mb-4 block">📚</span>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Enrolled Courses</h3>
                    <p class="text-gray-600">You are not currently enrolled in any courses.</p>
                        </div>
                    <?php endif; ?>

        </div>
    </div>

</body>
</html>
