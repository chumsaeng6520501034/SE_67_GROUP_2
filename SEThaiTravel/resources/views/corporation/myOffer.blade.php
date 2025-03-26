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
            <form action="/corpSearchMyoffer" method="GET">
                <div class="flex items-center bg-white shadow-md p-4 rounded-lg mb-4 space-x-4">
                    <div class="relative flex-1">
                        <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search Tours name..."
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
                            <option value="new" style="color:#007BFF;">NEW</option>
                            <option value="approve" style="color:#28A745;">APPROVE</option>
                            <option value="reject" style="color: #FF5733;">REJECT</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">Search</button>
                    </div>
                </div>
            </form>

            <div class="card-wrapper">
                @foreach ($requestTours as $offer)
                    <div class="card-container m-4">
                        <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden">
                            <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp"
                                alt="Bangkok" class="w-1/3 object-cover">
                            <div class="p-6 flex-1">
                                <form action="/corpOfferDetail" method="GET">
                                    <h2 class="text-2xl font-bold text-black-600 hover:text-blue-500">
                                        <input type="hidden" name="requestID" value={{ $offer->id_request_tour }}>
                                        <button type="submit"> {{ ucwords($offer->name) }} </button>
                                    </h2>
                                </form>
                                <p class="text-gray-600 mt-1">{{ $offer->description }}</p>
                                @switch($offer->status)
                                    @case('new')
                                        <p class="text-[#007BFF] text-sm mt-2 font-bold">{{ ucwords($offer->status) }}</p>
                                    @break

                                    @case('reject')
                                        <p class="text-[#FF5733] text-sm mt-2 font-bold">{{ ucwords($offer->status) }}</p>
                                    @break

                                    @case('approve')
                                        <p class="text-[#28A745] text-sm mt-2 font-bold">{{ ucwords($offer->status) }}</p>
                                    @break
                                @endswitch
                                <p class="text-gray-400 text-xs mt-1">Start Date: {{ $offer->start_tour_date }}</p>
                                <p class="text-gray-400 text-xs  mt-1">End Date: {{ $offer->end_tour_date }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow h-full flex flex-col justify-between">
                                <!-- ส่วนบน: วันที่ -->
                                <div class="text-right">
                                    <h2 class="font-bold">Request Date</h2>
                                    <p>{{ $offer->request_date }}</p>
                                    <h2 class="font-bold mt-2">End Request Date</h2>
                                    <p>{{ $offer->end_of_request_date }}</p>
                                </div>

                                <!-- ส่วนล่าง: ปุ่ม -->
                                <div class="flex justify-end space-x-2 mt-4">
                                    <form action="/guideEditOffer" method="GET">
                                        <input type="hidden" name="offerID" value="{{ $offer->id_offer }}">
                                        <button
                                            class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">Edit</button>
                                    </form>
                                    <button onclick="openModal({{ $offer->id_offer }})"
                                        class="bg-red-600 text-white px-4 py-2 rounded-md font-bold">Delete</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="deleteModal{{ $offer->id_offer }}"
                        class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-md shadow-lg w-1/3">
                            <h3 class="text-lg font-semibold text-gray-800">Are you sure you want to delete this offer?
                            </h3>
                            <p class="text-sm text-gray-600">{{ $offer->name }}</p>
                            <div class="mt-4 flex justify-between">
                                <!-- Cancel Button -->
                                <button onclick="closeModal({{ $offer->id_offer }})"
                                    class="bg-gray-400 text-white px-4 py-2 rounded-md">Cancel</button>
                                <!-- Confirm Button (Form for Deleting) -->
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="offerID" value={{ $offer->id_offer }}>
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">Confirm
                                        Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $requestTours->links() }}
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
                "new": "text-[#007BFF]",
                "approve": "text-[#28A745]",
                "reject": "text-[#FF5733]"
            };

            // ลบสีเก่าก่อน
            this.classList.remove("text-black", "text-[#007BFF]", "text-[#28A745]",
                "text-[#FF5733]");

            // เพิ่มสีใหม่ตามค่าที่เลือก
            this.classList.add(colors[this.value] || "text-black");
        });
    </script>
</body>

</html>
