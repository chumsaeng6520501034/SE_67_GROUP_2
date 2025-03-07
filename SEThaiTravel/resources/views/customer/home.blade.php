<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">  
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebarCustomer')

        <!-- Sidebar
        <aside class="w-64 bg-blue-900 text-white p-6 space-y-4 flex flex-col h-full">
        <div class="flex items-center space-x-2">
            <a href="#" class="flex items-center space-x-2">
                <label for="profile-upload" class="relative cursor-pointer">
                    <img id="profileImage" src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg" alt="Profile Picture" class="w-20 h-20 rounded-full border-2 border-white object-cover">
                    <input type="file" id="profile-upload" class="hidden" accept="image/*" onchange="previewProfileImage(event)">
                </label>
                <span class="font-bold cursor-pointer">User Name</span>
            </a>
        </div>
            <nav class="space-y-2">
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">ADD TOUR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY TOUR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">HISTORY</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY REVIEW</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">CALENDAR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY BOOKING</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY PAYMENT</a>
            </nav>
            <a href="#" class="block py-2 px-4 hover:bg-red-700 rounded">LOG OUT</a>
        </aside>
         -->
        <!-- Main Content -->
        <main class="flex-1 relative overflow-hidden">
            <div class="relative h-[50vh] w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <h1 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1>
            
            <!-- Search Box -->
            <form action="/customerSearch" method="GET">
                <div class="absolute top-[110%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-100 p-10 rounded-lg shadow-lg w-2/3">
                    <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                        <span class="text-gray-500 pr-2">🔍</span>
                        <input type="text" name="searchKey" placeholder="location" class="w-full outline-none">
                    </div>
                    <div class="flex justify-between mt-4">
                        <div class="w-1/3">
                            <label class="text-sm font-semibold">Start Date</label>
                            <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                                <span class="text-gray-500 pr-2">📅</span>
                                <input type="date" name="startDate" class="outline-none w-full">
                            </div>
                        </div>
                        <div class="w-1/3">
                            <label class="text-sm font-semibold">End Date</label>
                            <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                                <span class="text-gray-500 pr-2">📅</span>
                                <input type="date" name="endDate" class="outline-none w-full">
                            </div>
                        </div>
                        <div class="w-1/4">
                            <label class="text-sm font-semibold">Person</label>
                            <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                                <span class="text-gray-500 pr-2">👤</span>
                                <input type="number" name="capacity" class="outline-none w-full" min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-yellow-500 text-white px-6 py-2 rounded w-[20%] mx-auto block">SUBMIT</button>
                </div>
            </form>
            
                        <!-- JavaScript ทำให้กดเลือกดาวได้จริง  -->
                        <!-- <div class="flex justify-center my-2">
                            <span class="star text-3xl cursor-pointer" data-value="1">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="2">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="3">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="4">⭐</span>
                            <span class="star text-3xl cursor-pointer" data-value="5">⭐</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput">

                        <script>
                            document.querySelectorAll('.star').forEach(star => {
                                star.addEventListener('click', function () {
                                    let value = this.getAttribute('data-value');
                                    document.getElementById('ratingInput').value = value;

                                    document.querySelectorAll('.star').forEach(s => {
                                        s.textContent = s.getAttribute('data-value') <= value ? '⭐' : '☆';
                                    });
                                });
                            });
                        </script> -->
                        
        </main>
    </div>
</body>
</html>
