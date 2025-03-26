<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react/outline"></script>
    <style>
          #sidebar,
        #mainContent {
            transition: all 0.3s ease-in-out;
        }

        #sidebar {
            z-index: 50;
            /* ให้ Sidebar อยู่ด้านหน้า */
        }

        #toggleSidebar {
            position: fixed;
            z-index: 100;
            /* ให้ปุ่มอยู่ด้านหน้าสุด */
        }

        #sidebar {
            transform: translateX(-100%);
        }

        .sidebar-open #sidebar {
            transform: translateX(0);
        }

        .sidebar-open #mainContent {
            margin-left: 16rem;
            /* ขยับไปทางขวาเท่ากับความกว้างของ Sidebar */
        }
        @keyframes slideInFromLeft {
            0% {
                opacity: 0;
                transform: translateX(-100vw); /* เริ่มจากซ้ายสุด และเล็กลงนิดหน่อย */
            }
            100% {
                opacity: 1;
                transform: translateX(-20vw); /* หยุดกลางจอ และขยายขึ้น */
            }
        }

        .animate-travel {
            animation: slideInFromLeft 1.5s ease-out;
            font-size: 6rem; /* ปรับขนาดตัวอักษรใหญ่ขึ้น */
        }

    </style>
</head>
<body class="bg-gray-900">  
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebarCustomer')

        <!-- Sidebar
        <aside class="w-64 bg-blue-900 text-white p-6 space-y-4 flex flex-col h-full">
        <div class="flex items-center space-x-2">
            <a href="#" class="flex items-center space-x-2">
                <label for="profile-upload" class="relative cursor-pointer">
                    <img id="profileImage" src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg" alt="Profile Picture" class="w-20 h-20 rounded-full border-2 border-white object-cover">
                    <input type="file" id="profile-upload" class="hidden" accept="image/*" onchange="previewProfileImage(event)">
                </label>
                <span class="font-bold cursor-pointer">User Name</span>
            </a>
        </div>
            <nav class="space-y-2">
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">ADD TOUR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY TOUR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">HISTORY</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY REVIEW</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">CALENDAR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY BOOKING</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY PAYMENT</a>
            </nav>
            <a href="#" class="block py-2 px-4 hover:bg-red-700 rounded">LOG OUT</a>
        </aside>
         -->
        <!-- Main Content -->
        <main id="mainContent" class="flex-1 relative">
            <div class="relative h-[50vh] w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <h1 class="absolute top-[30%] left-1/2 transform -translate-x-1/2 text-white font-bold animate-travel">
                    TRAVEL & TOUR
                </h1>

            <!-- Search Box -->
            <form action="/customerSearch" method="GET">
            <div class="bg-white/10 backdrop-blur-2xl p-8 rounded-xl shadow-2xl -mt-32 relative z-10 w-[1200px] mx-auto ">
                <div class="flex items-center border border-gray-300 rounded-lg p-4 bg-white">
                <svg class="h-8 w-8 text-gray-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                      <circle cx="11" cy="11" r="8" />  <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                    <input type="text" name="searchKey" placeholder=" Where do you want to go ?" class="w-full outline-none mx-2">
                </div>
                    <div class="flex justify-between mt-4">
                    <div class="w-1/3">
                        <label class="text-lg text-white font-semibold">Start Date</label>
                        <div class="flex items-center border border-gray-300 rounded-lg p-4 bg-white">
                            <span class="text-gray-500 pr-2">📅</span>
                            <input type="date" id="startDate" name="startDate" class="outline-none w-full">
                        </div>
                    </div>
                        <div class="w-1/3">
                            <label class="text-lg text-white font-semibold">End Date</label>
                            <div class="flex items-center border border-gray-300 rounded-lg p-4 bg-white">
                                <span class="text-gray-500 pr-2">📅</span>
                                <input type="date" name="endDate" class="outline-none w-full">
                            </div>
                        </div>
                        <div class="w-1/4">
                            <label class="text-lg text-white font-semibold">Person</label>
                            <div class="flex items-center border border-gray-300 rounded-lg p-4 bg-white">
                                <span class="text-gray-500 pr-2">👤</span>
                                <input type="number" name="capacity" class="outline-none w-full" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-6 bg-yellow-500 text-lg text-white font-bold py-3 rounded-lg px-6 py-2 rounded-lg w-full mx-auto block"> Find Your Adventure</button>
                </div>
            </form>
            
                        <!-- JavaScript ทำให้กดเลือกดาวได้จริง  -->
                        <!-- <div class="flex justify-center my-2">
                            <span class="star text-3xl cursor-pointer" data-value="1">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="2">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="3">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="4">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="5">⭐</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput">

                        <script>
                            document.querySelectorAll('.star').forEach(star => {
                                star.addEventListener('click', function () {
                                    let value = this.getAttribute('data-value');
                                    document.getElementById('ratingInput').value = value;

                                    document.querySelectorAll('.star').forEach(s => {
                                        s.textContent = s.getAttribute('data-value') <= value ? '⭐' : '☆';
                                    });
                                });
                            });
                        </script> -->
                        
        </main>
    </div>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
        // ตั้งค่าวันที่ปัจจุบันให้กับ input date
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0]; 
            document.getElementById("startDate").value = today;
        });
    </script>
</body>
</html>