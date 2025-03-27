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
         body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inknut Antiqua', serif;
            height: 100vh;
            overflow: hidden;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #mainContent {
            transition: margin-left 0.3s ease-in-out;
            width: 100%;
            overflow-y: auto;
            height: 100vh;
            padding-bottom: 2rem;
        }

        .logout {
            margin-top: auto;
        }

    </style>
</head>

<body>

    <div class="flex h-screen">
        @include('components.sidebarGuide')
        <!-- Main Content -->
        <div id="mainContent" class="flex-1 p-5 flex justify-center transition-all duration-300">
            <div id="calendarContainer" class="bg-white bg-opacity-90 p-5 rounded-lg shadow-md w-4/5 h-[650px] overflow-y-auto transition-all duration-300 mt-28">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         initialView: 'dayGridMonth',
        //         timeZone: 'local',
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //         },
        //         contentHeight: 'auto',
        //         events: '/api/guideGetCalendar'
        //     });
        //     calendar.render();

        //     var sidebar = document.getElementById('sidebar');
            
        //     if (sidebar.classList.contains('-translate-x-full')) {
        //         // Sidebar ถูกซ่อน -> Calendar ต้องชิดซ้าย
        //         mainContent.style.marginLeft = "0px";
        //     } else {
        //         // Sidebar ถูกเปิด -> Calendar ต้องขยับไปขวา
        //         mainContent.style.marginLeft = "16rem"; // 16rem คือความกว้างของ Sidebar (w-64)
        //     }
        // });
        var mainContent = document.getElementById('mainContent');
        var toggleSidebarButton = document.getElementById("toggleSidebar");
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
                events: '/api/guideGetCalendar'
            });
            calendar.render();
        toggleSidebarButton.addEventListener('click', function() {
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
       
    </script>


</body>

</html>
