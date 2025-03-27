<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* ให้ภาพไม่เลื่อนตาม */
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

        /* CSS สำหรับ Modal */
        .modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            width: 300px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .modal-background {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
        }
    </style>
</head>
<body class="bg-gray-900">
    <!-- Sidebar -->
    @include('components.sidebarCustomer')
    <div id="mainContent" class="flex-1 p-10 transition-all duration-300 overflow-y-auto ml-2">
        <!-- Search and Filter -->
        <form action="#" method="POST">
            @csrf
            <div class="flex items-center p-4 rounded-xl mb-4 space-x-4 bg-white/10 backdrop-blur-2xl mx-52 w-3/4">
                <div class="relative flex-1 text-white text-xl font-bold">
                    <label>Tour name</label>
                    <input type="text" id="searchBar" name="name" placeholder="Search"
                        class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute left-3 top-8 text-gray-500">🔍</span>
                </div>
                <div class="relative flex-1 text-white text-xl font-bold">
                    <label>Start Date</label>
                    <input type="date" name="startDate" id="startDate"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                </div>
                <div class="relative flex-1 text-white text-xl font-bold">
                    <label>End Date</label>
                    <input type="date" name="endDate" id="endDate"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                </div>
                <div class="relative flex-1 text-white text-xl font-bold">
                    <label>Status</label>
                    <select id="filterDropdown" name="status"
                        class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                        <option value="" style="color: black;">All Status</option>
                        <option value="finish" style="color: rgb(12, 236, 12);">FINISH</option>
                        <option value="onGoing" style="color: rgb(255, 255, 44);">ON GOING</option>
                        <option value="cancel" style="color: rgb(255, 41, 41);">CANCEL</option>
                    </select>
                </div>
                <div>
                    <button id="submitButton" type="submit"
                        class="mt-3 bg-blue-900 text-white px-4 py-2 rounded-lg font-bold transition duration-300">Search</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Travel Deals -->
    <div class="card-wrapper">
        @foreach ($All_req as $All_req)  
            <div class="card-container m-4">
                <div class="card bg-white rounded-lg shadow-lg flex overflow-hidden relative">
                    <!-- ปุ่มลบ มุมขวาบน -->
                    <button onclick="openModal('{{ $All_req->id_request_tour }}')"
                        class="absolute top-2 right-2 cursor-pointer bg-red-500 hover:bg-red-700 text-white rounded-full p-2"
                        @if(in_array($All_req->request_status, ['cancal', 'finish'])) style="display: none;" @endif>
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m5 6l4 4m0-4l-4 4"></path>
                        </svg>
                    </button>
                    
                    <!-- Modal ยืนยันการลบ - ย้ายมาไว้ในการ์ด -->
                    <div id="deleteModal_{{ $All_req->id_request_tour }}" class="modal">
                        <p>คุณแน่ใจหรือไม่ว่าต้องการลบทัวร์นี้?</p>
                        <input type="hidden" id="tourID_{{ $All_req->id_request_tour }}">
                        <div class="flex justify-end space-x-2 mt-4">
                            <button onclick="closeModal('{{ $All_req->id_request_tour }}')" class="px-4 py-2 bg-gray-300 rounded">ยกเลิก</button>
                            <form action="/deleteRequestTour" method="POST">
                                @csrf
                                <input type="hidden" name="tourID" value="{{ $All_req->id_request_tour }}">
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">ลบ</button>
                            </form>
                        </div>
                    </div>

                    <!-- Icon บนขวา ที่สามารถกดได้ -->
                    <form action="/editAddtour" method="POST">
                        @csrf
                        <input type="hidden" name="tourID" value="{{ $All_req->id_request_tour }}">
                        <button type="submit" class="absolute top-3 right-14 cursor-pointer"
                            @if($All_req->request_status == 'cancal' || $All_req->request_status == 'finish') style="display: none;" @endif>
                            <svg class="h-8 w-8 text-black hover:text-blue-900" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>  
                                <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  
                                <path d="M9 15h3l8.5 -8.5a1.5 1.0 0 0 0 -3 -3l-8.5 8.5v3" />
                            </svg>
                        </button>
                    </form>

                    <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp" alt="Bangkok" class="w-1/3 object-cover">
                    <div class="p-6 flex-1">
                        <form action="/requestDetail" method="Post">
                            @csrf
                            <input type="hidden" name="requestID" value="{{ $All_req->id_request_tour }}">
                            <button type="submit" class="text-xl font-bold text-blue-500 hover:underline">
                                {{ ucwords($All_req->name) }}
                            </button>
                        </form>
                        <p class="text-gray-600">{{ $All_req->request_date}}</p>
                        @switch($All_req->request_status)
                        @case("finish")
                        <p class="text-green-700 mt-2">{{ ucwords($All_req->request_status) }}</p>@break
                        @case("ongoing")
                        <p class="text-yellow-700 mt-2">{{ ucwords($All_req->request_status) }}</p>@break
                        @case("cancal")
                        <p class="text-red-700 mt-2">cancel</p>@break
                        @endswitch
                    </div>
                    <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                        <p class="text-sm text-gray-500 mt-8">BOOKING DATE</p>
                        <p class="font-bold mt-2">{{ $All_req->request_date}}</p>
                        <p class="text-gray-500 mt-2">Price</p>
                        <p class="text-xl font-bold mt-2">{{$All_req->max_price }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- JavaScript สำหรับ Modal -->
    <script>
        function openModal(tourId) {
            document.getElementById('deleteModal_' + tourId).style.display = 'block';
            document.getElementById('modalBackground').style.display = 'block';
        }

        function closeModal(tourId) {
            document.getElementById('deleteModal_' + tourId).style.display = 'none';
            document.getElementById('modalBackground').style.display = 'none';
        }
        document.getElementById("searchBar").addEventListener("input", function() {
        let searchText = this.value.toLowerCase();
        let cards = document.querySelectorAll(".card-container");

        cards.forEach(card => {
            let tourName = card.querySelector("button.text-xl").textContent.toLowerCase();
            if (tourName.includes(searchText)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
            });
        });
    </script>
</body>
</html>
