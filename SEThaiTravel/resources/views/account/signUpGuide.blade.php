<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        /* Custom Scrollbar */
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
</head>

<body class="relative w-full h-screen bg-cover bg-center flex items-center justify-center" 
    style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">
    
    <div class="bg-[#e0f7fa] bg-opacity-95 backdrop-blur-md p-6 rounded-2xl shadow-lg w-[90%] max-w-3xl mx-4 overflow-y-auto max-h-[90vh]">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-[#0F3557] mb-4">SIGN IN</h2>

        <!-- อัพโหลดรูป -->
        <div class="flex justify-center my-4">
            <label for="imageUpload" class="w-20 h-20 border-4 border-[#0F3557] flex items-center justify-center rounded-full cursor-pointer overflow-hidden">
                <img id="previewImage" src="" class="hidden w-full h-full object-cover" />
                <span id="uploadIcon" class="text-3xl text-[#0F3557]">+</span>
            </label>
            <input type="file" id="imageUpload" class="hidden" accept="image/*">
        </div>

        <form>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="flex flex-col">
                    First Name*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Last Name*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Phone Number*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col">
                    Guile License*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Corporation
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Country
                    <select name="country" id="country" class="p-2 border shadow-md rounded w-full">
                        @foreach ($allCountry as $key => $country)
                            <option value={{ $key }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="flex flex-col sm:col-span-2">
                    ID Card Number*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col sm:col-span-2">
                    Address
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col">
                    District
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Province
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Postal Number
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col">
                    Subdistrict
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col sm:col-span-2">
                    Name On Card*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col sm:col-span-2">
                    Card Number (Credit / Debit)*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>

                <label class="flex flex-col">
                    CVC / CVV*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
                <label class="flex flex-col">
                    Expiration Date*
                    <input type="text" class="p-2 border shadow-md rounded w-full">
                </label>
            </div>

            <div class="flex justify-between mt-6">
                <a href="/signUp"
                    class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                    BACK
                </a>

                <button type="submit"
                    class="bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-800 transition">
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
        $(document).ready(function() {
        $('#country').select2({
            placeholder: "Select a country",
            allowClear: true
        });
    });
    </script>

</body>
</html>
