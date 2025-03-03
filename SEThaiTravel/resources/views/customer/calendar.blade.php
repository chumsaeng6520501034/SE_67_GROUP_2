<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FullCalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* พื้นหลังเต็มหน้า */
        body {
            background-image: url('https://cdn.pixabay.com/photo/2019/11/10/08/31/beach-4615202_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inknut Antiqua', serif;
        }

        /* ใช้ transition เพื่อให้ sidebar และปฏิทินเคลื่อนที่แบบ smooth */
        #sidebar, #mainContent, #calendarContainer {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body>

    <div class="flex h-screen">
        <!-- Button Toggle Sidebar -->
        <button id="toggleSidebar" class="fixed top-4 left-4 bg-blue-500 text-white p-2 rounded-md z-50">
            ☰
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 w-64 h-screen bg-[#0F588C] text-white shadow-lg flex flex-col transform  transition-transform duration-300 ">
            <!-- User Profile -->
            <div class="p-6 text-center">
                <img class="h-16 w-16 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/64538277"
                    alt="avatar" />
                <h2 class="text-lg font-bold mt-2">{{session('userID')->name}}</h2>
            </div>

            <!-- Menu Items -->
            <nav class="flex flex-col space-y-2">
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">ADD TOUR</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY REQUEST</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">HISTORY</a>
                <a href="#" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY REVIEW</a>
                <a href="/myBooking" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY BOOKING</a>
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

        

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 p-5 flex justify-center transition-all duration-300">
            <div id="calendarContainer" class="bg-white p-5 rounded-lg shadow-md w-4/5 transition-all duration-300">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                contentHeight: 'auto',
                events: '/api/Calendar'
            });
            calendar.render();
    
            // ฟังก์ชัน Toggle Sidebar
            var toggleSidebarButton = document.getElementById('toggleSidebar');
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('mainContent');
            if (sidebar.classList.contains('-translate-x-full')) {
                    // Sidebar ถูกซ่อน -> Calendar ต้องชิดซ้าย
                    mainContent.style.marginLeft = "0px";
                } else {
                    // Sidebar ถูกเปิด -> Calendar ต้องขยับไปขวา
                    mainContent.style.marginLeft = "16rem"; // 16rem คือความกว้างของ Sidebar (w-64)
                }
    
                // ปรับขนาดปฏิทินให้ถูกต้องหลังจาก Sidebar เปลี่ยนขนาดเสร็จ
                setTimeout(function() {
                    calendar.updateSize();
                }, 300);
    
            toggleSidebarButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    // Sidebar ถูกซ่อน -> Calendar ต้องชิดซ้าย
                    mainContent.style.marginLeft = "0px";
                } else {
                    // Sidebar ถูกเปิด -> Calendar ต้องขยับไปขวา
                    mainContent.style.marginLeft = "16rem"; // 16rem คือความกว้างของ Sidebar (w-64)
                }
    
                // ปรับขนาดปฏิทินให้ถูกต้องหลังจาก Sidebar เปลี่ยนขนาดเสร็จ
                setTimeout(function() {
                    calendar.updateSize();
                }, 300);
            });
            
        });
    </script>
    

</body>

</html>
