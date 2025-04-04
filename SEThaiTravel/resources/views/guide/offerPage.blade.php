<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Offer</title>
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
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">OFFER</h2>

            <form action="/guideAddOffer" method="POST">
                @csrf
                <!-- Row 1 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Request Name</label>
                        <input type="text" name="request_name" readonly class="w-full p-2 border rounded shadow-sm"
                            value={{ $requestData->name }}>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Offer Price</label>
                        <input type="number" required name="price" class="w-full p-2 border rounded shadow-sm"
                            value="">
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Start Date</label>
                        <input type="date" name="start_date" readonly class="w-full p-2 border rounded shadow-sm"
                            value="{{ $requestData->start_tour_date }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">End Date</label>
                        <input type="date" name="end_date" readonly class="w-full p-2 border rounded shadow-sm"
                            value="{{ $requestData->end_tour_date }}">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Province</label>
                    <select id="provinceSelect" class="w-full p-2 border rounded shadow-sm" @if ($requestData->hotel_status == "dispensable")
                        {{"disabled"}}
                    @endif >
                        <option value="">Select Province</option>
                    </select>
                </div>
                <!-- Row 3 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel</label>
                        <select name="hotel" id="hotelSelect" class="w-full p-2 border rounded shadow-sm" @if ($requestData->hotel_status == "dispensable")
                            {{"disabled"}}
                        @endif > 
                            <option value="" selected>Select a Hotel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Hotel price</label>
                        <input type="number" name="hotelPrice" min="1" @if ($requestData->hotel_status == "dispensable")
                            {{"readonly"}}
                        @endif
                            class="w-full p-2 border rounded shadow-sm" value="">
                    </div>
                </div>
                <!-- Row 4 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Travel By</label>
                        <input type="text" class="w-full p-2 border rounded shadow-sm" name="travel" value="">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Travel Price</label>
                        <input type="number" class="w-full p-2 border rounded shadow-sm" min="0" name="travel_price" value="">
                    </div>
                </div>

                <!-- Row 5 (Description) -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24"></textarea>
                </div>

                <!-- Row 6 -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Guide Quantity</label>
                        <input type="number" name="quantity" class="w-full p-2 border rounded shadow-sm"
                            value="">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Contact</label>
                        <input type="text" name="contact" class="w-full p-2 border rounded shadow-sm"
                            value="">
                    </div>
                </div>
                
                <div class="flex justify-center mt-6 space-x-4">
                    <!-- ปุ่ม BACK -->
                    <a href="/guideHomePage"
                        class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                        BACK
                    </a>
                    <input type="hidden" name="requestID" value={{$requestData->id_request_tour}}>
                    <!-- ปุ่ม SUBMIT -->
                    <button type="submit"
                        class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">
                        OFFER
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
