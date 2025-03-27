<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Sarabun', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
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
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('components.sidebarCustomer')

    <div id="mainContent" class="flex-1 p-10 transition-all duration-300 overflow-y-auto ml-2">
            <!-- Search and Filter -->
            <form action="/searchHistory" method="GET">
                @csrf
                <div class="flex items-center p-4 rounded-xl mb-4 space-x-4 bg-white/10 backdrop-blur-2xl mx-52 w-3/4">
                    <div class="relative flex-1 text-white text-xl font-bold">
                        <label>Tour name</label>
                        <input type="text" id="searchBar" name="name" placeholder="Search "
                            class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
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
                            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black text-lg">
                            <option value="" style="color: black;">All Status</option>
                            <option value="notReview" style="color: rgb(236, 12, 12);">NOT REVIEW</option>
                            <option value="Review" style="color: rgb(15, 221, 8);">REVIEWED</option>
                        </select>
                    </div>
                    <div>
                        <button id="submitButton" type="submit"
                            class="mt-3 bg-blue-900 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition duration-300">Search</button>
                    </div>
                </div>
            </form>
            @php
            $tours = [];
                foreach ($historyData as $history) {
                    $reviewCount = \App\Models\Review::where('booking_id_booking', $history->id_booking)->count();
                    $tours[] = [
                    "image_url" => "https://www.treehouse-villas.com/wp-content/uploads/2024/01/%E0%B8%84%E0%B8%B9%E0%B9%88%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B9%80%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%A2%E0%B8%A7%E0%B8%A0%E0%B8%B9%E0%B9%80%E0%B8%81%E0%B9%87%E0%B8%95%E0%B8%89%E0%B8%9A%E0%B8%B1%E0%B8%9A%E0%B8%9A%E0%B8%84%E0%B8%99%E0%B8%A1%E0%B8%B2%E0%B8%84%E0%B8%A3%E0%B8%B1%E0%B9%89%E0%B8%87%E0%B9%81%E0%B8%A3%E0%B8%81-2024.webp",
                        "name" => $history->name, // ชื่อทัวร์
                        "description" => $history->tourDes, // รายละเอียดทัวร์
                        "reviews_count" => $reviewCount,
                        "reviews" => $history->score, // คะแนนรีวิว (จากตาราง review)
                        "price" => $history->total_price, // ราคาทัวร์ (จาก booking หรือ tour)
                        "tour_id_tour"=> $history->tour_id_tour,
                        "bookingId"=> $history->id_booking
                    ];
                
                }// dd($tours);
        @endphp
        <!-- เพิ่ม Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- ครอบโค้ดด้วย x-data เพื่อควบคุม openModal -->
        <div x-data="{ openModal: false ,selectedTourId: null, bookingId: null}">
            <!-- Tour List -->
                <div class="card-wrapper">
                    {{-- ทำตรงนี้ --}}
                    @foreach ($tours as $tour)
                        <div class="card-container m-4">
                            <div class="card bg-white relative rounded-lg shadow-lg flex overflow-hidden">
                                <img src="{{ $tour['image_url'] }}" class="w-1/3 object-cover">
                                <form action="/customerViewReview" method="POST">
                                    @csrf
                                    <input type="hidden" name="tourID" value={{$tour['tour_id_tour']}}>
                                    <input type="hidden" name="bookingID" value={{$tour['bookingId']}}>
                                    <input type="hidden" name="path" value={{$path}}>
                                    <button type="submit" class="absolute inset-0 w-full h-full opacity-0 "></button>
                                </form>
                                <div class="p-6 flex-1">
                                    <h2 class="text-xl font-bold mt-4">{{ $tour['name'] }}</h2>
                                    <p class="text-gray-600 mt-2">{{ $tour['description'] }}</p>
                                </div>
                                <div class="p-6 bg-gray-100 w-1/4 text-right rounded-r-lg">
                                    <p class="font-bold mt-4">Tour REVIEW</p>
                                    <p>{{ $tour['reviews_count'] }} reviews</p>
                                    {{-- <p class="text-yellow-500 text-lg">★★★★★</p> --}}
                                    <p class="text-yellow-500 text-lg">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $tour['reviews'])
                                                <span class="text-yellow-500">★</span> <!-- ดาวเต็ม -->
                                            @else
                                                <span class="text-gray-400">★</span> <!-- ดาวจาง -->
                                            @endif
                                        @endfor
                                    </p>
                                    <p class="font-bold">Price</p>
                                    <p>${{ $tour['price'] }}</p>

                                    <!-- ปุ่ม REVIEW -->
                                    <div class="flex justify-end mt-2">
                                        {{-- ; selectedTourId = '{{ $tour-> }}'; loadGuides('{{ $tour['id'] }}' --}}
                                        <button @click="openModal = true; selectedTourId ='{{$tour['name']}}'; loadGuides('{{ $tour['tour_id_tour'] }}'); bookingId={{$tour['bookingId']}}" 
                                                class="bg-blue-600 text-white text-lg px-6 py-2 rounded-lg hover:bg-blue-700 transition z-[50]"
                                                @if ($tour['reviews']) disabled @endif>
                                            @if ($tour['reviews'])
                                                Reviewed
                                            @else
                                                Review
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            <!-- Popup Modal -->
            <form id="reviewForm" action="/submitReview" method="POST">
                @csrf
                <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                    <div class="bg-white/10 backdrop-blur-lg p-6 rounded-lg shadow-lg w-[700px] max-h-[80vh] overflow-y-auto">
                        <h2 class="text-xl font-bold mb-4" x-text="selectedTourId"></h2>
            
                        <!-- รีวิวทัวร์ -->
                        <div class="border p-4 rounded-lg shadow-md w-[600px] mx-auto mb-6">
                            <label class="block font-bold mb-2">Tour Review</label>
                            <div class="flex justify-center mb-2">
                                <span class="star tour-star text-3xl cursor-pointer" data-value="1">⭐</span>
                                <span class="star tour-star text-3xl cursor-pointer" data-value="2">⭐</span>
                                <span class="star tour-star text-3xl cursor-pointer" data-value="3">⭐</span>
                                <span class="star tour-star text-3xl cursor-pointer" data-value="4">⭐</span>
                                <span class="star tour-star text-3xl cursor-pointer" data-value="5">⭐</span>
                            </div>
                            <input type="hidden" name="tour_rating" id="tourRatingInput" value={{5}}>
                            <textarea name="tour_review" class="w-full border p-2 rounded mb-4" rows="3" placeholder="Write your tour experience..."></textarea>
                        </div>
                        <input type="hidden" name="bookingId" x-model="bookingId">
                        <!-- รีวิวไกด์ -->
                        <div id="guideReviewContainer">
                            <h3 class="text-lg font-bold mb-2">Guide Reviews</h3>
                        </div>
                        <!-- ปุ่มเพิ่มรีวิวไกด์ -->
                        <button type="button" onclick="addGuideReview()" id="addGuide" class="mt-2 mb-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                            + Add Guide Review
                        </button>
            
                        <!-- ปุ่มกด -->
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" @click="openModal = false" onclick="resetGuideCount()" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-red-500 transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let guideCount = 0;
        function addGuideReview() {
            if(guideCount<1){
                guideCount++;
                let guideDiv = document.createElement('div');
                guideDiv.classList.add('border', 'p-4', 'rounded-lg', 'shadow-md', 'w-[600px]', 'mx-auto', 'mb-4');
                guideDiv.setAttribute('id', `guideReview_${guideCount}`);
                    guideDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-bold">Guide Review #${guideCount}</label>
                            <button type="button" onclick="removeGuideReview(${guideCount})" class="text-red-500 text-xl font-bold hover:text-red-700">❌</button>
                        </div>
                        <select name="guide_reviews[${guideCount}][id]" class="w-full border p-2 rounded mb-2">
                                <template x-for="guide in Alpine.store('guideList')" :key="guide.guide_list_account_id_account">
                                    <option :value="guide.guide_list_account_id_account" x-text="guide.guide_name"></option>
                                </template>
                        </select>
                        <div class="flex justify-center mb-2">
                            <span class="star guide-star-${guideCount} text-3xl cursor-pointer" data-value="1">⭐</span>
                            <span class="star guide-star-${guideCount} text-3xl cursor-pointer" data-value="2">⭐</span>
                            <span class="star guide-star-${guideCount} text-3xl cursor-pointer" data-value="3">⭐</span>
                            <span class="star guide-star-${guideCount} text-3xl cursor-pointer" data-value="4">⭐</span>
                            <span class="star guide-star-${guideCount} text-3xl cursor-pointer" data-value="5">⭐</span>
                        </div>
                        <input type="hidden" value="5" name="guide_reviews[${guideCount}][rating]" id="guideRatingInput_${guideCount}">
                        <textarea name="guide_reviews[${guideCount}][review]" class="w-full border p-2 rounded mb-4" rows="3" placeholder="Write your guide experience..."></textarea>
                    `;

                    document.getElementById('guideReviewContainer').appendChild(guideDiv);

                    // ทำให้กดเลือกดาวได้จริง
                    document.querySelectorAll(`.guide-star-${guideCount}`).forEach(star => {
                        star.addEventListener('click', function () {
                            let value = this.getAttribute('data-value');
                            document.getElementById(`guideRatingInput_${guideCount}`).value = value;

                            document.querySelectorAll(`.guide-star-${guideCount}`).forEach(s => {
                                s.textContent = s.getAttribute('data-value') <= value ? '⭐' : '☆';
                            });
                        });
                    });
                }
                if(guideCount==1)
                {
                    document.getElementById('addGuide').innerHTML="Can add just one Guide";
                }
            }
        function resetGuideCount(){
            guideCount = 0;
            let container = document.getElementById('guideReviewContainer');
        
            while (container.firstChild) {
                container.removeChild(container.firstChild); // ลบลูกทุกตัวออก
            }
        }
        function removeGuideReview(id) {
            let guideDiv = document.getElementById(`guideReview_${id}`);
            if (guideDiv) {
                guideCount--;
                guideDiv.remove();
            }
        }

        // ฟังก์ชันเลือกดาวของรีวิวทัวร์
        document.querySelectorAll('.tour-star').forEach(star => {
            star.addEventListener('click', function () {
                let value = this.getAttribute('data-value');
                document.getElementById('tourRatingInput').value = value;

                document.querySelectorAll('.tour-star').forEach(s => {
                    s.textContent = s.getAttribute('data-value') <= value ? '⭐' : '☆';
                });
            });
        });
        function loadGuides(tourId) {
            fetch(`/api/getGuideInTour?tour_id=${tourId}`)
                .then(response => response.json())
                .then(data => {
                    Alpine.store('guideList', data.guides);
                    console.log('Updated guideList:', data.guides);
                });
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
<!-- https://d2e5ushqwiltxm.cloudfront.net/wp-content/uploads/sites/67/2023/07/20040349/Finding-the-best-areas-to-live-in-Bangkok.jpg  -->