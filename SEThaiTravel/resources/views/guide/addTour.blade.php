<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tour</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">
    
    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-[600px]">
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

                <!-- Row 3 -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Hotel</label>
                    <select name="hotel" class="w-full p-2 border rounded shadow-sm">
                        <option>Hotel1</option>
                        <option>Hotel2</option>
                    </select>
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
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow-lg text-lg hover:bg-blue-800 transition">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
