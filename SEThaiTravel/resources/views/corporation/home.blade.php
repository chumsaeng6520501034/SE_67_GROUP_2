<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #sidebar,
      #mainContent {
          transition: all 0.3s ease-in-out;
      }

      #sidebar {
          z-index: 50;
          /* ให้ Sidebar อยู่ด้านหน้า */
      }

      #toggleSidebar {
          position: fixed;
          z-index: 100;
          /* ให้ปุ่มอยู่ด้านหน้าสุด */
      }

      #sidebar {
          transform: translateX(-100%);
      }

      .sidebar-open #sidebar {
          transform: translateX(0);
      }

      .sidebar-open #mainContent {
          margin-left: 16rem;
          /* ขยับไปทางขวาเท่ากับความกว้างของ Sidebar */
      }
  </style>
</head>
<body class="bg-gray-900">  
    <div class="absolute top-0 left-0 w-full h-[50vh]">
        <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg"
             class="w-full h-full object-cover" />
      </div>
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('components.sidebarCorporation')

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 relative overflow-hidden">
            <div class="relative h-[50vh] w-full">
                {{-- <img src="https://blog.bangkokair.com/wp-content/uploads/2023/09/Cover_krabi-travel-guide-top-destinations.jpg" class="w-full h-full object-cover"> --}}
                <h1 class="absolute top-[40%] left-1/2 transform -translate-x-1/2 text-white text-8xl font-bold ">TRAVEL</h1>
            
            <!-- Search Box -->
            <form action="/corpSearch" method="GET">
                <div class="absolute top-[110%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-100 p-10 rounded-lg shadow-lg w-3/4 mt-5">
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
                            <label class="text-sm font-semibold">Type</label>
                            <div class="flex items-center border border-gray-300 rounded p-4 bg-white">
                                <select name="type" class="h-full w-full">
                                    <option value="request">REQUEST</option>
                                    <option value="tour">TOUR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-yellow-500 text-white px-6 py-2 rounded w-[20%] mx-auto block">SUBMIT</button>
                </div>
            </form>              
        </main>
    </div>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    </script>
</body>
</html>