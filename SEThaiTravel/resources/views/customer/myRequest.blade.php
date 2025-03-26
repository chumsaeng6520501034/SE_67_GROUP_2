<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <!-- Sidebar -->
    @include('components.sidebarCustomer')
    <div id="mainContent">
        <!-- Navbar -->
        <nav class="fixed top-0 left-1/2 transform -translate-x-1/2 w-[900px] p-4 flex justify-center items-center space-x-6 rounded-lg z-50">
            <!-- ช่องค้นหา -->
            <div class="relative w-64">
                <input type="text" placeholder="Search" class="w-full border px-4 py-2 pl-10 rounded-lg focus:outline-none">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>

            <!-- Input วันที่ไป -->
            <div class="relative w-64">
                <input type="date" class="w-full border px-4 py-2 pl-10 rounded-lg focus:outline-none">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>

            <!-- Input วันที่กลับ -->
            <div class="relative w-64">
                <input type="date" class="w-full border px-4 py-2 pl-10 rounded-lg focus:outline-none">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
        </nav>

        @php
            $currentPage = request()->query('page', 1); // หน้าปัจจุบัน
            $perPage = 10; // จำนวนรายการต่อหน้า
            $items = collect(range(1, 100)); // ข้อมูลทั้งหมด (ตัวอย่าง: 100 รายการ)
            $paginatedItems = $items->forPage($currentPage, $perPage); // ดึงข้อมูลตามหน้า
            $totalPages = ceil($items->count() / $perPage); // จำนวนหน้าทั้งหมด
        @endphp

        <!-- Travel Deals -->
        <div class="absolute top-[20vh] left-1/2 transform -translate-x-1/2 w-4/5 px-6 z-10">
        @foreach ($All_req as $All_req)
            <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-lg shadow-lg p-6 mb-6 flex relative mx-auto">
                <!-- ปุ่มลบ -->
                <!-- ปุ่มลบ -->
                <!-- ปุ่มลบ -->
                <button onclick="openModal('{{ $All_req->id_request_tour }}')" class="absolute top-2 right-10 cursor-pointer" 
                    @if($All_req->request_status == 'cancal' || $All_req->request_status == 'finish') style="display: none;" @endif>
                    <svg class="h-8 w-8 text-black hover:text-red-800 mx-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 6l4 4m0-4l-4 4"></path>
                    </svg>
                </button>

                <!-- Modal ยืนยันการลบ -->
                <div id="deleteModal_{{ $All_req->id_request_tour }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
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
                    <button type="submit" class="absolute top-2 right-2 cursor-pointer"
                        @if($All_req->request_status == 'cancal' || $All_req->request_status == 'finish') style="display: none;" @endif>
                        <svg class="h-8 w-8 text-black hover:text-blue-900" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>  
                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  
                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                        </svg>
                    </button>
                </form>



                <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination" class="w-1/3 rounded-lg">
                <div class="ml-4 w-2/3">
                    <form action="/requestDetail" method="Post">
                        @csrf <!-- ถ้าคุณใช้ Laravel, อย่าลืมเพิ่ม @csrf สำหรับความปลอดภัย -->
                        <input type="hidden" name="requestID" value="{{ $All_req->id_request_tour }}">
                        <button type="submit" class="text-xl font-bold bg-transparent border-0 p-0 m-0 text-black hover:text-blue-500">
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
                <div class="ml-auto text-right mt-auto">
                    <p class="text-sm text-gray-500">BOOKING DATE</p>
                    <p class="font-bold">{{ $All_req->request_date}}</p>
                    <p class="text-gray-500">Price</p>
                    <p class="text-xl font-bold">{{$All_req->max_price }}</p>
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
    </div>

    <!-- JavaScript เปิด/ปิด Modal -->
    <script>
        function openModal(tourID) {
            document.getElementById("deleteModal_" + tourID).classList.remove("hidden");
        }

        function closeModal(tourID) {
            document.getElementById("deleteModal_" + tourID).classList.add("hidden");
        }
    </script>
</body>
</html>
