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
        <a href="/corpMyStaff" class="text-2xl mr-4">&#8592;</a>
        <h1 class="text-xl font-bold">PROFILE GUIDE</h1>
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
                @if (is_null($guideInfo->photo))
                    <img id="profileImage"
                        src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg"
                        alt="Profile Picture"
                        class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                @else
                    <img src="{{ asset('storage/' . $guideInfo->photo) }}" alt="image"
                        class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                @endif
                @csrf
            </label>

            <div class="mt-4 text-center">
                <h2 class="text-xl font-semibold">{{ $guideInfo->name }} {{ $guideInfo->surname }}</h2>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="mt-6 p-6">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded-lg shadow">
                <div>
                    <p class="font-semibold">Phone:</p>
                    <p class="mt-1">{{ $guideInfo->phonenumber }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Payment:</p>
                    <p class="mt-1">Visa: {{ $guideInfo->fake_BAN }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Guide License:</p>
                    <p class="mt-1">{{ $guideInfo->guide_license }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Postcode:</p>
                    <p class="mt-1">{{ $guideInfo->postcode }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Country:</p>
                    @if ($guideInfo->country)
                        <p class="mt-1">{{ $countrys[$guideInfo->country] }}</p>
                    @else
                        <p class="mt-1">-</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tour in Work Section -->
        <div class="mt-6 p-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">🎒 Tour in Work</h2>

                @if(count($guideWork) > 0)
                    <ul class="space-y-2">
                        @foreach ($guideWork as $work)
                            <li class="bg-blue-100 px-4 py-2 rounded shadow-sm text-blue-900 font-semibold">
                                {{ $work->name }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic">No current tours assigned.</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
