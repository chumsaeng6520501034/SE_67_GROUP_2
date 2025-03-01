<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">
    
    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-lg w-[700px]">
        <h2 class="text-4xl font-bold text-center text-[#0F3557]">SIGN UP</h2>
        
         <!-- อัพโหลดรูป -->
         <div class="flex justify-center my-4 relative">
            <label for="imageUpload" class="w-20 h-20 border-4 border-[#0F3557] flex items-center justify-center rounded-full cursor-pointer overflow-hidden">
                <img id="previewImage" src="" class="hidden w-full h-full object-cover" />
                <span id="uploadIcon" class="text-3xl text-[#0F3557]">+</span>
            </label>
            <input type="file" id="imageUpload" class="hidden" accept="image/*">
        </div>

        <form>
            <div class="grid grid-cols-2 gap-1">
                <!-- บรรทัดที่ 1 -->
                <label class="flex flex-col">
                    First Name*
                    <input type="text" name="first_name" class="p-2 border shadow-md rounded">
                </label>
                <label class="flex flex-col">
                    Last Name*
                    <input type="text" name="last_name" class="p-2 border shadow-md rounded">
                </label>
                
                <!-- บรรทัดที่ 2 -->
                <label class="flex flex-col col-span-2">
                    ID Card Number*
                    <input type="text" name="id_card" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 3 -->
                <label class="flex flex-col col-span-2">
                    Address
                    <input type="text" name="address" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 4 -->
                <label class="flex flex-col">
                    District
                    <input type="text" name="district" class="p-2 border shadow-md rounded">
                </label>
                <label class="flex flex-col">
                    Province
                    <input type="text" name="province" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 5 -->
                <label class="flex flex-col">
                    Phone Number
                    <input type="text" name="phone" class="p-2 border shadow-md rounded">
                </label>
                <label class="flex flex-col">
                    Country
                    <input type="text" name="country" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 6 -->
                <label class="flex flex-col">
                    Subdistrict
                    <input type="text" name="subdistrict" class="p-2 border shadow-md rounded">
                </label>
                <label class="flex flex-col">
                    Postal number
                    <input type="text" name="postal" class="p-2 border shadow-md rounded">
                </label>
                
                <!-- บรรทัดที่ 7 -->
                <label class="flex flex-col col-span-2">
                    Name On Card*
                    <input type="text" name="name_on_card" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 8 -->
                <label class="flex flex-col col-span-2">
                    Card number (Credit / Debit)*
                    <input type="text" name="card_number" class="p-2 border shadow-md rounded">
                </label>

                <!-- บรรทัดที่ 9 -->
                <label class="flex flex-col">
                    CVC / CVV*
                    <input type="text" name="cvc" class="p-2 border shadow-md rounded">
                </label>
                <label class="flex flex-col">
                    Expiration date*
                    <input type="text" name="expiry_date" class="p-2 border shadow-md rounded">
                </label>
            </div>

            <!-- ปุ่ม SUBMIT และ ปุ่ม BACK ในแถวเดียวกัน -->
            <div class="flex justify-center mt-6 space-x-4">
                <!-- ปุ่มย้อนกลับ -->
                <a href="#" class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                    BACK
                </a>

                <!-- ปุ่มส่งฟอร์ม -->
                <button type="submit" 
                    class="bg-white text-black font-bold py-2 px-6 rounded shadow-md hover:bg-blue-800 transition">
                    SUBMIT
                </button>
            </div>
        </form>
    </div>
    <!-- JavaScript -->
    <script>
        document.getElementById("imageUpload").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("previewImage").src = e.target.result;
                    document.getElementById("previewImage").classList.remove("hidden");
                    document.getElementById("uploadIcon").classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
