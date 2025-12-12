<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User - ITE311-BUHISAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <div class="max-w-4xl w-full">

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    User Details
                </h1>
                <p class="text-xl text-white/80 mb-8">
                    Viewing details for <span class="text-red-300"><?= esc($user['name']) ?></span>
                </p>
            </div>

            <!-- User Details Card -->
            <div class="glass-card rounded-2xl p-6 md:p-8 text-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-red-300">Basic Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Full Name</label>
                                <p class="text-white text-lg font-semibold"><?= esc($user['name']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Email Address</label>
                                <p class="text-white text-lg"><?= esc($user['email']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Role</label>
                                <span class="bg-red-600/50 px-3 py-1 rounded-full text-sm font-semibold text-red-100 capitalize">
                                    <?= esc($user['role']) ?>
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Account Created</label>
                                <p class="text-white text-lg">
                                    <?= esc(date('F d, Y \a\t g:i A', strtotime($user['created_at']))) ?>
                                </p>
                            </div>
                            <?php if (isset($user['updated_at']) && $user['updated_at']): ?>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-1">Last Updated</label>
                                <p class="text-white text-lg">
                                    <?= esc(date('F d, Y \a\t g:i A', strtotime($user['updated_at']))) ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-red-300">Actions</h3>
                        <div class="space-y-4">
                            <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="w-full bg-yellow-500 hover:bg-yellow-600 text-purple-900 font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit User
                            </a>
                            <form action="<?= site_url('admin/users/delete/' . $user['id']) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
