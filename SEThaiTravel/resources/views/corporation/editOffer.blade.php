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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-6xl px-4">
            <div
            class="bg-white bg-opacity-50 backdrop-blur-lg p-10 rounded-2xl shadow-lg my-5 max-h-[95vh] overflow-y-auto">
                <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">รายละเอียด Request</h2>
                <div class="text-sm space-y-2">
                    <p><span class="font-semibold">Request Name:</span> {{ $offerData->name }}</p>
                    <p><span class="font-semibold">Start Request Date:</span> {{ $offerData->request_date }}</p>
                    <p><span class="font-semibold">End Request Date:</span> {{ $offerData->end_of_request_date }}</p>
                    <p><span class="font-semibold">Start Tour:</span> {{ $offerData->start_tour_date }}</p>
                    <p><span class="font-semibold">End Tour:</span> {{ $offerData->end_tour_date }}</p>
                    <p><span class="font-semibold">MAX Price:</span> {{ $offerData->max_price }}</p>
                    <p><span class="font-semibold">Start Price:</span> {{ $offerData->start_price }}</p>
                    <p><span class="font-semibold">Size Tour:</span> {{ $offerData->size_tour }}</p>
                    <p><span class="font-semibold">Quantity Guide:</span> {{ $offerData->guide_qty }}</p>
                    <p><span class="font-semibold">Description:</span> {{ $offerData->description }}</p>
                </div>
            </div>
            <!-- กล่องเนื้อหาที่อาจยาวจนต้อง scroll -->
            <div
                class="bg-white bg-opacity-50 backdrop-blur-lg p-10 rounded-2xl shadow-lg ] my-5 max-h-[95vh] overflow-y-auto">
                <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">EDIT OFFER</h2>

                <form action="/corpUpdateOffer" method="POST">
                    @csrf
                    <!-- Row 1 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Request Name</label>
                            <input type="text" name="request_name" readonly
                                class="w-full p-2 border rounded shadow-sm" value={{ $offerData->name }}>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Price*</label>
                            <input type="number" name="price" class="w-full p-2 border rounded shadow-sm"
                                value={{ $offerData->price }}>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Start Date</label>
                            <input type="date" name="start_date" readonly class="w-full p-2 border rounded shadow-sm"
                                value="{{ $offerData->start_tour_date }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">End Date</label>
                            <input type="date" name="end_date" readonly class="w-full p-2 border rounded shadow-sm"
                                value="{{ $offerData->end_tour_date }}">
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
                                class="w-full p-2 border rounded shadow-sm" value={{ $offerData->hotel_price }}>
                        </div>
                    </div>
                    <!-- Row 4 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Travel By</label>
                            <input type="text" class="w-full p-2 border rounded shadow-sm" name="travel"
                                value={{ $offerData->travel }}>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Travel Price</label>
                            <input type="number" class="w-full p-2 border rounded shadow-sm" name="travel_price"
                                value={{ $offerData->travel_price }}>
                        </div>
                    </div>

                    <!-- Row 5 (Description) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24">{{ $offerData->description }}</textarea>
                    </div>

                    <!-- Row 6 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Guide Quantity</label>
                            <input type="number" name="quantity" class="w-full p-2 border rounded shadow-sm"
                                value="{{ $offerData->guide_qty }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Contact</label>
                            <input type="text" name="contact" class="w-full p-2 border rounded shadow-sm"
                                value="{{ $offerData->contect }}">
                        </div>
                    </div>

                    <div class="flex justify-center mt-6 space-x-4">
                        <!-- ปุ่ม BACK -->
                        <a href="/corpOffer"
                            class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                            BACK
                        </a>
                        <input type="hidden" name="offerID" value={{ $offerData->id_offer }}>
                        <!-- ปุ่ม SUBMIT -->
                        <button type="submit"
                            class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">
                            UPDATE OFFER
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const selectedProvinceId = @json($provinceId);
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
            const hotelName = @json($getHotel);
            if (!(hotelName === null)) {
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

            $('#provinceSelect').on('change', function() {
                const provinceId = $(this).val();
                console.log("🌈 Province changed:", provinceId); // ต้องโชว์!
                const hotelSelect = document.getElementById('hotelSelect');
                if (!provinceId) return;
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
