<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('components.sidebarCustomer')
    <!-- Navbar -->
    <nav class="bg-blue-900 shadow-md p-4 flex justify-between items-center ">
        <div class="text-2xl text-white font-bold pl-10">TRAVEL</div>
        <div class="flex space-x-4 items-center">
            <input type="text" placeholder="Search" class="border px-4 py-2 rounded-lg">

            <!-- Input วันที่ไป -->
            <div class="flex items-center space-x-2 ">
                <label for="startDate" class="text-sm font-semibold text-white">From:</label>
                <input type="date" id="start_date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input วันที่กลับ -->
            <div class="flex items-center space-x-2">
                <label for="endDate" class="text-sm font-semibold text-white">To:</label>
                <input type="date" id="end_date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input จำนวนคน -->
            <div class="flex items-center space-x-2">
                <label for="people" class="text-sm font-semibold text-white">People:</label>
                <input type="number" id="people" min="1" value="1" class="border px-2 py-1 rounded-lg w-16">
            </div>

            <!-- Input ช่วงงบประมาณ -->
            <div class="flex space-x-4 items-center">
                <label for="min_budget" class="text-sm font-semibold text-white">Min:</label>
                <input type="range" id="min_budget" min="0" max="1000000" value="0" step="10000" class="w-32" oninput="updateMinValue(this.value)">
                <span id="min_value" class="text-sm font-semibold text-white">0</span>

                <label for="max_budget" class="text-sm font-semibold text-white">Max:</label>
                <input type="range" id="max_budget" min="0" max="1000000" value="1000000" step="10000" class="w-32" oninput="updateMaxValue(this.value)">
                <span id="max_value" class="text-sm font-semibold text-white">1000000</span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative h-[50vh] w-full">
        <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <!-- <h1 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1> -->
    
    <!-- Travel Deals -->
    <div class="absolute top-[110%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-10 rounded-lg w-2/3 mt-20">
        @foreach (range(2, 3) as $item)
            <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex">
                <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" alt="Destination" class="w-1/3 rounded-lg">
                <div class="ml-4 w-2/3">
                    <h2 class="text-xl font-bold">Bangkok</h2>
                    <p class="text-gray-600">DESCRIPYION</p>
                    <div>
                        <p class="text-gray-400 mt-40">STATUS</p>
                        @php
                            $status = rand(0, 1) ? 'Available' : 'Full'; // สุ่มค่าสถานะ (ตัวอย่าง)
                        @endphp
                        <p class="mt-4 text-xl font-bold 
                            {{ $status === 'Available' ? 'text-green-500' : 'text-red-500' }}">
                            {{ $status }}
                        </p>
                    </div>
                    
                </div>
                <div class="ml-auto text-right mt-auto">
                    <p class="text-sm text-gray-500">REVIEW</p>
                    <p class="font-bold">1,989 reviews</p>
                    @php
                        $rating = 4.5; // ค่าคะแนนรีวิวเฉลี่ย (ตัวอย่าง)
                        $fullStars = floor($rating); // ดาวเต็ม
                        $halfStar = ($rating - $fullStars) >= 0.5 ? true : false; // ดาวครึ่ง
                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // ดาวที่เหลือ
                    @endphp

                    <div class="flex justify-end text-yellow-500">
                        @for ($i = 0; $i < $fullStars; $i++)
                            <span>★</span> {{-- ดาวเต็ม --}}
                        @endfor
                        @if ($halfStar)
                            <span class="text-yellow-300">★</span> {{-- ดาวครึ่ง --}}
                        @endif
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <span class="text-gray-300">★</span> {{-- ดาวว่าง --}}
                        @endfor
                    </div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-2">Discount 50%</button>
                    <p class="line-through text-gray-500">1,000,000</p>
                    <p class="text-xl font-bold">500,000</p>
                </div>
            </div>
        @endforeach
    </div>
    <script>
    function updateMinValue(value) {
        document.getElementById("min_value").innerText = parseInt(value).toLocaleString();
    }

    function updateMaxValue(value) {
        document.getElementById("max_value").innerText = parseInt(value).toLocaleString();
    }
</script>
</body>
</html>
