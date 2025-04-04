<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">
    
    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-[900px]">
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">Edit Request</h2>
            <form action="/editAdd" method="POST">
                @csrf

                <input type="hidden" name="requestID" value="{{ $edit->id_request_tour }}">

                <!-- Row 1 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Tour Name*</label>
                        <input type="text" name="nameRequest" value="{{ $edit->name }}" 
                               class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Minimum Price*</label>
                        <input type="number" name="startPrice" value="{{ $edit->start_price }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Maximum Price*</label>
                        <input type="number" name="maxPrice" value="{{ $edit->max_price }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Start Date*</label>
                        <input type="date" name="startTourDate" value="{{ $edit->start_tour_date }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">End Date*</label>
                        <input type="date" name="endTourDate" value="{{ $edit->end_tour_date }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Quantity Of Guide</label>
                        <input type="number" name="guideQty" value="{{ $edit->guide_qty }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="col-span-3">
                        <label class="block text-gray-700 font-medium">Contact</label>
                        <input type="text" name="contect" value="{{ $edit->contect }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Quantity Of People*</label>
                        <input type="number" name="sizeTour" value="{{ $edit->size_tour }}" class="w-full p-2 border rounded shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Travel Status*</label>
                        <select name="travelStatus" class="w-full p-2 border rounded shadow-sm">
                            <option value="mandatory" {{ $edit->travel_status == 'mandatory' ? 'selected' : '' }}>MUST HAVE</option>
                            <option value="desirable" {{ $edit->travel_status == 'desirable' || $edit->travel_status == 'optional' ? 'selected' : '' }}>MAY BE</option>
                            <option value="dispensable" {{ $edit->travel_status == 'dispensable' ? 'selected' : '' }}>MUST NOT HAVE</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Hotel Status*</label>
                        <select name="hotelStatus" class="w-full p-2 border rounded shadow-sm">
                            <option value="mandatory" {{ $edit->hotel_status == 'mandatory' ? 'selected' : '' }}>MUST HAVE</option>
                            <option value="desirable" {{ $edit->hotel_status == 'desirable' || $edit->hotel_status == 'optional' ? 'selected' : '' }}>MAY BE</option>
                            <option value="dispensable" {{ $edit->hotel_status == 'dispensable' ? 'selected' : '' }}>MUST NOT HAVE</option>
                        </select>
                    </div>
                </div>

                <!-- Row 5 (Description) -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded shadow-sm h-24" required>{{ $edit->description }}</textarea>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow-lg text-lg hover:bg-blue-800 transition">
                        UPDATE
                    </button>
                    <button type="button" onclick="window.history.back();" class="bg-gray-500 text-white px-6 py-2 rounded shadow-lg text-lg hover:bg-gray-700 transition ml-4">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
