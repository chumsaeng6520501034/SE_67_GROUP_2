<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-900">
    @include('components.sidebarCustomer')
    <!-- Navbar -->
    <nav class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 flex justify-center items-center bg-gray-900 space-x-6 z-50">
        <a href="/" class="text-2xl text-white font-bold">&#x2190;</a>
        <div class="text-2xl text-white font-bold pl-10">TRAVEL</div>
        <div class="flex space-x-4 items-center">
            <input type="text" placeholder="Search" class="border px-4 py-2 rounded-lg">

            <!-- Input วันที่ไป -->
            <div class="flex items-center space-x-2 ">
                <label for="start_date" class="text-xl font-semibold text-yellow-500">From:</label>
                <input type="date" id="start_date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input วันที่กลับ -->
            <div class="flex items-center space-x-2">
                <label for="end_date" class="text-xl font-semibold text-yellow-500">To:</label>
                <input type="date" id="end_date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input จำนวนคน -->
            <div class="flex items-center space-x-2">
                <label for="people" class="text-xl font-semibold text-yellow-500">People:</label>
                <input type="number" id="people" min="1" value="1" class="border px-2 py-1 rounded-lg w-16">
            </div>

            <!-- Input ช่วงงบประมาณ -->
            <div class="flex space-x-4 items-center">
                <label for="min_budget" class="text-xl font-semibold text-yellow-500">Min:</label>
                <input type="range" id="min_budget" min="0" max="1000000" value="0" step="10000" class="w-32" oninput="updateMinValue(this.value)">
                <span id="min_value" class="text-sm font-semibold text-white">0</span>

                <label for="max_budget" class="text-xl font-semibold text-yellow-500">Max:</label>
                <input type="range" id="max_budget" min="0" max="1000000" value="1000000" step="10000" class="w-32" oninput="updateMaxValue(this.value)">
                <span id="max_value" class="text-sm font-semibold text-white">1000000</span>
            </div>
        </div>
    </nav>

    <!-- Layout -->
    <div class="p-6 pt-20 grid grid-cols-1 md:grid-cols-3 gap-6 w-full container mx-auto ">
        <!-- รูปภาพใหญ่ -->
        <div class="md:col-span-2 h-full">
            <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" 
                class="w-full h-[400px] object-cover rounded-lg shadow-md">
        </div>

        <!-- ข้อมูลด้านขวา -->
        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center w-full max-w-md mx-auto h-[400px]">
            <!-- หัวข้อ Quantity -->
            @foreach ($history as $tour) 
                <div class="bg-blue-900 text-white text-xl font-bold w-full text-center py-3 shadow-sm rounded-md">
                    <p class="text-2xl">Quantity: {{ $tour->tour_capacity }}</p> 
                </div>
            @endforeach


            <!-- รายละเอียด Children / Adults -->
            @foreach ($history as $tour) 
            <div class="flex justify-center w-full py-16">
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Adults</h3>
                    <p class="text-2xl">{{ $tour->adult}}</p>
                </div>
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Kid</h3>
                    <p class="text-2xl">{{ $tour->kid}}</p>
                </div>
            </div>
            @endforeach

            <!-- ปุ่ม -->
            <div class="flex gap-4 w-full">
                <div class="bg-blue-900 text-white px-6 py-3 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Hotel <br><span class="italic font-normal">{{ $tour->hotel}}</span> <br>{{ $tour->hotelPrice}}
                </div>
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Travel By<br>
                    <p class="text-xl font-bold">{{ $tour->travelBy}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- กล่องข้อมูลด้านล่าง -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 w-full container mx-auto">
        <!-- กล่องซ้าย: ข้อมูลหลัก -->
        <div class="flex flex-col gap-4">
            <!-- Grid ของ Start-End Date, Post Date, Price -->
            <div class="grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow-md">
                <div>
                    <p class="font-bold">Start - End Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ $tour->startDate}}- {{ $tour->endDate}}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Post Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ $tour->postDate}}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Price</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ $tour->price}}
                    </div>
                </div>
            </div>

            <!-- Owner of post และ Description -->
            <div class="bg-white p-6 rounded-lg shadow-md h-[300px]">
                {{-- <p class="font-bold">Owner of post : <span class="font-normal">{{$tour->type}} Id {{ $tour->owner}}</span></p> --}}
                <p class="font-bold">Owner of post : <span class="font-normal">Id {{ $tour->owner}}  @if($history->first()->owner_surname)
                    {{ $history->first()->owner_name }} {{ $history->first()->owner_surname }}  {{-- ถ้าเป็นไกด์ --}}
                @else
                    {{ $history->first()->owner_name }}  {{-- ถ้าเป็นบริษัท --}}
                @endif</span></p>
                <p class="font-bold mt-2">Description</p>{{ $tour->desTour}}
            </div>
        </div>

        <!-- กล่องขวา: Quantity และปุ่ม -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <h2 class="font-bold text-xl p-2">Location List</h2>รอแก้
            
        </div>
    </div>


{{-- 
    <!-- รีวิวลูกค้า -->
    <div class="bg-white py-6 px-6 rounded-lg shadow-md mt-4 w-[1485px] mx-auto mb-10">
        <h4 class="text-2xl font-bold mb-3">Reviews</h4>

        @php
            $reviews = [
                ['name' => 'คุณสมชาย', 'text' => 'ทัวร์ดีมาก ไกด์เป็นกันเองสุด ๆ!', 'rating' => 5],
                ['name' => 'คุณมาลี', 'text' => 'บริการดี ประทับใจ วิวสวยมาก!', 'rating' => 5],
                ['name' => 'คุณวิทยา', 'text' => 'ไกด์ให้ข้อมูลดี อาหารอร่อย!', 'rating' => 4],
                ['name' => 'คุณวิทยา', 'text' => 'ไกด์ให้ข้อมูลดี อาหารอร่อย!', 'rating' => 3],
                ['name' => 'คุณสมชาย', 'text' => 'ทัวร์ดีมาก ไกด์เป็นกันเองสุด ๆ!', 'rating' => 5],
                ['name' => 'คุณสมชาย', 'text' => 'ทัวร์ดีมาก ไกด์เป็นกันเองสุด ๆ!', 'rating' => 5],
                ['name' => 'คุณมาลี', 'text' => 'บริการดี ประทับใจ วิวสวยมาก!', 'rating' => 5],
                ['name' => 'คุณวิทยา', 'text' => 'ไกด์ให้ข้อมูลดี อาหารอร่อย!', 'rating' => 4],
                ['name' => 'คุณวิทยา', 'text' => 'ไกด์ให้ข้อมูลดี อาหารอร่อย!', 'rating' => 3],
                ['name' => 'คุณสมชาย', 'text' => 'ทัวร์ดีมาก ไกด์เป็นกันเองสุด ๆ!', 'rating' => 5],
            ];
        @endphp

        <!-- กล่องรีวิวแบบเลื่อน -->
        <div class="max-h-[300px] overflow-y-auto space-y-2 p-2 bg-gray-50 rounded-lg shadow-inner">
            @foreach($reviews as $review)
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                    <strong>{{ $review['name'] }}:</strong>
                    <p>{{ $review['text'] }} 
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $review['rating'])
                                <span class=text-lg>⭐</span>
                            @else
                                <span class=text-lg>☆</span>
                            @endif
                        @endfor
                    </p>
                </div>
            @endforeach
        </div>
    </div> --}}

    
</body>
</html>