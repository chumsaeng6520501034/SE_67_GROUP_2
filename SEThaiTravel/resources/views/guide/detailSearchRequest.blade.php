<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900">
    <!-- Navbar -->
    <nav
        class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 flex justify-start items-center space-x-6 z-50  bg-gray-900 w-full text-center ">
        <a href="{{ $path }}" class="text-2xl text-white font-bold">&#x2190;</a>
        <span class="font-bold text-xl text-white">THAI TRAVEL & TOUR</span>
    </nav>

    <!-- Layout -->
    <div class="p-6 pt-20 grid grid-cols-1 md:grid-cols-3 gap-6 w-full container mx-auto ">
        <!-- รูปภาพใหญ่ -->
        <div class="md:col-span-2 h-full">
            <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp" alt="Bangkok"
                class="w-full h-[400px] object-cover rounded-lg shadow-md">
        </div>

        <!-- ข้อมูลด้านขวา -->
        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center w-full max-w-md mx-auto h-[400px]">
            <!-- หัวข้อ Quantity -->
            <div class="bg-blue-900 text-white text-xl font-bold w-full text-center py-3 shadow-sm rounded-md">
                <p class="text-2xl">{{ ucwords($requestData->name) }}<br>Quantity : {{ $requestData->size_tour }}
                    Person</p>
            </div>

            <!-- รายละเอียด Children / Adults -->
            <div class="flex justify-center w-full py-12">
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Guide Quantity</h3>
                    <p class="text-2xl">{{ $requestData->guide_qty }}</p>
                </div>
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Status</h3>
                    @switch($requestData->request_status)
                        @case('ongoing')
                            <p class="text-[#007BFF] text-2xl font-bold">{{ ucwords($requestData->request_status) }}</p>
                        @break

                        @case('cancal')
                            <p class="text-[#FF5733] text-2xl font-bold">{{ ucwords($requestData->request_status) }}</p>
                        @break

                        @case('finish')
                            <p class="text-[#28A745] text-2xl font-bold">{{ ucwords($requestData->request_status) }}</p>
                        @break

                        @case('collect')
                            <p class="text-[#FFC107] text-2xl font-bold">{{ ucwords($requestData->request_status) }}</p>
                        @break
                    @endswitch
                </div>
            </div>

            <!-- ปุ่ม -->
            <div class="flex gap-4 w-full overflow-y-auto">
                <div
                    class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl overflow-y-auto">
                    Hotel <br><span class="italic font-normal text-base">
                        {{ $requestData->hotel_status }}
                    </span>
                </div>
                <div
                    class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl overflow-y-auto">
                    Travel By<br>
                    {{ $requestData->travel_status }}
                </div>
            </div>
        </div>
    </div>

    <!-- กล่องข้อมูลด้านล่าง -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-1 gap-6 w-full container mx-auto">
        <!-- กล่องซ้าย: ข้อมูลหลัก -->
        <div class="flex flex-col gap-4 w-full">
            <!-- Grid ของ Start-End Date, Post Date, Price -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow-md w-full">
                <div class="flex flex-col h-full">
                    <p class="font-bold text-center">Start - End Date</p>
                    <div
                        class="bg-blue-900 text-white px-6 py-3 text-center rounded-lg inline-block shadow-md w-full flex-1 flex items-center justify-center">
                        {{ $requestData->start_tour_date }}<br>To<br>{{ $requestData->end_tour_date }}
                    </div>
                </div>
                <div class="flex flex-col h-full">
                    <p class="font-bold text-center">Post Date</p>
                    <div
                        class="bg-blue-900 text-white px-6 py-3 text-center rounded-lg inline-block shadow-md w-full flex-1 flex items-center justify-center">
                        {{ $requestData->request_date }}
                    </div>
                </div>
                <div class="flex flex-col h-full">
                    <p class="font-bold text-center">Min-Max Budget</p>
                    <div
                        class="bg-blue-900 text-white px-6 py-3 text-center rounded-lg inline-block shadow-md w-full flex-1 flex items-center justify-center">
                        {{ number_format($requestData->start_price) }} - {{ number_format($requestData->max_price) }}
                    </div>
                </div>
            </div>

            <!-- Owner of post และ Description -->
            <div class="bg-white p-6 rounded-lg shadow-md w-full">
                <p class="font-bold">Owner of post : <span class="font-normal">
                        {{ $requestData->uName . ' ' . $requestData->surname }}
                    </span></p>
                <p class="font-bold mt-2">Contact: <span class="font-normal">
                        {{ $requestData->phonenumber }}
                    </span></p>
                </p>
                <p class="font-bold mt-2">Description:</p>
                <p class="mt-2">{{ $requestData->description }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white py-6 px-6 rounded-lg shadow-md mt-4 w-[1485px] mx-auto mb-10">
        <h4 class="text-2xl font-bold mb-3">Offer</h4>

        <!-- กล่องรีวิวแบบเลื่อน -->
        <div class="max-h-[300px] overflow-y-auto space-y-2 p-2 bg-gray-50 rounded-lg shadow-inner">
            @foreach ($offerData as $offer)
                <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                    @if ($offer->from_who_offer == 'guide')
                        <strong>{{ $offer->name . ' ' . $offer->surname }}:</strong>
                        @switch($offer->status)
                        @case('new')
                        <span class="text-blue-500">{{ "($offer->status)" }}</span><br>
                        @break
                        @case('reject')
                        <span class="text-red-500">{{ "($offer->status)" }}</span><br>
                        @break
                        @case('approve')
                        <span class="text-green-500">{{ "($offer->status)" }}</span><br>
                        @break
                        @endswitch
                        <p>
                            Offer Price: {{number_format($offer->price)}}
                        </p>
                    @else
                        <strong>{{ $offer->name }}: 
                            @switch($offer->status)
                            @case('new')
                            <span class="text-blue-500">{{ "($offer->status)" }}</span><br>
                            @break
                            @case('reject')
                            <span class="text-red-500">{{ "($offer->status)" }}</span><br>
                            @break
                            @case('approve')
                            <span class="text-green-500">{{ "($offer->status)" }}</span><br>
                            @break
                            @endswitch
                        <p>
                            Offer Price: {{number_format($offer->price)}}
                        </p>
                    @endif
                </div>
            @endforeach
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
    </script>
</body>

</html>
