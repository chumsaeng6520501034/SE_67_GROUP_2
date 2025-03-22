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
    <nav class="fixed top-0 left-1/2 transform -translate-x-1/2 p-4 flex justify-center items-center space-x-6 z-50">
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
            <div class="bg-blue-900 text-white text-xl font-bold w-full text-center py-3 shadow-sm rounded-md">
                <p class="text-2xl">Quantity : 1,000 Person</p>
            </div>

            <!-- รายละเอียด Children / Adults -->
            <div class="flex justify-center w-full py-16">
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Reserved</h3>
                    <p class="text-2xl">100</p>
                </div>
                <div class="text-center w-1/2">
                    <h3 class="text-2xl font-bold">Srplus</h3>
                    <p class="text-2xl">900</p>
                </div>
            </div>

            <!-- ปุ่ม -->
            <div class="flex gap-4 w-full">
                <div class="bg-blue-900 text-white px-6 py-3 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Hotel <br><span class="italic font-normal">xxx</span> <br>(100/Day)
                </div>
                <div class="bg-blue-900 text-white px-6 py-8 rounded-lg w-1/2 text-center shadow-md font-bold text-2xl">
                    Travel By<br>
                    <p class="text-xl font-bold">Bus</p>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 w-full container mx-auto grid md:grid-cols-2 gap-6">
        <!-- กล่องซ้าย -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
            <div class="flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
                <div class="text-center flex-1 shadow-sm">
                    <p class="font-semibold text-gray-700">Start - End Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg shadow-md font-medium">
                        XX - XX / XX / XXXX
                    </div>
                </div>
                <div class="text-center flex-1 shadow-sm">
                    <p class="font-semibold text-gray-700">Post Date</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg shadow-md font-medium">
                        XX / XX / XXXX
                    </div>
                </div>
                <div class="text-center flex-1 shadow-sm">
                    <p class="font-semibold text-gray-700">Price</p>
                    <div class="bg-blue-900 text-white px-4 py-2 rounded-lg shadow-md font-medium">
                        100,000
                    </div>
                </div>
            </div>
        </div>

        <!-- กล่องขวา -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
            <div>
                <p class="font-bold">Owner of post : <span class="font-normal">นายสมสุข ใจดี</span></p>
                <p class="font-bold mt-2">Description : </p>
            </div>
        </div>
    </div>


    <!-- offer -->
    <div class="bg-white py-6 px-6 rounded-lg shadow-md mt-4 w-[1485px] mx-auto mb-10">
    <h4 class="text-2xl font-bold mb-3">OFFER FROM GUIDES</h4>

    @php
        $offers = [
            ['guide' => 'คุณสมชาย', 'price' => '5,000', 'details' => 'แพ็คเกจรวมที่พัก 2 คืน และอาหาร 3 มื้อ'],
            ['guide' => 'คุณมาลี', 'price' => '4,500', 'details' => 'แพ็คเกจราคาประหยัด รวมอาหารเช้า'],
            ['guide' => 'คุณวิทยา', 'price' => '6,000', 'details' => 'ทัวร์พรีเมียม พร้อมกิจกรรมเสริม'],
            ['guide' => 'คุณสมชาย', 'price' => '5,000', 'details' => 'แพ็คเกจรวมที่พัก 2 คืน และอาหาร 3 มื้อ'],
            ['guide' => 'คุณมาลี', 'price' => '4,500', 'details' => 'แพ็คเกจราคาประหยัด รวมอาหารเช้า'],
            ['guide' => 'คุณวิทยา', 'price' => '6,000', 'details' => 'ทัวร์พรีเมียม พร้อมกิจกรรมเสริม']
        ];
    @endphp

    <!-- กล่องข้อเสนอ -->
    <div class="max-h-[300px] overflow-y-auto space-y-2 p-2 bg-gray-50 rounded-lg shadow-inner">
        @foreach($offers as $index => $offer)
            <div id="offerBox{{ $index }}" class="offer-box bg-gray-100 p-3 rounded-lg shadow-sm flex justify-between items-center">
                <div>
                    <strong>{{ $offer['guide'] }}</strong> Price: 
                    <span class="font-bold text-green-600">{{ $offer['price'] }} บาท</span>
                </div>
                <button id="offerBtn{{ $index }}" 
                    onclick="showOfferDetails('{{ $offer['guide'] }}', '{{ $offer['price'] }}', '{{ $offer['details'] }}', {{ $index }})"
                    class="offer-btn px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    data-index="{{ $index }}">
                    Open Detail
                </button>
            </div>
        @endforeach
    </div>

    <!-- Modal แสดงรายละเอียดข้อเสนอ -->
    <div id="offerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white p-6 rounded-2xl shadow-2xl w-[90%] max-w-md relative transform transition-all scale-95">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Detail Offer</h2>
            <div class="space-y-3 text-gray-700">
                <div class="p-3 border rounded-lg bg-gray-100">
                    <p><strong class="text-gray-900">Guide:</strong> <span id="modalGuide" class="text-blue-600 font-semibold"></span></p>
                </div>
                <div class="p-3 border rounded-lg bg-gray-100">
                    <p><strong class="text-gray-900">Price:</strong> <span id="modalPrice" class="text-green-600 font-bold"></span> บาท</p>
                </div>
                <div class="p-3 border rounded-lg bg-gray-100">
                    <p><strong class="text-gray-900">Detail:</strong> <span id="modalDetails"></span></p>
                </div>
            </div>
            <div class="flex justify-center space-x-4 mt-6">
                <button id="acceptOfferBtn" onclick="toggleOffer()"
                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full hover:from-green-600 hover:to-green-700 transition shadow-lg transform hover:scale-105">
                    Accept Offer
                </button>
                <button onclick="closeOfferModal()" 
                    class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full hover:from-red-600 hover:to-red-700 transition shadow-lg transform hover:scale-105">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Modal ยืนยัน -->
    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 id="confirmationText" class="text-xl font-semibold text-center"></h3>
            <button onclick="closeConfirmationModal()" 
                class="block mx-auto mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    let selectedOfferIndex = null;
    function showOfferDetails(guide, price, details, index) {
        document.getElementById("modalGuide").textContent = guide;
        document.getElementById("modalPrice").textContent = price;
        document.getElementById("modalDetails").textContent = details;
        
        let modal = document.getElementById("offerModal");
        modal.classList.remove("hidden");
        setTimeout(() => modal.classList.remove("opacity-0", "scale-95"), 10);

        let acceptBtn = document.getElementById("acceptOfferBtn");
        if (selectedOfferIndex === index) {
            acceptBtn.textContent = "Cancel Offer";
            acceptBtn.classList.remove("bg-green-500");
            acceptBtn.classList.add("bg-yellow-500");
        } else {
            acceptBtn.textContent = "Accept Offer";
            acceptBtn.classList.remove("bg-yellow-500");
            acceptBtn.classList.add("bg-green-500");
        }
        acceptBtn.setAttribute("data-index", index);
    }

    function closeOfferModal() {
        let modal = document.getElementById("offerModal");
        modal.classList.add("opacity-0", "scale-95");
        setTimeout(() => modal.classList.add("hidden"), 300);
    }

    function toggleOffer() {
        let acceptBtn = document.getElementById("acceptOfferBtn");
        let index = parseInt(acceptBtn.getAttribute("data-index"));

        if (selectedOfferIndex === index) {
            // ยกเลิกข้อเสนอ
            selectedOfferIndex = null;
            acceptBtn.textContent = "Accept Offer";
            acceptBtn.classList.remove("bg-yellow-500");
            acceptBtn.classList.add("bg-green-500");
            document.getElementById("confirmationText").textContent = "ยกเลิกข้อเสนอเรียบร้อยแล้ว!";
        } else {
            // เลือกข้อเสนอใหม่
            selectedOfferIndex = index;
            acceptBtn.textContent = "Cancel Offer";
            acceptBtn.classList.remove("bg-green-500");
            acceptBtn.classList.add("bg-yellow-500");
            document.getElementById("confirmationText").textContent = "เลือกข้อเสนอเรียบร้อยแล้ว!";
        }

        // แสดง Modal ยืนยัน
        document.getElementById("confirmationModal").classList.remove("hidden");

        // ปิดการใช้งานข้อเสนออื่น ๆ ถ้ามีการเลือกแล้ว
        document.querySelectorAll(".offer-box").forEach((box, i) => {
            let btn = box.querySelector(".offer-btn");
            if (selectedOfferIndex !== null && i !== selectedOfferIndex) {
                box.classList.add("bg-gray-300");
                btn.disabled = true;
            } else {
                box.classList.remove("bg-gray-300");
                btn.disabled = false;
            }
        });
        closeOfferModal();
    }

    function closeConfirmationModal() {
        document.getElementById("confirmationModal").classList.add("hidden");
    }
</script>
</body>
</html>