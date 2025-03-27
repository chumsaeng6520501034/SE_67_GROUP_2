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

    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-[600px] my-5 max-h-[90vh] overflow-y-auto">
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">ADD TOUR</h2>

            <form action="/corpAddTour" method="POST" enctype="multipart/form-data">
                @csrf

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
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel</label>
                        <select name="hotel" id="hotelSelect" class="w-full p-2 border rounded shadow-sm">
                            <option value="" selected>Select a Hotel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel price</label>
                        <input type="number" name="hotelPrice" min="1" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Location in Tour</label>
                    <select id="locationSelect" class="w-full p-2 border rounded shadow-sm"></select>
                    <div id="selectedLocations" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <!-- Travel -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Travel By</label>
                    <select name="travel_by" class="w-full p-2 border rounded shadow-sm">
                        <option>BUS</option>
                        <option>TAXI</option>
                        <option>CAR</option>
                    </select>
                </div>

                <!-- ✅ เลือกไกด์แบบ tag แสดงด้านล่าง -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Guide</label>
                    <select id="guideSelect" class="w-full p-2 border rounded shadow-sm">
                        <option value="">Select a Guide</option>
                        @foreach ($guides as $guide)
                            <option value="{{ $guide->account_id_account }}">{{ $guide->name }} {{ $guide->surname }}</option>
                        @endforeach
                    </select>
                    <div id="selectedGuides" class="mt-3 flex flex-wrap gap-2"></div>
                </div>


                <!-- Description -->
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

                <!-- Image -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Image</label>
                    <input type="file" name="image" class="w-full p-2 border rounded shadow-sm">
                </div>

                
                <!-- ปุ่ม -->
                <div class="flex justify-center mt-6 space-x-4">
                    <a href="/corpHomepage" class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                        BACK
                    </a>
                    <button type="submit" class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">
                        ADD TOUR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/api/provinces')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('provinceSelect');
                    data.forEach(province => {
                        let option = document.createElement('option');
                        option.value = province.id;
                        option.textContent = province.name;
                        select.appendChild(option);
                    });
                });

            const locationSelect = document.getElementById('locationSelect');
            const selectedContainer = document.getElementById('selectedLocations');
            const selectedLocations = [];

            // ================== Guide Selection ====================
            const selectedGuides = [];

            function updateSelectedGuides() {
                const container = document.getElementById('selectedGuides');
                container.innerHTML = '';
                selectedGuides.forEach((guide, index) => {
                    const tag = document.createElement('div');
                    tag.className = 'flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full shadow text-sm';
                    tag.innerHTML = `
                        <span class="mr-2">${guide.name}</span>
                        <button onclick="removeGuide(${index})" class="text-blue-600 hover:text-red-600">&times;</button>
                        <input type="hidden" name="guideList[]" value="${guide.id}">
                    `;
                    container.appendChild(tag);
                });
            }

            function removeGuide(index) {
                const removed = selectedGuides.splice(index, 1)[0];
                updateSelectedGuides();
                $(`#guideSelect option[value="${removed.id}"]`).prop('disabled', false);
            }

            $('#guideSelect').on('change', function () {
                const selectedId = $(this).val();
                const selectedName = $(this).find('option:selected').text();

                if (selectedId && !selectedGuides.find(g => g.id == selectedId)) {
                    selectedGuides.push({ id: selectedId, name: selectedName });
                    updateSelectedGuides();
                    $(this).find(`option[value="${selectedId}"]`).prop('disabled', true);
                }

                $(this).val('');
            });


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

            function loadLocations(provinceId) {
                fetch(`/api/locationsInprovince/${provinceId}`)
                    .then(res => res.json())
                    .then(locations => {
                        locationSelect.innerHTML = '';
                        locations.data.forEach(loc => {
                            const option = document.createElement('option');
                            option.value = loc.placeId;
                            option.textContent = loc.name;
                            locationSelect.appendChild(option);
                        });
                    });
            }

            // ✅ jQuery + Select2
            $(document).ready(function () {
                $('#provinceSelect').select2({ placeholder: "Select a Province", allowClear: true });
                $('#hotelSelect').select2({ placeholder: "Select a Hotel", allowClear: true });
                $('#locationSelect').select2({ placeholder: "Select a Location", allowClear: true });
                $('#guideSelect').select2({ placeholder: "Select Guides", allowClear: true });

                $('#provinceSelect').on('change', function () {
                    const provinceId = $(this).val();
                    const hotelSelect = document.getElementById('hotelSelect');
                    if (!provinceId) return;
                    selectedLocations.length = 0;
                    updateSelectedLocations();
                    loadLocations(provinceId);

                    fetch(`/api/hotelsInprovince/${provinceId}`)
                        .then(res => res.json())
                        .then(data => {
                            hotelSelect.innerHTML = '';
                            data.data.forEach(hotel => {
                                const option = document.createElement('option');
                                option.value = hotel.name;
                                option.textContent = hotel.name;
                                hotelSelect.appendChild(option);
                            });
                        });
                });

                $('#locationSelect').on('change', function () {
                    const selectedId = parseInt($(this).val());
                    const selectedName = $(this).find('option:selected').text();

                    if (!selectedLocations.find(loc => loc.id === selectedId)) {
                        selectedLocations.push({ id: selectedId, name: selectedName });
                        updateSelectedLocations();
                        $(this).find(`option[value="${selectedId}"]`).prop('disabled', true);
                    }
                    $(this).val('').trigger('change.select2');
                });
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
