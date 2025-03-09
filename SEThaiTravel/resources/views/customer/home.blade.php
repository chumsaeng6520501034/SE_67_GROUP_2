<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <div class="flex h-screen relative">
    

        <!-- Sidebar ที่ Include -->
            @include('components.sidebarCustomer')

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 ml-0 p-5 transition-all duration-300 ease-in-out">
            <div class="relative h-[50vh] w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <h1 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1>
            </div>

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

    <!-- JavaScript -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('mainContent');

            if (sidebar.classList.contains("-translate-x-full")) {
                // เปิด Sidebar
                sidebar.classList.remove("-translate-x-full");
                sidebar.classList.add("translate-x-0");
                mainContent.style.marginLeft = "16rem"; // ขยับ Main Content ไปทางขวา
            } else {
                // ปิด Sidebar
                sidebar.classList.add("-translate-x-full");
                sidebar.classList.remove("translate-x-0");
                mainContent.style.marginLeft = "0"; // คืนค่า Main Content
            }
        });
    </script>
</body>
</html>
