<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2019/11/10/08/31/beach-4615202_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inknut Antiqua', serif;
            height: 100vh;
            overflow: hidden;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #mainContent {
            transition: margin-left 0.3s ease-in-out;
            width: 100%;
            overflow-y: auto;
            height: 100vh;
            padding-bottom: 2rem;
        }

        #sidebar.open~#mainContent {
            margin-left: 18rem;
        }

        .logout {
            margin-top: auto;
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
    </style>
</head>

<body>
    <div class="flex">
        @include('components.sidebarGuide')

        <div id="mainContent" class="flex-1 p-10 transition-all duration-300 overflow-y-auto ml-2">
            <!-- Search and Filter -->
            <form>
                <div class="flex items-center bg-white shadow-md p-4 rounded-lg mb-4 space-x-4">
                    <div class="relative flex-1">
                        <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search Booking tours..."
                            class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="absolute left-3 top-8 text-gray-500">🔍</span>
                    </div>
                    <div class="relative flex-1">
                        <label>Start Date</label>
                        <input type="date" name="startDate" id="startDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="relative flex-1">
                        <label>End Date</label>
                        <input type="date" name="endDate" id="endDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="relative flex-1">
                        <label>Status</label>
                        <select id="filterDropdown" name="status"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" style="color: black;">All Status</option>
                            <option value="paid" style="color: rgb(12, 236, 12);">PAID</option>
                            <option value="In process" style="color: rgb(255, 255, 44);">IN PROCESS</option>
                            <option value="cancel" style="color: rgb(255, 41, 41);">CANCEL</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">Search</button>
                    </div>
                </div>
            </form>

            <div class="card-wrapper">
                @foreach ($tourData as $tour)
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden">
                            @if(is_null($tour->tourImage))
                            <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp"
                                alt="Bangkok" class="w-1/3 object-cover">
                            @else
                            <img src="{{ asset('storage/' . $tour->tourImage) }}"
                                alt="image" class="w-1/3 object-cover">
                            @endif
                            <div class="p-6 flex-1">
                                    <h2 class="text-2xl font-bold text-black-600">
                                            {{ ucwords($tour->name) }}
                                    </h2>
                                <p class="text-gray-600 mt-1">{{ $tour->description }}</p>
                                @switch($tour->status)
                                    @case("ongoing")
                                        <p class="text-[#007BFF] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break
                                    @case("cancal")
                                        <p class="text-[#FF5733] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break
                                    @case("finish")
                                        <p class="text-[#28A745] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break
                                    @case("collect")
                                        <p class="text-[#FFC107] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break
                                @endswitch
                                <p class="text-gray-400 text-xs mt-1">Start Date: {{ $tour->start_tour_date }}</p>
                                <p class="text-gray-400 text-xs  mt-1">End Date: {{ $tour->end_tour_date }}</p>
                            </div>
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                <p class="text-gray-800 text-md font-bold">Release Date</p>
                                <p class="text-gray-600 font-semibold">{{$tour->Release_date}}</p>
                                <p class="text-gray-800 text-md font-bold">Expiration Date</p>
                                <p class="text-gray-600 text-md font-semibold">
                                    {{ $tour->End_of_sale_date }}</p>
                                <p class="text-gray-800 m-2 text-md font-bold">{{  number_format($tour->price) }} ฿</p>
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">Edit</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $tourData->links() }}
            </div>
            
        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('open');
        });
        document.getElementById("filterDropdown").addEventListener("change", function() {
            const colors = {
                "": "text-black",
                "paid": "text-green-500",
                "In process": "text-yellow-500",
                "cancel": "text-red-500"
            };

            // ลบสีเก่าก่อน
            this.classList.remove("text-black", "text-green-500", "text-yellow-500", "text-red-500");

            // เพิ่มสีใหม่ตามค่าที่เลือก
            this.classList.add(colors[this.value] || "text-black");
        });
    </script>
</body>

</html>
