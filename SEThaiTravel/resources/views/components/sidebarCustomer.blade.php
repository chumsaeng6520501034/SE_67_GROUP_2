<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Button Toggle Sidebar -->
    <button id="toggleSidebar" class="fixed top-4 left-4 text-white text-2xl p-2 rounded-md z-[110]">
        ☰
    </button>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white shadow-lg flex flex-col transform z-50 transition-transform duration-300 ">
        <!-- User Profile -->
        <div class="p-6 text-center">
            <a href="/customerProfile">
                <img class="h-16 w-16 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/64538277"
                alt="avatar" />
            </a>
            <h2 class="text-lg font-bold mt-2">{{session('userID')->name}}</h2>
        </div>

        <!-- Menu Items -->
        <nav class="flex flex-col space-y-1">
            <a href="/home" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">SEARCH</a>
            <a href="/addTour" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">ADD TOUR</a>
            <a href="/myRequest" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">MY REQUEST</a>
            <a href="/history" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">HISTORY</a>
            <a href="/myBooking" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">MY BOOKING</a>
            <a href="/calendar" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">CALENDAR</a>
            <a href="/payments" class="block py-3 px-6 hover:bg-gray-700 transition duration-300 rounded">MY PAYMENT</a>
        </nav>

        <!-- Log Out -->
        <div class="mt-auto">
            <a href="/logOut"
                class="flex items-center justify-between py-3 px-6 hover:bg-red-700 transition duration-300 rounded">
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
