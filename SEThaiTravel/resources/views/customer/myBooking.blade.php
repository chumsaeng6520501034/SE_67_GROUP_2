<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap">
    <style>
        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Sarabun', sans-serif;
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

        #sidebar.open~#mainContent {
            margin-left: 18rem;
        }

        .logout {
            margin-top: auto;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            width: 80%;
        }

        #sidebar.open~#mainContent .card {
            width: 90%;
        }
    </style>
</head>

<body>
    <div class="flex">
        <button id="toggleSidebar" class="fixed top-4 left-4 text-2xl text-white p-2 rounded-md z-50">
            ☰
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white shadow-lg flex flex-col transform -translate-x-full transition-transform duration-300 open">
            <div class="p-6 text-center">
                <a href="/userProfile">
                    <img class="h-16 w-16 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/64538277"
                    alt="avatar" />
                </a>
                <h2 class="text-lg font-bold mt-2">{{ session('userID')->name }}</h2>
            </div>
            <nav class="flex flex-col space-y-2">
                <a href="/home" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">SEARCH</a>
                <a href="/addTour" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">ADD TOUR</a>
                <a href="/myRequest" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY REQUEST</a>
                <a href="/history" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">HISTORY</a>
                <a href="/myBooking" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY BOOKING</a>
                <a href="/calendar" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">CALENDAR</a>
                <a href="/payments" class="block py-3 px-6 hover:bg-blue-700 transition duration-300">MY PAYMENT</a>
            </nav>
            <div class="mt-auto">
                <a href="/logOut"
                    class="flex items-center justify-between py-3 px-6 hover:bg-red-700 transition duration-300 rounded">
                    <span>LOG OUT</span>
                    <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </a>
            </div>
        </aside>

        <div id="mainContent" class="flex-1 p-10 transition-all duration-300 overflow-y-auto ml-2">
            <!-- Search and Filter -->
            <form action="/searchBooking" method="POST">
                @csrf
                <div class="flex items-center p-4 rounded-xl mb-4 space-x-4 bg-white/10 backdrop-blur-2xl mx-52 w-3/4">
                <div class="relative flex-1 text-white text-xl font-bold">
                <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search Booking tours..."
                            class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                        <span class="absolute left-3 top-8 text-gray-500">🔍</span>
                    </div>
                    <div class="relative flex-1 text-white text-xl font-bold">
                        <label>Start Date</label>
                        <input type="date" name="startDate" id="startDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                    </div>
                    <div class="relative flex-1 text-white text-xl font-bold">
                        <label>End Date</label>
                        <input type="date" name="endDate" id="endDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                    </div>
                    <div class="relative flex-1 text-white text-xl font-bold">
                        <label>Status</label>
                        <select id="filterDropdown" name="status"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                            <option value="" style="color: black;">All Status</option>
                            <option value="paid" style="color: rgb(12, 236, 12);">PAID</option>
                            <option value="In process" style="color: rgb(255, 255, 44);">IN PROCESS</option>
                            <option value="cancel" style="color: rgb(255, 41, 41);">CANCEL</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">Search</button>
                    </div>
                </div>
            </form>

            <div class="card-wrapper">
                @foreach ($bookingData as $booking)
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden">
                            <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp"
                                alt="Bangkok" class="w-1/3 object-cover">
                            <div class="p-6 flex-1">
                                {{-- ฟอร์มเพื่อส่งชื่อไปด้วย --}}
                                <form action="/detailBooking" method="POST">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $booking->name }}">
                                    <!-- <input type="hidden" name="tourID" value={{ $booking->tour_id_tour}}> -->
                                    <h2 class="text-2xl font-bold text-blue-600 hover:underline cursor-pointer">
                                        <button type="submit" class="text-blue-600">
                                            {{ ucwords($booking->name) }}
                                        </button>
                                    </h2>
                                </form>
                                
                                <p class="text-gray-600 mt-1">{{ $booking->tourDes }}</p>
                                @switch($booking->status)
                                    @case("paid")
                                        <p class="text-green-500 text-sm mt-2 font-bold">{{ ucwords($booking->status) }}</p>
                                    @break
            
                                    @case("In process")
                                        <p class="text-yellow-500 text-sm mt-2 font-bold">{{ ucwords($booking->status) }}</p>
                                    @break
                                    @case("cancel")
                                        <p class="text-red-500 text-sm mt-2 font-bold">{{ ucwords($booking->status) }}</p>
                                    @break
                                @endswitch
                            </div>
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                <p class="text-gray-800 text-md font-bold">Booking Date</p>
                                <p class="text-gray-600 font-semibold">{{ $booking->booked_date }}</p>
                                <p class="text-gray-800 text-md font-bold">Expiration Date</p>
                                <p class="text-gray-600 text-md font-semibold">
                                    {{ date('Y-m-d', strtotime($booking->payment_date)) }}</p>
                                <p class="text-gray-800 m-2 text-md font-bold">{{ $booking->total_price }} ฿</p>
                                @switch($booking->status)
                                @case("paid")
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">ALREADY PAID</button>
                                @break
        
                                @case("In process")
                                <form action="/getPaymentPage" method="get">
                                    <input type="hidden" name="tourID" value={{$booking->tour_id_tour}}>
                                    <input type="hidden" name="bookingID" value={{$booking->id_booking}}>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">PAY NOW</button>
                                </form>
                                @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('open');
        });
        document.getElementById("filterDropdown").addEventListener("change", function() {
            const colors = {
                "": "text-black",
                "paid": "text-green-500",
                "In process": "text-yellow-500",
                "cancel": "text-red-500"
            };

            // ลบสีเก่าก่อน
            this.classList.remove("text-black", "text-green-500", "text-yellow-500", "text-red-500");

            // เพิ่มสีใหม่ตามค่าที่เลือก
            this.classList.add(colors[this.value] || "text-black");
        });
    </script>
</body>

</html>
