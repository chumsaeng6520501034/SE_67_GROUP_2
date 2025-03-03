<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <div class="flex h-screen">
        @include('components.sidebarUser')
        <!-- Main Content -->
        <main class="flex-1 relative">
            <div class="relative h-80 w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <h1 class="absolute top-20 left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1>
            
            
            <!-- Search Box -->
            <div class="absolute top-[120%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-100 p-10 rounded-lg shadow-lg w-3/4">
                <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                    <span class="text-gray-500 pr-2">🔍</span>
                    <input type="text" placeholder="location" class="w-full outline-none">
                </div>
                <div class="flex justify-between mt-4">
                    <div class="w-1/3">
                        <label class="text-sm font-semibold">Start Date</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">📅</span>
                            <input type="date" class="outline-none w-full">
                        </div>
                    </div>
                    <div class="w-1/3">
                        <label class="text-sm font-semibold">End Date</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">📅</span>
                            <input type="date" class="outline-none w-full">
                        </div>
                    </div>
                    <div class="w-1/4">
                        <label class="text-sm font-semibold">Person</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">👤</span>
                            <input type="number" class="outline-none w-full" min="1" value="1">
                        </div>
                    </div>
                </div>
                <button class="mt-4 bg-yellow-500 text-white px-6 py-2 rounded w-[20%] mx-auto block">SUBMIT</button>
            </div>
        </main>
        
    </div>
</body>
</html>
