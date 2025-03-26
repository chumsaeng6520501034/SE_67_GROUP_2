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
          <p><span class="font-semibold">Request Name:</span>{{ $requestTour-> name}}</p>
          <p><span class="font-semibold">Start Request Date:</span> {{ $requestTour-> request_date}}</p>
          <p><span class="font-semibold">End Request Date:</span>{{ $requestTour-> end_of_request_date}} </p>
          
          <p><span class="font-semibold">Start Tour:</span>{{ $requestTour-> start_tour_date}}</p>
          <p><span class="font-semibold">End Tour:</span>{{ $requestTour->end_tour_date }}</p>

          <p><span class="font-semibold">MAX Price:</span>{{ $requestTour->max_price}}</p>
          <p><span class="font-semibold">Start Price:</span>{{ $requestTour->start_price}}</p>

          <p><span class="font-semibold">Size Tour:</span>{{ $requestTour->size_tour}} </p>
          <p><span class="font-semibold">Quantity Guide:</span>{{ $requestTour-> guide_qty}} </p>

          <p><span class="font-semibold">Description:</span>{{ $requestTour-> description}} </p>
        </div>
      </div>

      <!-- Card ขวา: ADD OFFER -->
      <div class="bg-white bg-opacity-80 backdrop-blur-md p-10 rounded-2xl shadow-lg w-full md:w-[600px] max-h-[95vh] overflow-y-auto">
        <h2 class="text-center text-3xl md:text-4xl font-bold text-[#002D62] mb-6">ADD OFFER</h2>

        <form action="/corpAddOffer" method="POST" enctype="multipart/form-data" class="space-y-4">
          @csrf

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Travel By*</label>
              <input type="text" name="travel" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">Travel Price*</label>
              <input type="number" name="travel_price" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Hotel*</label>
              <input type="text" name="hotel" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">Hotel Price*</label>
              <input type="number" name="hotel_price" class="w-full p-2 border rounded shadow-sm">
              <input type="hidden" name="request_tourID" value={{$requestTour-> id_request_tour}}>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
          <div>
              <label class="block text-sm font-medium">Quanty Guide*</label>
              <input type="number" name="guide_qty" class="w-full p-2 border rounded shadow-sm">
            </div>
            <div>
              <label class="block text-sm font-medium">Price*</label>
              <input type="number" name="price" class="w-full p-2 border rounded shadow-sm">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Contact*</label>
              <input type="text" name="contect" class="w-full p-2 border rounded shadow-sm">
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
