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
    @include('components.sidebarCorporation')    
    <!-- Navbar -->
    <div id="mainContent">
        <div class="p-6 rounded-xl mt-4 bg-white/10 backdrop-blur-2xl mx-auto w-3/4 z-50">
                <form action="/corpSearchFilter" method="GET">
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
                                <label for="start_date" class="text-white font-semibold">From:</label>
                                <input type="date" id="start_date" name="startDate" class="border px-2 py-1 rounded-lg">
                            </div>
        
                            <!-- วันที่กลับ -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="end_date" class="text-white font-semibold">To:</label>
                                <input type="date" id="end_date" name="endDate" class="border px-2 py-1 rounded-lg">
                            </div>

                            <div class="flex items-center space-x-1">
                                <label for="people" class="text-white font-semibold">Type:</label>
                                <select name="type" class="h-full w-full rounded-lg">
                                    <option value="request">REQUEST</option>
                                    <option value="tour">TOUR</option>
                                </select>
                            </div>

                            <!-- งบประมาณขั้นต่ำ -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="min_budget" class="text-white font-semibold">Min:</label>
                                <input type="range" id="min_budget" name="minBudget" min="0" max="1000000"
                                    value="0" step="10000" class="w-24" oninput="updateMinValue(this.value)">
                                <span id="min_value" class="text-sm font-semibold text-white">0</span>
                            </div>
        
                            <!-- งบประมาณสูงสุด -->
                            <div class="flex items-center justify-center space-x-1">
                                <label for="max_budget" class="text-white font-semibold">Max:</label>
                                <input type="range" id="max_budget" name="maxBudget" min="0" max="1000000"
                                    value="1000000" step="10000" class="w-24" oninput="updateMaxValue(this.value)">
                                <span id="max_value" class="text-sm font-semibold text-white">1,000,000</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
            @php
                $startArray = 0;
            @endphp

            <div class="card-wrapper mt-40">
                @foreach ($searchRequestData as $item)
                    <div class="card-container m-4">
                        <div class="card bg-white relative rounded-lg shadow-lg flex overflow-hidden">
                            <!-- รูปภาพ -->
                            <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination"
                                class="w-1/3 object-cover">
                            <form action="/guideSearchRequestDetail" method="POST">
                                @csrf
                                <input type="hidden" name="requestID" value={{ $item->id_request_tour }}>
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
                                    <p class="text-gray-400 text-xs mt-1">Request by:
                                        {{ $ownerData[$startArray]->name }}
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-blue-500">
                                        {{ $item->request_status }}
                                    </p>
                                </div>
                            </div>

                            <!-- ส่วน Review -->
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                <p class="text-lg text-black-500">REQUEST</p>

                                <div class="mt-28">
                                    <p class="font-bold text-black-500">Budget</p>
                                    <p class="font-bold text-black-500">{{ number_format($item->start_price) }}</p>
                                    <p class="font-bold text-black-500">to</p>
                                    <p class="font-bold text-black-500">{{ number_format($item->max_price) }}</p>
                                    <form action="/corpToAddtour" method="GET">
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm mt-2 relative z-[50]">
                                            OFFER
                                        </button>
                                        <input type="hidden" name="tourID" value={{ $item->id_request_tour}}>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $startArray += 1;
                    @endphp
                @endforeach
                {{ $searchRequestData->links() }}
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
