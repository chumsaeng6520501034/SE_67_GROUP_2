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
    <button id="toggleSidebar" class="fixed top-4 left-4 text-white text-2xl p-3 rounded-md z-[110] shadow-lg hover:bg-blue-800 transition-all duration-300">
        ☰
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white shadow-lg flex flex-col transform -translate-x-full transition-transform duration-300 z-50 pt-16">
        <!-- Menu Items -->
        <nav class="flex flex-col space-y-1">
            <a href="/signUp" class="block py-3 px-6 hover:bg-gray-700 rounded transition duration-300">SIGN UP</a>
            <a href="/logIn" class="block py-3 px-6 hover:bg-gray-700 rounded transition duration-300">LOG IN</a>
        </nav>
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
