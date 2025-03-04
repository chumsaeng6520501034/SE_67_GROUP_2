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

    <!-- Hero Section -->
    <div class="relative h-[50vh] w-full">
        <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    </div>

    <!-- Navbar -->
<!-- Navbar -->
<nav class="fixed top-0 left-1/2 transform -translate-x-1/2 w-[900px] shadow-md p-4 flex justify-center items-center space-x-6 rounded-lg z-50">
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
    <div class="absolute top-[30vh] left-1/2 transform -translate-x-1/2 w-2/3 max-w-[900px] px-6 z-10">
    @foreach ($All_req as $All_req)
        <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-lg shadow-lg p-6 mb-6 flex relative mx-auto">
            <!-- Icon บนขวา -->
            <div class="absolute top-2 right-2 cursor-pointer">
                <svg class="h-8 w-8 text-zinc-900" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                    <path stroke="none" d="M0 0h24v24H0z"/>  
                    <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  
                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  
                    <line x1="16" y1="5" x2="19" y2="8" />
                </svg>
            </div>

            <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination" class="w-1/3 rounded-lg">
            <div class="ml-4 w-2/3">
                <h2 class="text-xl font-bold">{{  ucwords($All_req->name) }}</h2>
                <p class="text-gray-600">{{ $All_req->request_date}}</p>
                @switch($All_req->request_status)
                @case("finish")
                <p class="text-gray-400 mt-40">{{ ucwords($All_req->request_status) }}</p>@break
                @case("ongoing")
                <p class="text-gray-400 mt-40">{{ ucwords($All_req->request_status) }}</p>@break
                @case("cancel")
                <p class="text-gray-400 mt-40">{{ ucwords($request_tour->request_status) }}</p>@break
                @endswitch
            </div>
            <div class="ml-auto text-right mt-auto">
                <p class="text-sm text-gray-500">BOOKING DATE</p>
                <p class="font-bold">{{ $All_req->request_date}}</p>
                <p class="text-gray-500">Price</p>
                <p class="text-xl font-bold">{{$All_req->max_price }}</p>
                <div class="mt-2 flex gap-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Start</button>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded-lg">End</button>
                </div>
            </div>
        </div>
    @endforeach



        <!-- Pagination -->
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
</body>
</html>
