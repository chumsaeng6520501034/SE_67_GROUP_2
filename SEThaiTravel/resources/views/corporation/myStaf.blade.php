<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Staf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('https://www.bsr.org/images/heroes/bsr-travel-hero..jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inknut Antiqua', serif;
        }

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

<body>

    <div class="flex h-screen">

        @include('components.sidebarCorporation')


        <!-- Main Content -->
        <div id="mainContent" class="flex-1 p-5 flex justify-center transition-all duration-300">
            <div class="bg-white bg-opacity-20 backdrop-blur-md p-6 rounded-2xl shadow-lg w-4/5 transition-all duration-300">
                <!-- Search and Date Filter -->
                <div class="flex items-center space-x-4 mb-4 bg-white bg-opacity-50 p-3 rounded-lg shadow-lg w-full">
                    <div class="flex items-center w-full px-2">
                    <svg class="h-8 w-8 text-gray-500 mx-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"> 
                        <circle cx="11" cy="11" r="8" />  <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                        <input type="text" id="searchInput" placeholder="Search" class="outline-none px-2 py-1 w-full round-xl" onkeyup="searchTable()">

                    </div>
                    <div class="flex items-center border rounded ">
                        <button class="bg-blue-900 px-4 py-2 rounded-md text-white">Search</button>
                    </div>
                </div>

                <!-- Payment Table -->
                <table  id="accountTable"class="w-full border border-blue-900">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="border border-white bg-blue-900 px-4 py-2">NO.</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Name</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Surname</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">License</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Phone Number</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guides as $index => $guides)
                        <tr class="text-center">
                            <td class="border border-white px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-white px-4 py-2">{{ $guides->name }}</td>
                            <td class="border border-white px-4 py-2">{{ $guides->surname }}</td>
                            <td class="border border-white px-4 py-2">{{ $guides->guide_license }}</td>
                            <td class="border border-white px-4 py-2">{{ $guides->phonenumber }}</td>
                            <td class="border border-white px-4 py-2">
                                <form action="/corpStaffDetail" method="GET">
                                    <input type="hidden" name="guideID" value={{$guides->account_id_account}}>
                                    <button type="submit" class="bg-green-700 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 transform hover:scale-105 active:scale-95">
                                        INFO
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });

        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('accountTable');
            const rows = table.getElementsByTagName('tr');

            // Loop through all rows, except the header row
            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];

                // ดึงข้อมูลจากแต่ละคอลัมน์
                let no = row.cells[1].textContent.toLowerCase(); // NO.
                let name = row.cells[2].textContent.toLowerCase(); // NAME
                let surname = row.cells[3].textContent.toLowerCase(); // NAME
                let phone = row.cells[5].textContent.toLowerCase(); // PHONE
                let guideLicense = row.cells[4].textContent.toLowerCase(); // GUIDE LICENSE

                // Check if the search input matches any column
                if (no.includes(searchInput) || name.includes(searchInput) || surname.includes(searchInput) || phone.includes(searchInput) || guideLicense.includes(searchInput)) {
                    row.style.display = ''; // Show matching row
                } else {
                    row.style.display = 'none'; // Hide non-matching row
                }
            }
        }
    </script>

</body>
</html>