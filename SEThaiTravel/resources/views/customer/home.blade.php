<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .sidebar {
            width: 250px;
            background-color: #0a4c8a;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            padding-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px 20px;
            cursor: pointer;
        }
        .sidebar ul li:hover {
            background-color: #083a66;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .hero {
            background-image: url('https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            position: relative;
            color: white;
            text-align: center;
        }
        .hero h1 {
            font-size: 64px;
            font-weight: bold;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .search-box {
            background: #e0f7fa;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 60%;
            height: 150px;
            position: absolute; /* ทำให้กล่องลอยอยู่ */
            top: 30%;          /* ระยะห่างจากขอบบน */
            left: 55%;         /* กึ่งกลางหน้าจอ */
            transform: translateX(-50%); /* จัดกึ่งกลาง */
            z-index: 10;       /* ให้อยู่หน้ารูปภาพ */
            /*margin: -50px auto 0;
            text-align: center;*/
        }
        .search-box input, .search-box button {
            padding: 20px;
            margin: 20px;
            border-radius: 10px; /* ความมนของขอบกล่อง */
            border: 1px solid #ccc; /* เงาของกล่อง */
        }
        .search-box button {
            background-color: #0a4c8a;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #083a66;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>User Name</h2>
        <ul>
            <li>ADD TOUR</li>
            <li>MY TOUR</li>
            <li>HISTORY</li>
            <li>MY REVIEW</li>
            <li>CALENDAR</li>
            <li>MY BOOKING</li>
            <li>MY PAYMENT</li>
            <li>LOG OUT</li>
        </ul>
    </div>
    <div class="content">
        <div class="hero">
            <h1>TRAVEL</h1>
        </div>
        <div class="search-box">
            <input type="text" placeholder="Location">
            <input type="date" placeholder="Start Date">
            <input type="date" placeholder="End Date">
            <input type="number" placeholder="Person">
            <button>SUBMIT</button>
        </div>
    </div>
</body>
</html> -->
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
                <a href="/calendar" class="block py-2 px-4 hover:bg-blue-800 rounded">CALENDAR</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY BOOKING</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-800 rounded">MY PAYMENT</a>
            </nav>
            <a href="#" class="block py-2 px-4 hover:bg-red-700 rounded">LOG OUT</a>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 relative">
            <div class="relative h-80 w-full">
                <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover">
                <h1 class="absolute top-20 left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold">TRAVEL</h1>
            
            
            <!-- Search Box -->
            <div class="absolute top-[120%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-100 p-10 rounded-lg shadow-lg w-3/4">
                <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                    <span class="text-gray-500 pr-2">🔍</span>
                    <input type="text" placeholder="location" class="w-full outline-none">
                </div>
                <div class="flex justify-between mt-4">
                    <div class="w-1/3">
                        <label class="text-sm font-semibold">Start Date</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">📅</span>
                            <input type="date" class="outline-none w-full">
                        </div>
                    </div>
                    <div class="w-1/3">
                        <label class="text-sm font-semibold">End Date</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">📅</span>
                            <input type="date" class="outline-none w-full">
                        </div>
                    </div>
                    <div class="w-1/4">
                        <label class="text-sm font-semibold">Person</label>
                        <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                            <span class="text-gray-500 pr-2">👤</span>
                            <input type="number" class="outline-none w-full" min="1" value="1">
                        </div>
                    </div>
                </div>
                <button class="mt-4 bg-yellow-500 text-white px-6 py-2 rounded w-[20%] mx-auto block">SUBMIT</button>
            </div>
            <div class="mt-20 mx-auto w-3/4">
                <div class="bg-white rounded-lg shadow-lg flex overflow-hidden mt-[23%]">
                    <!-- Image Section -->
                    <img src="https://quintessentially.com/assets/noted/Header_2023-04-12-154210_sigz.webp" alt="Bangkok" class="w-1/3 object-cover">

                    <!-- Tour Details -->
                    <div class="p-6 flex-1">
                        <h2 class="text-2xl font-bold">BANGKOK</h2>
                        <p class="text-gray-600 mt-1">DESCRIPTION</p>
                        <p class="text-gray-500 text-sm mt-2">STATUS</p>
                    </div>

                    <!-- Review & Price Section -->
                    <div class="p-6 bg-gray-100 w-1/4 text-center rounded-r-lg">
                        <p class="text-gray-600 text-sm">REVIEW</p>
                        <p class="text-gray-800 font-semibold">1,989 review</p>
                        <div class="flex justify-center my-3">
                            ⭐⭐⭐⭐⭐
                        </div>
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
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md font-bold">Discount 50%</button>
                        <p class="text-gray-500 mt-2 text-sm line-through">1,000,000</p>
                        <p class="text-2xl font-bold text-gray-800">500,000</p>
                    </div>
                </div>
            </div>
        </main>
        
    </div>
</body>
</html>
