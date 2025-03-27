<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* ให้ภาพไม่เลื่อนตาม */
        }
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

        #navbar {
            transition: all 0.3s ease-in-out;
            width: calc(100% - 0rem);
            /* ค่าเริ่มต้นเต็มจอ */
            margin-left: 0;
        }

        /* เมื่อ Sidebar เปิด ให้ Navbar ลดขนาด */
        .sidebar-open #navbar {
            width: calc(100% - 16rem);
            /* ลดขนาดเมื่อ Sidebar เปิด */
            margin-left: 16rem;
            /* ขยับ Navbar ตาม Sidebar */
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
        .modal {
            position: fixed;
            inset: 0; /* ทำให้ modal ครอบคลุมทั้งหน้าจอ */
            background-color: rgba(0, 0, 0, 0.5); /* ทำให้พื้นหลังมืดลง */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100; /* ให้ modal อยู่หน้าสุด */
        }
    </style>
</head>
<body class="bg-gray-900">
    <!-- Sidebar -->
    @include('components.sidebarCustomer')
        <div id="mainContent" class="flex-1 p-10 transition-all duration-300 overflow-y-auto ml-2">
            <!-- Search and Filter -->
            <form action="/searchBooking" method="POST">
                @csrf
                <div class="flex items-center p-4 rounded-xl mb-4 space-x-4 bg-white/10 backdrop-blur-2xl mx-52 w-3/4">
                    <div class="relative flex-1 text-white text-xl font-bold">
                        <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search"
                            class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                            <option value="finish" style="color: rgb(12, 236, 12);">FINISH</option>
                            <option value="onGoing" style="color: rgb(255, 255, 44);">ON GOING</option>
                            <option value="cancel" style="color: rgb(255, 41, 41);">CANCEL</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-900 text-white px-4 py-2 rounded-lg font-bold transition duration-300">Search</button>
                    </div>
                </div>
            </form>
        



            @php
                $currentPage = request()->query('page', 1); // หน้าปัจจุบัน
                $perPage = 10; // จำนวนรายการต่อหน้า
                $items = collect(range(1, 100)); // ข้อมูลทั้งหมด (ตัวอย่าง: 100 รายการ)
                $paginatedItems = $items->forPage($currentPage, $perPage); // ดึงข้อมูลตามหน้า
                $totalPages = ceil($items->count() / $perPage); // จำนวนหน้าทั้งหมด
            @endphp

            <!-- Travel Deals -->
            <div class="card-wrapper">
                @foreach ($All_req as $All_req)  
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden relative">
                        <!-- ปุ่มลบ มุมขวาบน -->
                        <button onclick="openModal('{{ $All_req->id_request_tour }}')" 
                            class="absolute top-2 right-2 cursor-pointer bg-red-500 hover:bg-red-700 text-white rounded-full p-2"
                            @if($All_req->request_status == 'cancal' || $All_req->request_status == 'finish') style="display: none;" @endif>
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 6l4 4m0-4l-4 4"></path>
                            </svg>
                        </button>

                        <!-- Modal ยืนยันการลบ -->
                        <div id="deleteModal_{{ $All_req->id_request_tour }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">

                            <div class="bg-white rounded-lg p-6 shadow-lg w-96">
                                <h2 class="text-xl font-bold text-gray-800">ยืนยันการลบ</h2>
                                <p class="text-gray-600 mt-2">คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?</p>
                                <form action="/deleteRequestTour" method="POST">
                                    @csrf
                                    <input type="hidden" name="tourID" value="{{ $All_req->id_request_tour }}">
                                    <div class="flex justify-end space-x-3 mt-4">
                                        <button type="button" onclick="closeModal('{{ $All_req->id_request_tour }}')" class="px-4 py-2 bg-gray-300 rounded-lg">ยกเลิก</button>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">ลบ</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Icon บนขวา ที่สามารถกดได้ -->
                        <form action="/editAddtour" method="POST">
                            @csrf
                            <input type="hidden" name="tourID" value="{{ $All_req->id_request_tour }}">

                            <!-- ปุ่มกดส่งฟอร์ม -->
                            <button type="submit" class="absolute top-3 right-14 cursor-pointer"
                                @if($All_req->request_status == 'cancal' || $All_req->request_status == 'finish') style="display: none;" @endif>
                                <svg class="h-8 w-8 text-black hover:text-blue-900" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>  
                                    <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                </svg>
                            </button>
                        </form>
                            <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp" alt="Bangkok" class="w-1/3 object-cover">
                            <div class="p-6 flex-1">
                                <form action="/requestDetail" method="Post">
                                    @csrf
                                    <input type="hidden" name="requestID" value="{{ $All_req->id_request_tour }}">
                                    <button type="submit" class="text-xl font-bold text-blue-500 hover:underline">
                                        {{ ucwords($All_req->name) }}
                                    </button>
                                </form>
                                <p class="text-gray-600">{{ $All_req->request_date}}</p>
                                @switch($All_req->request_status)
                                @case("finish")
                                <p class="text-green-700 mt-2">{{ ucwords($All_req->request_status) }}</p>@break
                                @case("ongoing")
                                <p class="text-yellow-700 mt-2">{{ ucwords($All_req->request_status) }}</p>@break
                                @case("cancal")
                                <p class="text-red-700 mt-2">Cancel</p>@break
                                @endswitch
                            </div>
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                <p class="text-sm text-gray-500 mt-8">BOOKING DATE</p>
                                <p class="font-bold mt-2">{{ $All_req->request_date}}</p>
                                <p class="text-gray-500 mt-2">Price</p>
                                <p class="text-xl font-bold mt-2">{{$All_req->max_price }}</p>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
                <!-- Pagination -->
                <div class="mt-6 flex justify-center space-x-2 text-white">
                    @if ($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}" class="px-4 py-2 bg-yellow-700 rounded-lg">Previous</a>
                    @endif
                    @if ($currentPage < $totalPages)
                        <a href="?page={{ $currentPage + 1 }}" class="px-4 py-2 bg-green-900 rounded-lg">Next</a>
                    @endif
                </div>
        </div>       
                <!-- Pagination
                <div class="mt-6 flex justify-center space-x-2 text-white">
                    @if ($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}" class="px-4 py-2 bg-yellow-700 rounded-lg">Previous</a>
                    @endif

                    @php
                        $maxPagesToShow = 7;
                    @endphp

                    @if ($totalPages <= 10)
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <a href="?page={{ $i }}" class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                {{ $i }}
                            </a>
                        @endfor
                    @else
                        @if ($currentPage <= 4)
                            @for ($i = 1; $i <= $maxPagesToShow; $i++)
                                <a href="?page={{ $i }}" class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor
                            <span class="px-4 py-2">...</span>
                            <a href="?page={{ $totalPages }}" class="px-4 py-2 bg-gray-200 rounded-lg">{{ $totalPages }}</a>
                        @elseif ($currentPage >= $totalPages - 3)
                            <a href="?page=1" class="px-4 py-2 bg-gray-200 rounded-lg">1</a>
                            <span class="px-4 py-2">...</span>
                            @for ($i = $totalPages - ($maxPagesToShow - 1); $i <= $totalPages; $i++)
                                <a href="?page={{ $i }}" class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor
                        @else
                            <a href="?page=1" class="px-4 py-2 bg-gray-200 rounded-lg">1</a>
                            <span class="px-4 py-2">...</span>
                            @for ($i = $currentPage - 2; $i <= $currentPage + 2; $i++)
                                <a href="?page={{ $i }}" class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor
                            <span class="px-4 py-2">...</span>
                            <a href="?page={{ $totalPages }}" class="px-4 py-2 bg-gray-200 rounded-lg">{{ $totalPages }}</a>
                        @endif
                    @endif

                    @if ($currentPage < $totalPages)
                        <a href="?page={{ $currentPage + 1 }}" class="px-4 py-2 bg-green-900 rounded-lg">Next</a>
                    @endif
                </div>
            </div>
        </div> -->
    <!-- JavaScript เปิด/ปิด Modal -->
    <script>
        function openModal(tourID) {
            document.getElementById("deleteModal_" + tourID).classList.remove("hidden");
        }

        function closeModal(tourID) {
            document.getElementById("deleteModal_" + tourID).classList.add("hidden");
        }


        document.getElementById("filterDropdown").addEventListener("change", function() {
            const colors = {
                "": "text-black",
                "finish": "text-green-500",
                "onGoing": "text-yellow-500",
                "cancel": "text-red-500"
            };

            // ลบสีเก่าก่อน
            this.classList.remove("text-black", "text-green-500", "text-yellow-500", "text-red-500");

            // เพิ่มสีใหม่ตามค่าที่เลือก
            this.classList.add(colors[this.value] || "text-black");
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    </script>
    
    
</body>
</html>