<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inknut Antiqua', serif;
        }
        #sidebar {
            position: fixed;
            z-index: 50; /* ทำให้ Sidebar อยู่ด้านหน้าสุด */
        }
        .hero img {
            position: relative;
            z-index: 1; /* ทำให้รูปภาพอยู่ข้างหลัง Sidebar */
        }
    </style>
</head>
<body class="bg-gray-900">
    <div class="flex h-screen">
    <button id="toggleSidebar" class="fixed top-4 left-4 bg-blue-500 text-white p-2 rounded-md z-50">
            ☰
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 w-64 h-screen bg-[#0F588C] text-white shadow-lg flex flex-col transform -translate-x-full transition-transform duration-300">
            <!-- User Profile -->
            <div class="p-6 text-center">
                <img class="h-16 w-16 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/64538277"
                    alt="avatar" />
            </div>

            <!-- Menu Items -->
            <nav class="flex flex-col space-y-2">
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">ADD TOUR</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY TOUR</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">HISTORY</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY REVIEW</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY BOOKING</a>
                <a href="/calendar" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">CALENDAR</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY PAYMENT</a>
            </nav>

            <!-- Log Out -->
            <div class="mt-auto">
                <a href="/logOut"
                    class="flex items-center justify block py-3 px-6 hover:bg-red-700 transition duration-300">
                    <span>LOG OUT</span>
                </a>
            </div>
        </aside>

        <script>
            const toggleButton = document.getElementById("toggleSidebar");
            const sidebar = document.getElementById("sidebar");
            toggleButton.addEventListener("click", () => {
                sidebar.classList.toggle("-translate-x-full");
            });
        </script>

        <!-- Main Content -->
        <main class="flex-1 relative">
            <div class="relative h-80 w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover hero">
                <h1 class="absolute top-20 left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1>
            </div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-100 p-10 rounded-lg shadow-lg w-3/4">
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
