<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - ITE311-BUHISAN</title>
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
        <div class="max-w-2xl w-full">

            <!-- Navigation -->
            <div class="w-full text-left mb-8">
                <a href="<?= site_url('admin/users') ?>" class="text-white/80 hover:text-white transition duration-200 inline-flex items-center text-lg">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Users
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Create New User
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Add a new user to the system.
                </p>
            </div>

            <!-- Create User Form -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <form action="<?= site_url('admin/create-user') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-red-300 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="<?= old('name') ?>" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Enter full name" required>
                        <?php if (isset($errors['name'])): ?>
                            <p class="text-red-400 text-sm mt-1"><?= $errors['name'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-red-300 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= old('email') ?>" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Enter email address" required>
                        <?php if (isset($errors['email'])): ?>
                            <p class="text-red-400 text-sm mt-1"><?= $errors['email'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-red-300 mb-2">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Enter password" required>
                        <?php if (isset($errors['password'])): ?>
                            <p class="text-red-400 text-sm mt-1"><?= $errors['password'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-8">
                        <label for="role" class="block text-sm font-medium text-red-300 mb-2">User Role</label>
                        <select id="role" name="role" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                            <option value="">Select a role</option>
                            <option value="student" <?= old('role') === 'student' ? 'selected' : '' ?>>Student</option>
                            <option value="teacher" <?= old('role') === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <?php if (isset($errors['role'])): ?>
                            <p class="text-red-400 text-sm mt-1"><?= $errors['role'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Create User
                        </button>
                        <a href="<?= site_url('admin/users') ?>" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
