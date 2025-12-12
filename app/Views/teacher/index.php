<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    Teacher Dashboard
                </h1>
                <p class="text-indigo-200">Welcome back! Access your courses, grade assignments, and communicate with your enrolled students.</p>
            </div>

            <div class="bg-blue-700/80 backdrop-blur-sm rounded-xl p-8 shadow-2xl border-4 border-blue-500/50">
                <h2 class="text-3xl font-extrabold text-white mb-4 flex items-center">
                    <span class="mr-3">🧑‍🏫</span> Teacher Portal Access
                </h2>
                <p class="text-blue-100 mb-6">Welcome back! Access your courses, grade assignments, and communicate with your enrolled students.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="/teacher/classes" class="bg-white text-blue-700 hover:bg-blue-100 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        My Courses
                    </a>
                    <a href="/teacher/assignments" class="bg-blue-500 text-white hover:bg-blue-600 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        Assignments
                    </a>
                    <a href="/teacher/grades" class="bg-blue-900 text-white/90 hover:bg-blue-800 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        Grade Entry
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
