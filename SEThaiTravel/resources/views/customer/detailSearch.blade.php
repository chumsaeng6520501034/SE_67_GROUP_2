<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900">
    <!-- Navbar -->
    <nav
        class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 flex justify-center items-center space-x-6 z-50  bg-[#205781] w-full ">
        <a href="{{ $path }}" class="text-2xl text-white font-bold">&#x2190;</a>
        <div class="text-2xl text-white font-bold pl-2">TRAVEL</div>
        <form action="/customerFilterSearch" method="get">
            <div class="flex space-x-1 items-center">
                <input type="text" name="searchKey" placeholder="Search" class="border px-4 py-2 rounded-lg">
    
                <!-- Input วันที่ไป -->
                <div class="flex items-center space-x-1 ">
                    <label for="start_date" name="startDate" class="text-xl font-semibold text-yellow-500">From:</label>
                    <input type="date" id="start_date" class="border px-2 py-1 rounded-lg">
                </div>
    
                <!-- Input วันที่กลับ -->
                <div class="flex items-center space-x-2">
                    <label for="end_date" name="endDate"class="text-xl font-semibold text-yellow-500">To:</label>
                    <input type="date" id="end_date" class="border px-2 py-1 rounded-lg">
                </div>
    
                <!-- Input จำนวนคน -->
                <div class="flex items-center space-x-1">
                    <label for="people" class="text-xl font-semibold text-yellow-500">People:</label>
                    <input type="number" id="people" name="capacity" min="1" value="1"
                        class="border px-2 py-1 rounded-lg w-16">
                </div>
    
                <!-- Input ช่วงงบประมาณ -->
                <div class="flex space-x-2 items-center">
                    <label for="min_budget" class="text-xl font-semibold text-yellow-500">Min:</label>
                    <input type="range" name="minBudget" id="min_budget" min="0" max="1000000" value="0" step="10000"
                        class="w-32" oninput="updateMinValue(this.value)">
                    <span id="min_value" class="text-sm font-semibold text-white">0</span>
    
                    <label for="max_budget" class="text-xl font-semibold text-yellow-500">Max:</label>
                    <input type="range" name="maxBudget" id="max_budget" min="0" max="1000000" value="1000000" step="10000"
                        class="w-32" oninput="updateMaxValue(this.value)">
                    <span id="max_value" class="text-sm font-semibold text-white">1000000</span>
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg  font-bold hover:bg-blue-700 transition duration-300">SEARCH</button>
            </div>
        </form>
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
            <div class="bg-blue-900 text-white text-xl font-bold w-full text-center py-3 shadow-sm rounded-md">
                <p class="text-2xl">{{ ucwords($productData->name) }}<br>Quantity : {{ $productData->tour_capacity }}
                    Person</p>
            </div>

            <!-- รายละเอียด Children / Adults -->
            <div class="flex justify-center w-full py-12">
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Reserved</h3>
                    <p class="text-2xl">{{ is_null($totalMember)? 0: $totalMember}}/{{ $productData->tour_capacity }}</p>
                </div>
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Status</h3>
                    @if (( is_null($totalMember)? 0: $totalMember) >= $productData->tour_capacity)
                        <p class="text-2xl text-red-500">FULL</p>
                    @else
                        <p class="text-2xl text-green-500">Available</p>
                    @endif
                </div>
            </div>

            <!-- ปุ่ม -->
            <div class="flex gap-4 w-full">
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Hotel <br><span class="italic font-normal text-base">
                    @if (is_null($productData->hotel))
                        Not Have Hotel
                    @else
                        {{$productData->hotel}}({{$productData->hotel_price}}/DAY)
                    @endif
                </span>
                </div>
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Travel By<br>
                    @if (is_null($productData->travel_by))
                        -
                    @else
                        <p class="text-xl font-bold">{{ucwords($productData->travel_by)}}</p>
                    @endif
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
                    <div class="bg-blue-900 text-white px-4 py-2 text-center rounded-lg inline-block shadow-md">
                        {{ $productData->start_tour_date}}<br>To<br>{{$productData->end_tour_date}}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Post Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ $productData->Release_date }}
                    </div>
                </div>
                <div>
                    <p class="font-bold">Price</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        {{ number_format($productData->price) }}
                    </div>
                </div>
            </div>

            <!-- Owner of post และ Description -->
            <div class="bg-white p-6 rounded-lg shadow-md h-[300px]">
                <p class="font-bold">Owner of post : <span class="font-normal">
                        @if ($productData->from_owner === 'guide')
                            {{ $productData->guide_name.' '.$productData->guide_surname }}
                        @else
                            {{ $productData->corp_name}}
                        @endif
                    </span></p>
                <p class="font-bold mt-2">Description:</p>
                <p class="mt-2">{{ $productData->description}}</p>
            </div>
        </div>

        <!-- กล่องขวา: Quantity และปุ่ม -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <h2 class="font-bold text-xl p-2">Location List</h2>
        </div>
    </div>

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
            @foreach ($reviews as $review)
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
    </div>
    
    <!-- Tab Bar ด้านล่าง -->
    <div class="fixed bottom-0 right-0 w-full bg-gray-900 p-4 shadow-lg flex justify-end items-center space-x-8">
        <div class="flex items-center space-x-8">
            <button class="bg-white text-black px-3 py-2 rounded-lg shadow-md text-xl font-bold" onclick="decreaseQuantity()">-</button>
            <span id="quantity" class="text-xl font-bold text-white">1</span>
            <button class="bg-white text-black px-3 py-2 rounded-lg shadow-md text-xl font-bold" onclick="increaseQuantity()">+</button>
        </div>
        <button class="bg-green-700 text-white px-4 py-2 rounded-lg shadow-md font-bold text-xl">Buy Now</button>
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
    </script>
</body>

</html>
