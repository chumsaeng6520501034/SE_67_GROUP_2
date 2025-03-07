<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .sidebar-open #card {
            margin-top: 90px;
        }

        body {
            background-image: url('https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* ให้ภาพไม่เลื่อนตาม */
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('components.sidebarCustomer')
    <!-- Navbar -->
    <div id="mainContent">
        <nav id="navbar" class="fixed top-0 left-0  w-full p-4 z-50 transition-all duration-300 ">
            <div class="max-w-7xl mx-auto flex flex-col space-y-3 p-4 bg-[#205781] rounded-lg">
                <form action="/customerFilterSearch" method="GET">
                    <!-- บรรทัดแรก: แบรนด์ + ช่องค้นหา -->
                    <div class="flex justify-between items-center w-full">
                        <div class="text-2xl text-white font-bold pl-4">TRAVEL</div>
                        <div class="flex-grow mx-4">
                            <input type="text" name="searchKey" placeholder="Search tour name..."
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">SEARCH</button>
                    </div>

                    <!-- บรรทัดที่สอง: ตัวกรอง Filters -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-center mt-2">
                        <!-- วันที่ไป -->
                        <div class="flex items-center space-x-1">
                            <label for="start_date" class="text-yellow-500 font-semibold">From:</label>
                            <input type="date" id="start_date" name="startDate" class="border px-2 py-1 rounded-lg">
                        </div>

                        <!-- วันที่กลับ -->
                        <div class="flex items-center space-x-1">
                            <label for="end_date" class="text-yellow-500 font-semibold">To:</label>
                            <input type="date" id="end_date" name="endDate" class="border px-2 py-1 rounded-lg">
                        </div>

                        <!-- จำนวนคน -->
                        <div class="flex items-center space-x-1">
                            <label for="people" class="text-yellow-500 font-semibold">People:</label>
                            <input type="number" id="people" min="1" value="1" name="capacity"
                                class="border px-2 py-1 rounded-lg w-16">
                        </div>

                        <!-- งบประมาณขั้นต่ำ -->
                        <div class="flex items-center space-x-1">
                            <label for="min_budget" class="text-yellow-500 font-semibold">Min:</label>
                            <input type="range" id="min_budget" name="minBudget" min="0" max="1000000"
                                value="0" step="10000" class="w-24" oninput="updateMinValue(this.value)">
                            <span id="min_value" class="text-sm font-semibold text-white">0</span>
                        </div>

                        <!-- งบประมาณสูงสุด -->
                        <div class="flex items-center space-x-1">
                            <label for="max_budget" class="text-yellow-500 font-semibold">Max:</label>
                            <input type="range" id="max_budget" name="maxBudget" min="0" max="1000000"
                                value="1000000" step="10000" class="w-24" oninput="updateMaxValue(this.value)">
                            <span id="max_value" class="text-sm font-semibold text-white">1,000,000</span>
                        </div>
                    </div>
                </form>
            </div>
        </nav>


        <!-- Hero Section -->
        <div class="relative h-[50vh] w-full">
           
                <div class="w-full h-full object-cover"></div>
            <!-- <h1 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1> -->

            <!-- Travel Deals -->
            {{-- @php
                $currentPage = request()->query('page', 1); // หน้าปัจจุบัน
                $perPage = 10; // จำนวนรายการต่อหน้า
                $items = collect(range(1, 200)); // ข้อมูลทั้งหมด (ตัวอย่าง: 200 รายการ)
                $paginatedItems = $items->forPage($currentPage, $perPage); // ดึงข้อมูลตามหน้า
                $totalPages = ceil($items->count() / $perPage); // จำนวนหน้าทั้งหมด
            @endphp --}}
            @php
                $startArray = 0;
            @endphp

            <div class="relative top-[-90%] p-10 rounded-lg w-2/3 mt-20 mx-auto">
                @foreach ($searchTourData as $item)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 flex">
                        <!-- รูปภาพ -->
                        <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination"
                            class="w-1/3 rounded-lg">

                        <!-- ส่วนข้อมูล -->
                        <div class="ml-4 w-2/3">
                            <h2 class="text-xl font-bold">{{ ucwords($item->name) }}</h2>
                            <div class="mb-2">
                                <p class="text-gray-600">{{ $item->description }}</p>
                            </div>
                            <div class=" mt-20 " id="card">
                                <p class="text-gray-400 text-xs mt-1">Start Date: {{ $item->start_tour_date }}</p>
                                <p class="text-gray-400 text-xs  mt-1">End Date: {{ $item->end_tour_date }}</p>
                                <p class="text-gray-400 text-xs mt-1">Organized by: {{ $ownerData[$startArray]->name }}
                                </p>
                                {{-- <p class="text-gray-400 mt-2">STATUS</p> --}}
                                @php
                                    $status =
                                        (is_null($totalMember[$startArray]) ? 0 : $totalMember[$startArray]) <
                                        $item->tour_capacity
                                            ? 'Available'
                                            : 'Full';
                                @endphp
                                <p
                                    class="mt-1 text-sm font-bold {{ $status === 'Available' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $status }}
                                </p>
                            </div>
                        </div>

                        <!-- ส่วน Review -->
                        <div
                            class="ml-auto w-2/5 text-right flex flex-col items-end justify-start gap-2 border-l border-gray-300 pl-6">
                            <p class="text-xs text-gray-500">OWNER REVIEW</p>
                            <p class="text-lg font-bold">{{ $ownerScore[$startArray]->total_reviews }} reviews</p>

                            @php
                                $rating = is_null($ownerScore[$startArray]->average_score)
                                    ? 0
                                    : $ownerScore[$startArray]->average_score;
                                $fullStars = floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp

                            <div class="flex text-yellow-500 text-lg">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <span>★</span>
                                @endfor
                                @if ($halfStar)
                                    <span class="text-yellow-300">★</span>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <span class="text-gray-300">★</span>
                                @endfor
                            </div>
                            <div class="mt-auto">
                                <p class="text-2xl font-bold text-green-600">{{ number_format($item->price) }}฿</p>
                                @if ($status === 'Available')
                                    <button
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm mt-2">
                                        RESERVE NOW
                                    </button>
                                @else
                                    <button
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm mt-2">
                                        FULL
                                    </button>
                                @endif
                                <p
                                    class="text-base font-semibold mt-2 {{ $status === 'Available' ? 'text-green-500' : 'text-red-500' }}">
                                    NET AMOUNT:
                                    {{ is_null($totalMember[$startArray]) ? 0 : $totalMember[$startArray++] }}/{{ $item->tour_capacity }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $searchTourData->links() }}
                {{-- <!-- ปุ่ม Pagination -->
                <div class="mt-6 flex justify-center space-x-2 text-white">
                    @if ($currentPage > 1)
                        <a href="?page={{ $currentPage - 1 }}" class="px-4 py-2 bg-yellow-700 rounded-lg">Previous</a>
                    @endif

                    @php
                        $maxPagesToShow = 7; // จำนวนหน้าที่จะแสดงก่อนใช้ "..."
                    @endphp

                    @if ($totalPages <= 10)
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <a href="?page={{ $i }}"
                                class="px-4 py-2 {{ $i == $currentPage ? 'bg-green-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                {{ $i }}
                            </a>
                        @endfor
                    @else
                        <!-- ถ้าหน้าปัจจุบันอยู่ในช่วงต้น -->
                        @if ($currentPage <= 4)
                            @for ($i = 1; $i <= $maxPagesToShow; $i++)
                                <a href="?page={{ $i }}"
                                    class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor
                            <span class="px-4 py-2">...</span>
                            <a href="?page={{ $totalPages }}"
                                class="px-4 py-2 bg-gray-200 rounded-lg">{{ $totalPages }}</a>

                            <!-- ถ้าหน้าปัจจุบันอยู่ในช่วงท้าย -->
                        @elseif ($currentPage >= $totalPages - 3)
                            <a href="?page=1" class="px-4 py-2 bg-gray-200 rounded-lg">1</a>
                            <span class="px-4 py-2">...</span>
                            @for ($i = $totalPages - ($maxPagesToShow - 1); $i <= $totalPages; $i++)
                                <a href="?page={{ $i }}"
                                    class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor

                            <!-- ถ้าหน้าปัจจุบันอยู่ตรงกลาง -->
                        @else
                            <a href="?page=1" class="px-4 py-2 bg-gray-200 rounded-lg">1</a>
                            <span class="px-4 py-2">...</span>
                            @for ($i = $currentPage - 2; $i <= $currentPage + 2; $i++)
                                <a href="?page={{ $i }}"
                                    class="px-4 py-2 {{ $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded-lg">
                                    {{ $i }}
                                </a>
                            @endfor
                            <span class="px-4 py-2">...</span>
                            <a href="?page={{ $totalPages }}"
                                class="px-4 py-2 bg-gray-200 rounded-lg">{{ $totalPages }}</a>
                        @endif
                    @endif

                    @if ($currentPage < $totalPages)
                        <a href="?page={{ $currentPage + 1 }}" class="px-4 py-2 bg-green-900 rounded-lg">Next</a>
                    @endif --}}
            </div>
        </div>
    </div>


    <script>
        const minBudgetInput = document.getElementById("min_budget");
        const maxBudgetInput = document.getElementById("max_budget");
        const minValueSpan = document.getElementById("min_value");
        const maxValueSpan = document.getElementById("max_value");

        function updateMinValue(value) {
            document.getElementById("min_value").innerText = parseInt(value).toLocaleString();
            maxBudgetInput.min = value; // อัปเดต min ของ max_budget
            if (parseInt(maxBudgetInput.value) < parseInt(value)) {
                maxBudgetInput.value = value;
                document.getElementById("max_value").innerText = parseInt(value).toLocaleString();
            }
        }

        function updateMaxValue(value) {
            document.getElementById("max_value").innerText = parseInt(value).toLocaleString();
        }
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    </script>
</body>

</html>
