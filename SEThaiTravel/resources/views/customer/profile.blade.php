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
    <!-- Header -->
    <div class="bg-blue-900 text-white p-4 flex items-center">
        <a href="/home" class="text-2xl mr-4">&#8592;</a>
        <h1 class="text-xl font-bold">PROFILE</h1>
    </div>

    <!-- Container -->
    <div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg max-w-4xl relative">
        <!-- Cover Image -->
        <div class="relative h-56 w-full rounded-t-lg overflow-hidden">
            <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg"
                class="w-full h-full object-cover">
        </div>

        <!-- Profile Section -->
        <div class="relative -mt-16 flex flex-col items-center">
            <label for="profile-upload" class="relative cursor-pointer">
                <img id="profileImage"
                    src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg"
                    alt="Profile Picture"
                    class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                <input type="file" id="profile-upload" class="hidden" accept="image/*">
            </label>

            <div class="mt-4 text-center">
                <h2 class="text-xl font-semibold">{{$userData->name}} {{$userData->surname}}</h2>
                <p class="text-gray-600">{{$accountData->username}}</p>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="mt-6 p-6">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded-lg shadow">
                <div>
                    <p class="font-semibold">E-mail:</p>
                    <p class="mt-1">{{$accountData->email}}</p>
                </div>
                <div>
                    <p class="font-semibold">Phone:</p>
                    <p class="mt-1">{{$userData->phonenumber}}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Address:</p>
                    <p class="mt-1">{{$userData->address}}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Payment:</p>
                    <p class="mt-1">Visa: {{$userData->fake_BAN}}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mt-6">
            <button @click="openEditModal = true"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Edit</button>
            <button @click="openDeleteModal = true"
                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600">Delete</button>
        </div>
    </div>

    <!-- Edit Modal -->
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
                <button @click="openEditModal = false"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Save</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="openDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
            <h2 class="text-xl font-bold mb-4 text-red-600">Delete Account</h2>
            <p class="text-lg mb-4">Are you sure you want to delete this account? This action cannot be reversed!</p>

            <div class="flex justify-end space-x-2">
                <button @click="openDeleteModal = false"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>
            </div>
        </div>
    </div>

</body>

</html>
