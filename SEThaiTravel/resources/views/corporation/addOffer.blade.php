<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Offer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative w-full h-screen bg-cover bg-center"
  style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">

  <!-- พื้นหลังดำบาง -->
  <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
    <!-- กรอบ 2 คอลัมน์ -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-6xl px-4">

      <!-- Card ซ้าย: รายละเอียด Request -->
      <div class="bg-white bg-opacity-80 backdrop-blur-md p-8 rounded-2xl shadow-lg w-full md:w-[600px] max-h-[95vh] overflow-y-auto">
        <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">รายละเอียด Request</h2>
        <div class="text-sm space-y-2">
          <p><span class="font-semibold">Request Name:</span> เที่ยวทะเลพังงา</p>
          <p><span class="font-semibold">Start Date:</span> 2025-04-01</p>
          <p><span class="font-semibold">End Date:</span> 2025-04-05</p>
          <p><span class="font-semibold">Quantity Guide:</span> 2</p>
          <p><span class="font-semibold">Hotel Required:</span> ใช่</p>
          <p><span class="font-semibold">Preferred Location:</span> เขาหลัก, หาดบางเนียง</p>
          <p><span class="font-semibold">Note:</span> ต้องการไกด์พูดอังกฤษได้</p>
        </div>
      </div>

      <!-- Card ขวา: ADD OFFER -->
      <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-full md:w-[600px] max-h-[95vh] overflow-y-auto">
        <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">ADD OFFER</h2>

        <form action="/corpAddTour" method="POST" enctype="multipart/form-data" class="space-y-4">
          @csrf
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Tour Name*</label>
              <input type="text" name="tour_name" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">Contact*</label>
              <input type="text" name="contact" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Start Date*</label>
              <input type="date" name="start_date" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">End Date*</label>
              <input type="date" name="end_date" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Hotel*</label>
              <select name="hotel" class="w-full p-2 border rounded shadow-sm">
                <option value="">Select a Hotel</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium">Hotel Price*</label>
              <input type="number" name="hotelPrice" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Quantity*</label>
              <input type="number" name="quantity" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">Price*</label>
              <input type="number" name="price" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full p-2 border rounded shadow-sm"></textarea>
          </div>

          <div class="flex justify-center gap-4">
            <a href="/corpHomepage" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">BACK</a>
            <button type="submit" class="bg-[#0F3557] text-white px-6 py-2 rounded hover:bg-blue-700">ADD OFFER</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
