<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | {{ \App\Models\Setting::getValue('pharmacy_name', 'PharmaStock') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center px-4">
        <div class="text-9xl font-bold text-emerald-600 mb-4">404</div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Page Not Found</h1>
        <p class="text-gray-500 mb-8">The page you are looking for doesn't exist or has been moved.</p>
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            <span>←</span>
            <span>Back to Dashboard</span>
        </a>
    </div>
</body>
</html>