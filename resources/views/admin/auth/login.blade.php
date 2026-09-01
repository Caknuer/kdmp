<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - KDMP Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-rose-500 via-rose-600 to-red-700 min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-rose-600 to-rose-700 px-8 py-12 text-center">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-crown text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">KDMP Admin</h1>
                <p class="text-rose-100">Sistem Manajemen Koperasi</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.login.store') }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm font-semibold text-red-800 mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i> Login Gagal
                    </p>
                    @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-rose-600"></i> Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="admin@kdmp.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : '' }}"
                           required>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-rose-600"></i> Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="••••••••"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent {{ $errors->has('password') ? 'border-red-500' : '' }}"
                           required>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-red-700 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login Sekarang
                </button>

                <!-- Info Text -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-xs text-blue-700">
                        <strong>Kredensial Default:</strong><br>
                        Email: {{ env('ADMIN_EMAIL', 'studio.mazte@gmail.com') }}<br>
                        Password: Sesuai dengan .env
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 text-center text-sm text-gray-600">
                <p>Hanya untuk administrator KDMP Wonokerto</p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-gray-100 transition">
                <i class="fas fa-home mr-2"></i> Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</body>
</html>
