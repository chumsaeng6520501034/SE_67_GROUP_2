<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ openEditModal: false, openDeleteModal: false }">
    <div class="bg-blue-900 text-white p-4 flex items-center">
        <a href="#" class="text-2xl mr-4">&#8592;</a>
        <h1 class="text-xl font-bold">PROFILE</h1>
    </div>

    <div class="relative h-[50vh] w-full">
        <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
    </div>

    <!-- โปรไฟล์ -->
    <div class="absolute top-[55%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-300 p-10 rounded-lg shadow-lg w-[60%] relative">
        <!-- ปุ่มแก้ไข & ลบ -->
        <div class="absolute top-4 right-4 flex space-x-2">
            <button @click="openEditModal = true" class="bg-white p-2 rounded-full shadow-md hover:bg-gray-200">
                ✏️
            </button>
            <button @click="openDeleteModal = true" class="bg-red-500 text-white p-2 rounded-full shadow-md hover:bg-red-600">
                🗑️
            </button>
        </div>

        <div class="relative flex justify-center mt-4">
            <label for="profile-upload" class="relative cursor-pointer">
                <img id="profileImage" src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg" 
                    alt="Profile Picture" class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg">
                <input type="file" id="profile-upload" class="hidden" accept="image/*">
            </label>
        </div>

        <div class="mt-12 p-4">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded-lg shadow">
                <div>
                    <p class="font-semibold text-blue-900 text-2xl">Name :</p>
                    <p class="mt-1 text-2xl">John Doe</p>
                </div>
                <div>
                    <p class="font-semibold text-blue-900 text-2xl">Birthday :</p>
                    <p class="mt-1 text-2xl">01/01/1990</p>
                </div>
                <div>
                    <p class="font-semibold text-blue-900 text-2xl">E-mail :</p>
                    <p class="mt-1 text-2xl">johndoe@example.com</p>
                </div>
                <div>
                    <p class="font-semibold text-blue-900 text-2xl">Phone :</p>
                    <p class="mt-1 text-2xl">123-456-7890</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold text-blue-900 text-2xl">Address :</p>
                    <p class="mt-1 text-2xl">123 Street, City, Country</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold text-blue-900 text-2xl">Payment :</p>
                    <p class="mt-1 text-2xl">Visa - **** 1234</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal แก้ไขข้อมูล -->
    <div x-show="openEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
            <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
            <label class="block mb-2">Name:</label>
            <input type="text" class="w-full border p-2 rounded-lg mb-4" placeholder="John Doe">

            <label class="block mb-2">E-mail:</label>
            <input type="email" class="w-full border p-2 rounded-lg mb-4" placeholder="johndoe@example.com">

            <label class="block mb-2">Phone:</label>
            <input type="text" class="w-full border p-2 rounded-lg mb-4" placeholder="123-456-7890">

            <div class="flex justify-end space-x-2">
                <button @click="openEditModal = false" class="bg-red-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Save</button>
            </div>
        </div>
    </div>

    <!-- Modal ยืนยันลบ -->
    <div x-show="openDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
            <h2 class="text-xl font-bold mb-4 text-red-600">Delete Account</h2>
            <p class="text-lg mb-4">Are you sure you want to delete this account? This action cannot be reversed!</p>

            <div class="flex justify-end space-x-2">
                <button @click="openDeleteModal = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>
            </div>
        </div>
    </div>

</body>
</html>
