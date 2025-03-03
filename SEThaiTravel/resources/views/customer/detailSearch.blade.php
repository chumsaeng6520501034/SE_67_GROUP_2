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
    <nav class="fixed w-full bg-gray-900 p-4 flex flex-wrap justify-between items-center z-50">
        <div class="flex items-center space-x-4">
            <a href="/" class="text-2xl text-white font-bold">&#x2190;</a>
            <span class="text-2xl text-white font-bold">TRAVEL</span>
        </div>
        <div class="flex flex-wrap space-x-4 items-center">
            <input type="text" placeholder="Search" class="border px-4 py-2 rounded-lg">

            <!-- Input วันที่ไป -->
            <div class="flex items-center space-x-2">
                <label class="text-xl font-semibold text-yellow-500">From:</label>
                <input type="date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input วันที่กลับ -->
            <div class="flex items-center space-x-2">
                <label class="text-xl font-semibold text-yellow-500">To:</label>
                <input type="date" class="border px-2 py-1 rounded-lg">
            </div>

            <!-- Input จำนวนคน -->
            <div class="flex items-center space-x-2">
                <label class="text-xl font-semibold text-yellow-500">People:</label>
                <input type="number" min="1" value="1" class="border px-2 py-1 rounded-lg w-16">
            </div>

            <!-- Input ช่วงงบประมาณ -->
            <div class="flex items-center space-x-2">
                <label class="text-xl font-semibold text-yellow-500">Min:</label>
                <input type="range" min="0" max="1000000" value="0" step="10000" class="w-24">
                <span class="text-sm font-semibold text-white">0</span>

                <label class="text-xl font-semibold text-yellow-500">Max:</label>
                <input type="range" min="0" max="1000000" value="1000000" step="10000" class="w-24">
                <span class="text-sm font-semibold text-white">1,000,000</span>
            </div>
        </div>
    </nav>

    <!-- Layout -->
    <div class="p-6 pt-20 grid grid-cols-1 md:grid-cols-3 gap-6 w-full container mx-auto">
        <!-- รูปภาพใหญ่ -->
        <div class="md:col-span-2 h-full">
            <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" 
                class="w-full h-[400px] object-cover rounded-lg shadow-md">
        </div>

        <!-- ข้อมูลด้านขวา -->
        <div class="bg-white p-4 rounded-lg shadow-md h-[400px] flex flex-col">
            <h2 class="font-bold text-lg">Location List</h2>
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
                        XX - XX / XX / XXXX
                    </div>
                </div>
                <div>
                    <p class="font-bold">Post Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        XX / XX / XXXX
                    </div>
                </div>
                <div>
                    <p class="font-bold">Price</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg inline-block shadow-md">
                        100,000
                    </div>
                </div>
            </div>

            <!-- Owner of post และ Description -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="font-bold">Owner of post : <span class="font-normal">นายสมสุข ใจดี</span></p>
                <p class="font-bold mt-2">Description</p>
            </div>
        </div>

        <!-- กล่องขวา: Quantity และปุ่ม -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- หัวข้อ Quantity -->
            <div class="bg-blue-900 text-white text-xl font-bold px-6 py-3">
                Quantity : 1,000 Person
            </div>

            <!-- รายละเอียด Children / Adults -->
            <div class="p-6 text-center">
                <div class="flex justify-between items-center">
                    <div class="w-1/2">
                        <h3 class="text-lg font-bold">Children</h3>
                        <p class="text-lg">100</p>
                    </div>
                    <div class="w-1/2">
                        <h3 class="text-lg font-bold">Adults</h3>
                        <p class="text-lg">900</p>
                    </div>
                </div>

                <!-- ปุ่ม -->
                <div class="flex gap-4 mt-4">
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg w-1/2 text-center shadow-md font-bold">
                        Hotel <span class="italic font-normal">xxx</span> (100/Day)
                    </div>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg w-1/2 text-center shadow-md font-bold">
                        Travel By <br> Bus
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
