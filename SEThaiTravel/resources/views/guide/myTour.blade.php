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
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
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
            <form action="/guideSearchMyTour" method="GET">
                <div class="flex items-center p-4 rounded-lg mb-4 space-x-4 bg-white/10 backdrop-blur-2xl rounded-xl w-3/4 mx-52">
                    <div class="relative flex-1 text-white font-bold text-xl">
                        <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search Tours name..."
                            class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg text-black">
                        <span class="absolute left-3 top-8 text-gray-500">🔍</span>
                    </div>
                    <div class="relative flex-1 text-white font-bold text-xl">
                        <label>Start Date</label>
                        <input type="date" name="startDate" id="startDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-lg">
                    </div>
                    <div class="relative flex-1 text-white font-bold text-xl">
                        <label>End Date</label>
                        <input type="date" name="endDate" id="endDate"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-lg">
                    </div>
                    <div class="relative flex-1 text-white font-bold text-xl">
                        <label>Status</label>
                        <select id="filterDropdown" name="status"
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-lg">
                            <option value="" style="color: black;">All Status</option>
                            <option value="ongoing" style="color:#007BFF;">ON GOING</option>
                            <option value="finish" style="color:#28A745;">FINISH</option>
                            <option value="collect" style="color: #FFC107;">COLLECT</option>
                            <option value="cancal" style="color: #FF5733;">CANCEL</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-900 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">Search</button>
                    </div>
                </div>
            </form>

            <div class="card-wrapper">
                @php
                    $startArray = 0;
                @endphp
                @foreach ($tourData as $tour)
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden">
                            @if (is_null($tour->tourImage))
                                <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp"
                                    alt="Bangkok" class="w-1/3 object-cover">
                            @else
                                <img src="{{ asset('storage/' . $tour->tourImage) }}" alt="image"
                                    class="w-1/3 object-cover">
                            @endif
                            <div class="p-6 flex-1">
                                <form action="/guideDetailMyTour" method="POST">
                                    @csrf
                                    <h2 class="text-2xl font-bold text-black-600 hover:text-blue-500">
                                        <input type="hidden" name="tourID" value={{ $tour->id_tour }}>
                                        <button type="submit"> {{ ucwords($tour->name) }} </button>
                                    </h2>
                                </form>
                                <p class="text-gray-600 mt-1">{{ $tour->description }}</p>
                                @switch($tour->status)
                                    @case('ongoing')
                                        <p class="text-[#007BFF] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break

                                    @case('cancal')
                                        <p class="text-[#FF5733] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break

                                    @case('finish')
                                        <p class="text-[#28A745] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break

                                    @case('collect')
                                        <p class="text-[#FFC107] text-sm mt-2 font-bold">{{ ucwords($tour->status) }}</p>
                                    @break
                                @endswitch
                                <p class="text-gray-400 text-xs mt-1">Start Date: {{ $tour->start_tour_date }}</p>
                                <p class="text-gray-400 text-xs  mt-1">End Date: {{ $tour->end_tour_date }}</p>
                                <p
                                    class="text-base font-semibold mt-3 {{ $totalMember[$startArray] < $tour->tour_capacity ? 'text-green-500' : 'text-red-500' }}">
                                    NET AMOUNT:
                                    {{ is_null($totalMember[$startArray]) ? 0 : $totalMember[$startArray] }}/{{ $tour->tour_capacity }}
                                </p>
                            </div>
                            <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                <p class="text-gray-800 text-md font-bold">Release Date</p>
                                <p class="text-gray-600 font-semibold">{{ $tour->Release_date }}</p>
                                <p class="text-gray-800 text-md font-bold">Expiration Date</p>
                                <p class="text-gray-600 text-md font-semibold">
                                    {{ $tour->End_of_sale_date }}</p>
                                <p class="text-gray-800 m-2 text-md font-bold">{{ number_format($tour->price) }} ฿</p>
                                <div class="flex justify-end space-x-2">
                                    @if ($tour->status == 'ongoing')
                                        <form action="/guideEditTourPage" method="GET">
                                            <button
                                                class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">Edit</button>
                                            <input type="hidden" name="tourID" value={{ $tour->id_tour }}>
                                        </form>
                                        <!-- Delete Button -->
                                        <button onclick="openModal({{ $tour->id_tour }})"
                                            class="bg-red-600 text-white px-4 py-2 rounded-md font-bold">Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="deleteModal{{ $tour->id_tour }}"
                        class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-md shadow-lg w-1/3">
                            <h3 class="text-lg font-semibold text-gray-800">Are you sure you want to delete?</h3>
                            <p class="text-sm text-gray-600">{{ $tour->name }}</p>
                            <div class="mt-4 flex justify-between">
                                <!-- Cancel Button -->
                                <button onclick="closeModal({{ $tour->id_tour }})"
                                    class="bg-gray-400 text-white px-4 py-2 rounded-md">Cancel</button>
                                <!-- Confirm Button (Form for Deleting) -->
                                <form action="/guideDeleteMyTour" method="POST">
                                    @csrf
                                    <input type="hidden" name="tourID" value={{ $tour->id_tour }}>
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">Confirm
                                        Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @php
                        $startArray++;
                    @endphp
                @endforeach
                {{ $tourData->links() }}
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById('deleteModal' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('deleteModal' + id).classList.add('hidden');
        }
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('open');
        });
        document.getElementById("filterDropdown").addEventListener("change", function() {
            const colors = {
                "": "text-black",
                "ongoing": "text-[#007BFF]",
                "collect": "text-[#FFC107]",
                "finish": "text-[#28A745]",
                "cancal": "text-[#FF5733]"
            };

            // ลบสีเก่าก่อน
            this.classList.remove("text-black", "text-[#007BFF]", "text-[#FFC107]", "text-[#28A745]",
                "text-[#FF5733]");

            // เพิ่มสีใหม่ตามค่าที่เลือก
            this.classList.add(colors[this.value] || "text-black");
        });
    </script>
</body>

</html>
