<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-900" x-data="{ openEditModal: false, openDeleteModal: false }">
    <!-- Header -->
    <div class="bg-gray-900 text-white p-4 flex items-center">
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
                @if (is_null($userData->photo))
                <img id="profileImage"
                    src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg"
                    alt="Profile Picture"
                    class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                @else
                <img src="{{ asset('storage/' . $userData->photo) }}" alt="image"
                    class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                @endif
                <form action="/customerUpdateImage" method="POST" enctype="multipart/form-data" class="mt-4 text-center">
                    @csrf
                    <input type="file" id="profile-upload" name="image" class="hidden">
                    <button class="mt-1" type="submit">Upload</button>
                </form>
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
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Postcode:</p>
                    <p class="mt-1">{{$userData->postcode}}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Country:</p>
                    @if ($userData->country)
                    <p class="mt-1">{{$countrys[$userData->country]}}</p>
                    @else
                    <p class="mt-1"></p>
                    @endif

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
        <form action="/customerEditProfile" method="POST">
            @csrf
            <div class="bg-white p-6 rounded-lg shadow-lg w-[800px]">
                <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
                <label class="block mb-2">Username:</label>
                <input type="text" name="username" class="w-full border p-2 rounded-lg mb-4" value="{{$accountData->username}}">


                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Name:</label>
                        <input type="text" name="name" value="{{$userData->name}}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Surname:</label>
                        <input type="text" name="surname" value="{{$userData->surname}}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>


                <label class="block mb-2">Phone number:</label>
                <input type="text" pattern="^\d+$" name="phonenumber" class="w-full border p-2 rounded-lg mb-4" value="{{$userData->phonenumber}}">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Address</label>
                    <textarea name="address" class="w-full p-2 border rounded shadow-sm h-24" ">{{$userData->address}}</textarea>
                </div>

                <div class=" grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Country:
                            <select name="country" class="p-2 border shadow-md rounded w-full">
                                @foreach ($countrys as $key => $country)
                                <option value={{ $key }}>{{ $country }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium">Postcode:</label>
                        <input type="number" name="postcode" value="{{$userData->postcode}}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="/customerProfile" class="bg-gray-500 text-white font-bold py-2 px-6 rounded shadow-md hover:bg-red-700 transition">
                        BACK
                    </a>
                    <button type="submit" class="bg-[#0F3557] text-white font-bold py-2 px-6 rounded shadow-md hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="openDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
            <h2 class="text-xl font-bold mb-4 text-red-600">Delete Account</h2>
            <p class="text-lg mb-4">Are you sure you want to delete this account? This action cannot be reversed!</p>

            <div class="flex justify-end space-x-2">
                <button @click="openDeleteModal = false"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                <form action="/deleteAccount" method="GET">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>