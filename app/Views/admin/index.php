<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ITE311-BUHISAN</title>
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
                    Admin Dashboard
                </h1>
                <p class="text-indigo-200">Manage the system and users.</p>
            </div>

            <div class="bg-red-700/80 backdrop-blur-sm rounded-xl p-8 shadow-2xl border-4 border-red-500/50">
                <h2 class="text-3xl font-extrabold text-white mb-4 flex items-center">
                    <span class="mr-3">👑</span> Administrator Access
                </h2>
                <p class="text-red-100 mb-6">You have ultimate control over the entire system. Manage user accounts, system settings, and school structure.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="/admin/users" class="bg-white text-red-700 hover:bg-red-100 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        Manage Users
                    </a>
                    <a href="/admin/settings" class="bg-red-500 text-white hover:bg-red-600 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        System Settings
                    </a>
                    <a href="/admin/logs" class="bg-red-900 text-white/90 hover:bg-red-800 font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md">
                        View Activity Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
