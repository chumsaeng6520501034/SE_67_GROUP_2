<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit Tour</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<body class="relative w-full h-screen bg-cover bg-center"
    style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">

    <!-- Wrapper ที่ควบคุม scroll ได้ -->
    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <!-- กล่องเนื้อหาที่อาจยาวจนต้อง scroll -->
        <div
            class="bg-white bg-opacity-50 backdrop-blur-lg p-10 rounded-2xl shadow-lg w-[900px] my-5 max-h-[90vh] overflow-y-auto">
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">EDIT TOUR</h2>

            <form action="/guideEditTour" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Row 1 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Tour Name*</label>
                        <input type="text" name="tour_name" class="w-full p-2 border rounded shadow-sm"
                            value={{ $tourData->name }}>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Price*</label>
                        <input type="number" name="price" class="w-full p-2 border rounded shadow-sm"
                            value={{ $tourData->price }}>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Start Date*</label>
                        <input type="date" name="start_date" class="w-full p-2 border rounded shadow-sm"
                            value="{{ $tourData->start_tour_date }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">End Date*</label>
                        <input type="date" name="end_date" class="w-full p-2 border rounded shadow-sm"
                            value="{{ $tourData->end_tour_date }}">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Province</label>
                    <select id="provinceSelect" class="w-full p-2 border rounded shadow-sm">
                        <option value="">Select Province</option>
                    </select>
                </div>
                <!-- Row 3 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel</label>
                        <select name="hotel" id="hotelSelect" class="w-full p-2 border rounded shadow-sm">
                            <option value="" selected>Select a Hotel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel price</label>
                        <input type="number" name="hotelPrice" min="1"
                            class="w-full p-2 border rounded shadow-sm" value="{{ $tourData->hotel_price }}">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Location in Tour</label>
                    <select id="locationSelect" name="location[]"class="w-full p-2 border rounded shadow-sm">
                    </select>
                    <div id="selectedLocations" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <!-- Row 4 -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Travel By</label>
                    <select name="travel_by" class="w-full p-2 border rounded shadow-sm">
                        <option @if ($tourData->travel_by == 'BUS') {{ 'selected' }} @endif value="BUS">BUS</option>
                        <option @if ($tourData->travel_by == 'TAXI') {{ 'selected' }} @endif value="TAXI">TAXI
                        </option>
                        <option @if ($tourData->travel_by == 'CAR') {{ 'selected' }} @endif value="CAR">CAR</option>
                    </select>
                </div>

                <!-- ✅ เลือกไกด์แบบ tag แสดงด้านล่าง -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Guide</label>
                    <select id="guideSelect" name="guideintour[]" class="w-full p-2 border rounded shadow-sm">
                    </select>
                    <div id="selectedGuides" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <!-- Row 5 (Description) -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24">{{ $tourData->description }}</textarea>
                </div>

                <!-- Row 6 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Quantity</label>
                        <input type="number" name="quantity" class="w-full p-2 border rounded shadow-sm"
                            value="{{ $tourData->tour_capacity }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Contact</label>
                        <input type="text" name="contact" class="w-full p-2 border rounded shadow-sm"
                            value="{{ $tourData->contect }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Image</label>
                    <input type="file" id="imageInput" name="image" class="w-full p-2 border rounded shadow-sm" >
                </div>

                <div class="mt-2">
                    @if (is_null($tourData->tourImage))
                        <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp"
                            alt="Bangkok" class="w-full object-cover mt-2" id="imagePreview">
                    @else
                        <img src="{{ asset('storage/' . $tourData->tourImage) }}" alt="image"
                            class="w-full object-cover mt-2" id="imagePreview">
                    @endif
                </div>

                <div class="flex justify-center mt-6 space-x-4">
                    <!-- ปุ่ม BACK -->
                    <a href="/guideMyTour"
                        class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                        BACK
                    </a>
                    <input type="hidden" name="Release" value="{{$tourData->Release_date}}">
                    <input type="hidden" name="End" value="{{$tourData->End_of_sale_date}}">
                    <input type="hidden" name="tourID" value="{{$tourData->id_tour}}">
                    <input type="hidden" name="tourImage" value="{{$tourData->tourImage}}">
                    <!-- ปุ่ม SUBMIT -->
                    <button type="submit"
                        class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">
                        UPDATE TOUR
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const locationSelect = document.getElementById('locationSelect');
        const selectedContainer = document.getElementById('selectedLocations');
        let selectedLocations = [];
        $(locationSelect).select2();
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/api/provinces')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('provinceSelect');
                    const selectedProvinceId = @json($provinceId);
                    if (data && data.length > 0) {
                        data.forEach(province => {
                            let option = document.createElement('option');
                            option.value = province.id;
                            option.textContent = province.name;
                            if (province.id === selectedProvinceId) {
                                option.selected = true;
                            }
                            select.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching provinces:', error));
            const hotelSelected = document.getElementById('hotelSelect');
            const hotelName = @json($tourData->hotel);
            fetch(`/api/hotelsInprovince/${@json($provinceId)}`)
                .then(res => res.json())
                .then(data => {
                    data.data.forEach(hotel => {
                        const option = document.createElement('option');
                        option.value = hotel.name;
                        option.textContent = hotel.name;
                        if (option.value === hotelName) {
                            option.selected = true;
                        }
                        hotelSelected.appendChild(option);
                    });
                });
            const locationsSelected = @json($locations);
            console.log(locationsSelected);
            fetch(`/api/locationsInprovince/${@json($provinceId)}`)
                .then(res => res.json())
                .then(locations => {
                    locations.data.forEach(loc => {
                        const option = document.createElement('option');
                        option.value = loc.placeId;
                        option.textContent = loc.name;
                        locationSelect.appendChild(option);
                        locationsSelected.forEach(location => {
                            const selectedId = parseInt(location.original.placeId);
                            const selectedName = loc.name;
                            if (option.value === location.original.placeId) {
                                selectedLocations.push({
                                    id: selectedId,
                                    name: selectedName
                                });
                                const optionToDisable = locationSelect.querySelector(
                                    `option[value="${selectedId}"]`);
                                if (optionToDisable) {
                                    optionToDisable.disabled = true;
                                }
                            }
                        });
                    });
                    selectedLocations = selectedLocations.filter(item => !isNaN(item.id));
                    updateSelectedLocations();
                    locationSelect.value = ''; // รีเซ็ตค่า select
                    console.log(selectedLocations);
                })
                .catch(err => {
                    console.error('❌ error loading locations:', err);
                    locationSelect.innerHTML = '<option disabled>โหลดไม่สำเร็จ</option>';
                });
        });

        function loadLocations(provinceId) {

            fetch(`/api/locationsInprovince/${provinceId}`)
                .then(res => res.json())
                .then(locations => {
                    locations.data.forEach(loc => {
                        const option = document.createElement('option');
                        option.value = loc.placeId;
                        option.textContent = loc.name;
                        locationSelect.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error('❌ error loading locations:', err);
                    locationSelect.innerHTML = '<option disabled>โหลดไม่สำเร็จ</option>';
                });
        }


        function updateSelectedLocations() {
            selectedContainer.innerHTML = '';
            selectedLocations.forEach((loc, index) => {
                const tag = document.createElement('div');
                tag.className = 'flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full shadow text-sm';
                tag.innerHTML = `
            <span class="mr-2">${loc.name}</span>
            <button onclick="removeLocation(${index})" class="text-blue-600 hover:text-red-600">&times;</button>
            <input type="hidden" name="location[]" value="${loc.id}">
        `;
                selectedContainer.appendChild(tag);
            });
        }

        function removeLocation(index) {
            const removed = selectedLocations.splice(index, 1)[0];
            updateSelectedLocations();
            $(`#locationSelect option[value="${removed.id}"]`).prop('disabled', false);
        }
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // ใช้ FileReader เพื่อแสดงตัวอย่างภาพที่เลือก
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file); // อ่านไฟล์เป็น data URL
            }
        });

        $(document).ready(function() {
            console.log("✅ jQuery ready");

            $('#provinceSelect').select2({
                placeholder: "Select a province",
                allowClear: true
            });

            $('#hotelSelect').select2({
                placeholder: "Select a Hotel",
                allowClear: true
            });
            $('#locationSelect').select2({
                placeholder: "Select a Location",
                allowClear: true
            });

            $('#provinceSelect').on('change', function() {
                const provinceId = $(this).val();
                console.log("🌈 Province changed:", provinceId); // ต้องโชว์!
                const hotelSelect = document.getElementById('hotelSelect');
                if (!provinceId) return;
                selectedLocations.length = 0; // เคลียร์รายการเก่าที่เลือกไว้
                updateSelectedLocations(); // เคลียร์แท็กที่แสดง
                loadLocations(provinceId); // โหลดสถานที่ใหม่
                fetch(`/api/hotelsInprovince/${provinceId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.data.forEach(hotel => {
                            const option = document.createElement('option');
                            option.value = hotel.name;
                            option.textContent = hotel.name;
                            hotelSelect.appendChild(option);
                        });
                    });
            });
            $('#locationSelect').on('change', function() {
                const selectedId = parseInt($(this).val());
                const selectedName = $(this).find('option:selected').text();

                if (!selectedLocations.find(loc => loc.id === selectedId)) {
                    selectedLocations.push({
                        id: selectedId,
                        name: selectedName
                    });
                    updateSelectedLocations();
                    $(this).find(`option[value="${selectedId}"]`).prop('disabled', true);
                }

                // รีเซ็ตค่าหลังเลือก (โดยไม่ trigger change ซ้ำ)
                $(this).val('').trigger('change.select2'); // ถ้าใช้ select2
                // หรือ $(this).val(''); // ถ้าใช้ select ธรรมดา
            });

            

        });
        
    </script>
    <!-- Custom Scrollbar -->
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
    <!-- JavaScript Guide (ต่อท้ายสุดของหน้า แยกจากสคริปต์เดิมเลย) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const guideSelect = document.getElementById('guideSelect');
    const selectedGuidesContainer = document.getElementById('selectedGuides');

    // ข้อมูล guide ที่ได้จาก Controller
    const guideintour = @json($guideintour);

    // เพิ่ม option และแสดงผล guide ที่มีอยู่
    guideintour.forEach(guide => {
        const option = document.createElement('option');
        option.value = guide.account_id_account;
        option.textContent = guide.name + ' ' + guide.surname;
        option.selected = true;
        guideSelect.appendChild(option);

        // เพิ่ม tag ด้านล่าง select
        const tag = document.createElement('div');
        tag.className = 'flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full shadow text-sm';
        tag.innerHTML = `
            <span class="mr-2">${guide.name} ${guide.surname}</span>
            <button type="button" onclick="removeGuide(${guide.account_id_account})" class="text-green-600 hover:text-red-600">&times;</button>
            <input type="hidden" name="guideintour[]" value="${guide.account_id_account}">
        `;
        selectedGuidesContainer.appendChild(tag);
    });

    // เรียก select2 เพื่อความสวยงามและใช้ง่าย
    $('#guideSelect').select2({
        placeholder: "Select a Guide",
        allowClear: true
    });

    // เมื่อมีการเลือกไกด์ใหม่
    $('#guideSelect').on('change', function() {
        const selectedId = $(this).val();
        const selectedName = $(this).find('option:selected').text();

        if (selectedId) {
            const tag = document.createElement('div');
            tag.className = 'flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full shadow text-sm';
            tag.innerHTML = `
                <span class="mr-2">${selectedName}</span>
                <button type="button" onclick="removeGuide(${selectedId})" class="text-green-600 hover:text-red-600">&times;</button>
                <input type="hidden" name="guideintour[]" value="${selectedId}">
            `;
            selectedGuidesContainer.appendChild(tag);
        }

        // reset select2
        $(this).val('').trigger('change.select2');
    });

});

// ฟังก์ชันลบ tag ไกด์ที่เลือก
function removeGuide(guideId) {
    const selectedGuidesContainer = document.getElementById('selectedGuides');
    const tags = selectedGuidesContainer.querySelectorAll('div');
    tags.forEach(tag => {
        if (tag.querySelector(`input[value="${guideId}"]`)) {
            tag.remove();
        }
    });

    // เอาออกจาก select option
    $(`#guideSelect option[value="${guideId}"]`).prop('selected', false);
}
</script>

</body>

</html>
