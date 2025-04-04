<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Tour</title>
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

        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* ให้ภาพไม่เลื่อนตาม */
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('components.sidebarGuide')
    <!-- Navbar -->
    <div id="mainContent">
        <nav id="navbar" class="fixed top-0 left-0 w-full p-4 z-[60] transition-all duration-300">
            <div class="max-w-7xl mx-auto flex flex-col space-y-3 p-4 bg-white/10 backdrop-blur-2xl rounded-lg">
                <form action="/guideSearchFilter" method="GET">
                    <!-- บรรทัดแรก: แบรนด์ + ช่องค้นหา -->
                    <div class="flex justify-between items-center w-full">
                        <div class="text-2xl text-white font-bold pl-4">TRAVEL</div>
                        <div class="flex-grow mx-4">
                            <input type="text" name="searchKey" placeholder="Search tour name..."
                                class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">SEARCH</button>
                    </div>
                    <div class="mt-2 ">
                        <!-- บรรทัดที่สอง: ตัวกรอง Filters -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-center ">
                            <!-- วันที่ไป -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="start_date" class="text-white font-bold">From:</label>
                                <input type="date" id="start_date" name="startDate"
                                    class="border px-2 py-1 rounded-lg">
                            </div>

                            <!-- วันที่กลับ -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="end_date" class="text-white font-bold">To:</label>
                                <input type="date" id="end_date" name="endDate" class="border px-2 py-1 rounded-lg">
                            </div>

                            <div class="flex items-center space-x-1">
                                <label for="people" class="text-white font-bold">Type:</label>
                                <select name="type" class="h-full w-full rounded-lg">
                                    <option value="request">REQUEST</option>
                                    <option value="tour">TOUR</option>
                                </select>
                            </div>

                            <!-- งบประมาณขั้นต่ำ -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="min_budget" class="text-white font-bold">Min:</label>
                                <input type="range" id="min_budget" name="minBudget" min="0" max="1000000"
                                    value="0" step="10000" class="w-24" oninput="updateMinValue(this.value)">
                                <span id="min_value" class="text-sm font-semibold text-white">0</span>
                            </div>

                            <!-- งบประมาณสูงสุด -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="max_budget" class="text-white font-bold">Max:</label>
                                <input type="range" id="max_budget" name="maxBudget" min="0" max="1000000"
                                    value="1000000" step="10000" class="w-24" oninput="updateMaxValue(this.value)">
                                <span id="max_value" class="text-sm font-semibold text-white">1,000,000</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </nav>

            @php
                $startArray = 0;
            @endphp

            <div class="card-wrapper mt-40">
                @foreach ($searchTourData as $item)
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden relative">
                            <!-- รูปภาพ -->
                            @if (is_null($item->tourImage))
                                <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination"
                                    class="w-1/3 rounded-lg">
                            @else
                                <img src="{{ asset('storage/' . $item->tourImage) }}" alt="image"
                                    class="w-1/3 rounded-lg">
                            @endif
                            <form action="/guideSearchTourDetail" method="POST">
                                @csrf
                                <input type="hidden" name="tourID" value={{ $item->id_tour }}>
                                <input type="hidden" name="path" value={{ $path }}>
                                <button type="submit" class="absolute inset-0 w-full h-full opacity-0 "></button>
                            </form>
                            <!-- ส่วนข้อมูล -->
                            <div class="p-6 flex-1">
                                <h2 class="text-xl font-bold">{{ ucwords($item->name) }}</h2>
                                <div class="mb-2">
                                    <p class="text-gray-600">{{ $item->description }}</p>
                                </div>
                                <div class=" mt-2 " id="card">
                                    <p class="text-gray-400 text-xs mt-1">Start Date: {{ $item->start_tour_date }}</p>
                                    <p class="text-gray-400 text-xs  mt-1">End Date: {{ $item->end_tour_date }}</p>
                                    <p class="text-gray-400 text-xs mt-1">Organized by:
                                        {{ $ownerData[$startArray]->name }}
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
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
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

                                <div class="flex text-yellow-500 text-lg mx-64">
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
                                <div class="mt-28">
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($item->price) }}฿</p>
                                    <form action="/guideSearchTourDetail" method="POST">
                                        @csrf
                                        <input type="hidden" name="tourID" value={{ $item->id_tour }}>
                                        <input type="hidden" name="path" value={{ $path }}>
                                        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm mt-2 relative z-[50]">
                                            INFO
                                        </button>
                                    </form>
                                    <p
                                        class="text-base font-semibold mt-2 {{ $status === 'Available' ? 'text-green-500' : 'text-red-500' }}">
                                        NET AMOUNT:
                                        {{ is_null($totalMember[$startArray]) ? 0 : $totalMember[$startArray] }}/{{ $item->tour_capacity }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $startArray += 1;
                    @endphp
                @endforeach
                {{ $searchTourData->links() }}
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