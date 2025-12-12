<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ITE311-BUHISAN</title>
    <!-- Load Tailwind CSS CDN for styling -->
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
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-white">
                Sign in to your account
            </h2>
        </div>

        <!-- Login Form -->
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 border border-white/10">
            <form action="<?= site_url('login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-500/20 border border-red-500/30 text-red-100 px-4 py-3 rounded-lg">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-white/80">Email address</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full px-3 py-2 border border-white/20 rounded-md shadow-sm bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-white/80">Password</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 block w-full px-3 py-2 border border-white/20 rounded-md shadow-sm bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign In
                    </button>
                </div>

                <div class="text-center">
                    <p class="mt-4 text-sm text-white/80">
                        Don't have an account?
                        <a href="<?= site_url('register') ?>" class="font-medium text-indigo-200 hover:text-indigo-100">
                            Create one here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
