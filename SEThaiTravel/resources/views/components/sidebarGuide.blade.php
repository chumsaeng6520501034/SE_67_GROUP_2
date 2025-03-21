<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inknut Antiqua', serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Button Toggle Sidebar -->
    <button id="toggleSidebar" class="fixed top-4 left-4 text-white bg-blue-700 p-3 rounded-md z-[100] shadow-lg hover:bg-blue-800">
        ☰
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-[#0F588C] text-white shadow-lg flex flex-col transform -translate-x-full transition-transform duration-300 z-50">
        <!-- User Profile -->
        <div class="p-6 text-center">
            <img class="h-16 w-16 rounded-full mx-auto border-2 border-white" src="https://avatars.githubusercontent.com/u/64538277" alt="avatar" />
            <h2 class="text-lg font-bold mt-2">{{session('userID')->name}}</h2>
        </div>

        <!-- Menu Items -->
        <nav class="flex flex-col space-y-2">
            <a href="/guideAddTourPage" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">ADD TOUR</a>
            <a href="/guideMyTour" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">MY TOUR</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">MY JOB</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">MY OFFER</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">JOB HISTORY</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">SELL HISTORY</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">CALENDAR</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">ALL PAYMENT</a>
            <a href="#" class="block py-3 px-6 hover:bg-blue-800 rounded transition duration-300">STATISTIC</a>
        </nav>

        <!-- Log Out -->
        <div class="mt-auto">
            <a href="/logOut" class="flex items-center justify-between py-3 px-6 hover:bg-red-700 transition duration-300 rounded">
                <span>LOG OUT</span>
                <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
            </a>
        </div>
    </aside>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        const toggleButton = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");

        toggleButton.addEventListener("click", () => {
            if (sidebar.classList.contains("-translate-x-full")) {
                sidebar.classList.remove("-translate-x-full");
                sidebar.classList.add("translate-x-0");
            } else {
                sidebar.classList.remove("translate-x-0");
                sidebar.classList.add("-translate-x-full");
            }
        });
    </script>

</body>
</html>
