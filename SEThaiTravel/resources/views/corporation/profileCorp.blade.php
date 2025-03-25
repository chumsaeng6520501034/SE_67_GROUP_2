<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-cover bg-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">

  <!-- 🔵 TOP NAV BAR -->
  <div class="bg-blue-800 text-white px-6 py-3 flex items-center">
    <button onclick="history.back()" class="text-2xl mr-3">&larr;</button>
    <span class="text-lg font-bold">PROFILE</span>
    </div>

  <!-- 🔲 Profile Content -->
  <div class="min-h-screen flex flex-col items-center justify-start p-6 bg-blue bg-opacity-30">

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-5xl mt-6">

      <!-- Avatar -->
      <label class="relative -mt-16 flex flex-col items-center bg-blue">
                <img id="profileImage"
                    src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg"
                    alt="Profile Picture"
                    class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                <!-- <input type="file" id="profile-upload" class="hidden" accept="image/*"> -->
        </label>

      <!-- Basic Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-black">
        <div class="bg-white p-4 shadow-md rounded-md">
          <p><span class="font-bold">Name :</span> [ชื่อบริษัท]</p>
          <p><span class="font-bold">E-mail :</span> [บริษัทemail@example.com]</p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-md">
          <p><span class="font-bold">Owner name :</span> [ชื่อเจ้าของ]</p>
          <p><span class="font-bold">Phone :</span> [08x-xxx-xxxx]</p>
        </div>
      </div>

      <!-- Address & Guide -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 text-black">
        <div>
          <p class="font-bold mb-2">Address :</p>
          <div class="bg-white p-4 shadow-md rounded-md h-32 overflow-y-auto">
            [ที่อยู่บริษัทแสดงตรงนี้ เช่น บ้านเลขที่ แขวง/ตำบล เขต/อำเภอ จังหวัด รหัสไปรษณีย์]
          </div>
        </div>
        <div>
          <p class="font-bold mb-2">Guide in Corporation :</p>
          <div class="bg-white p-4 shadow-md rounded-md h-32 overflow-y-auto">
            [ชื่อไกด์หรือรายชื่อไกด์ที่ทำงานกับบริษัท
