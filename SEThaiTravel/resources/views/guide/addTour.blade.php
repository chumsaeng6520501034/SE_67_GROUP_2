<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tour</title>
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
            class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-[600px] my-5 max-h-[90vh] overflow-y-auto">
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">ADD TOUR</h2>

            <form>
                <!-- Row 1 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Tour Name*</label>
                        <input type="text" name="tour_name" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Price*</label>
                        <input type="number" name="price" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Start Date*</label>
                        <input type="date" name="start_date" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">End Date*</label>
                        <input type="date" name="end_date" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Province</label>
                    <select id="provinceSelect" class="w-full p-2 border rounded shadow-sm">
                        <option value="">Select Province</option>
                    </select>
                </div>
                <!-- Row 3 -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Hotel</label>
                    <select name="hotel" id="hotelSelect" class="w-full p-2 border rounded shadow-sm">
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Location in Tour</label>
                    <select id="locationSelect" name="location[]" class="w-full p-2 border rounded shadow-sm">
                    </select>
                    <div id="selectedLocations" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <!-- Row 4 -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Travel By</label>
                    <select name="travel_by" class="w-full p-2 border rounded shadow-sm">
                        <option>BUS</option>
                        <option>TAXI</option>
                        <option>CAR</option>
                    </select>
                </div>

                <!-- Row 5 (Description) -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24"></textarea>
                </div>

                <!-- Row 6 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Quantity</label>
                        <input type="number" name="quantity" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Contact</label>
                        <input type="text" name="contact" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded shadow-lg text-lg hover:bg-blue-800 transition">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/api/provinces')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('provinceSelect');
                    if (data && data.length > 0) {
                        data.forEach(province => {
                            let option = document.createElement('option');
                            option.value = province.id;
                            option.textContent = province.name;
                            select.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching provinces:', error));
        });
        const locationSelect = document.getElementById('locationSelect');
        const selectedContainer = document.getElementById('selectedLocations');
        const selectedLocations = [];

        function loadLocations(provinceId) {
            locationSelect.innerHTML = '';

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
                hotelSelect.innerHTML = '';
                console.log("1");
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
</body>

</html>
