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

    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="grid md:grid-cols-2 gap-6 w-full max-w-6xl px-4 mx-auto">

            <!-- Card ซ้าย: รายละเอียด Request -->
            <div
                class="bg-white bg-opacity-50 backdrop-blur-lg p-8 rounded-2xl shadow-lg w-full  max-h-[95vh] overflow-y-auto">
                <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">รายละเอียด Request</h2>
                <div class="text-sm space-y-2">
                    <p><span class="font-semibold">Request Name:</span> {{ $requestTour->name }}</p>
                    <p><span class="font-semibold">Start Request Date:</span> {{ $requestTour->request_date }}</p>
                    <p><span class="font-semibold">End Request Date:</span> {{ $requestTour->end_of_request_date }}</p>
                    <p><span class="font-semibold">Start Tour:</span> {{ $requestTour->start_tour_date }}</p>
                    <p><span class="font-semibold">End Tour:</span> {{ $requestTour->end_tour_date }}</p>
                    <p><span class="font-semibold">MAX Price:</span> {{ $requestTour->max_price }}</p>
                    <p><span class="font-semibold">Start Price:</span> {{ $requestTour->start_price }}</p>
                    <p><span class="font-semibold">Size Tour:</span> {{ $requestTour->size_tour }}</p>
                    <p><span class="font-semibold">Quantity Guide:</span> {{ $requestTour->guide_qty }}</p>
                    <p><span class="font-semibold">Description:</span> {{ $requestTour->description }}</p>
                </div>
            </div>

            <!-- Card ขวา: Add Offer -->
            <div
                class="bg-white bg-opacity-50 backdrop-blur-lg p-10 rounded-2xl shadow-lg w-full  max-h-[95vh] overflow-y-auto">
                <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">OFFER</h2>

                <form action="/corpAddOffer" method="POST">
                    @csrf

                    <!-- Row 1 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Request Name</label>
                            <input type="text" name="request_name" readonly class="w-full p-2 border rounded shadow-sm"
                                value="{{ $requestTour->name }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Offer Price</label>
                            <input type="number" required name="price" class="w-full p-2 border rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Start Date</label>
                            <input type="date" name="start_date" readonly class="w-full p-2 border rounded shadow-sm"
                                value="{{ $requestTour->start_tour_date }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">End Date</label>
                            <input type="date" name="end_date" readonly class="w-full p-2 border rounded shadow-sm"
                                value="{{ $requestTour->end_tour_date }}">
                        </div>
                    </div>

                    <!-- Province -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Province</label>
                        <select id="provinceSelect" class="w-full p-2 border rounded shadow-sm" @if ($requestTour->hotel_status == "dispensable") disabled @endif>
                            <option value="">Select Province</option>
                        </select>
                    </div>

                    <!-- Hotel and Price -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Hotel</label>
                            <select name="hotel" id="hotelSelect" class="w-full p-2 border rounded shadow-sm" @if ($requestTour->hotel_status == "dispensable") disabled @endif>
                                <option value="" selected>Select a Hotel</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Hotel Price</label>
                            <input type="number" name="hotel_price" min="1" @if ($requestTour->hotel_status == "dispensable") readonly @endif class="w-full p-2 border rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Travel -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Travel By</label>
                            <input type="text" name="travel" class="w-full p-2 border rounded shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Travel Price</label>
                            <input type="number" name="travel_price" class="w-full p-2 border rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24"></textarea>
                    </div>

                    <!-- Quantity & Contact -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Guide Quantity</label>
                            <input type="number" name="guide_qty" class="w-full p-2 border rounded shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Contact</label>
                            <input type="text" name="contect" class="w-full p-2 border rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Submit -->
                    <input type="hidden" name="request_tourID" value="{{ $requestTour->id_request_tour }}">
                    <div class="flex justify-center gap-4 mt-4">
                        <a href="/corpHomePage"
                            class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">BACK</a>
                            <input type="hidden" name="request_tourID" value={{$requestTour->id_request_tour}}>
                            <button type="submit"
                            class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">OFFER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
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

        $(document).ready(function () {
            $('#provinceSelect').select2({
                placeholder: "Select a province",
                allowClear: true
            });

            $('#hotelSelect').select2({
                placeholder: "Select a Hotel",
                allowClear: true
            });

            $('#provinceSelect').on('change', function () {
                const provinceId = $(this).val();
                const hotelSelect = document.getElementById('hotelSelect');
                hotelSelect.innerHTML = '<option value="">Select a Hotel</option>';
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
</body>

</html>
