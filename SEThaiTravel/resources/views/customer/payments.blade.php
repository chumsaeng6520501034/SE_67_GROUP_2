<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Table</title>
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
    z-index: 50; /* ให้ Sidebar อยู่ด้านหน้า */
}
#toggleSidebar {
    position: fixed;
    z-index: 100; /* ให้ปุ่มอยู่ด้านหน้าสุด */
}
#sidebar {
        transform: translateX(-100%);
    }
    .sidebar-open #sidebar {
        transform: translateX(0);
    }
    .sidebar-open #mainContent {
        margin-left: 16rem; /* ขยับไปทางขวาเท่ากับความกว้างของ Sidebar */
    }
    </style>
</head>

<body>

    <div class="flex h-screen">
        @include('components.sidebarCustomer')
        <!-- Main Content -->
        <div id="mainContent" class="flex-1 p-5 flex justify-center transition-all duration-300">
            <div class="bg-white bg-opacity-20 backdrop-blur-md p-6 rounded-2xl shadow-lg w-4/5 transition-all duration-300">
                <!-- Search and Date Filter -->
                <div class="flex items-center space-x-4 mb-4 bg-white bg-opacity-80 p-3 rounded-lg shadow-lg">
                    <div class="flex items-center border rounded px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 1 0-14 0 7 7 0 0 0 14 0z" />
                        </svg>
                        <input type="text" placeholder="Search" class="outline-none px-2 py-1">
                    </div>
                    <div class="flex items-center border rounded px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M3 10h18M5 14h14m-7 4v-4" />
                        </svg>
                        <input type="date" class="outline-none px-2 py-1">
                    </div>
                </div>

                <!-- Payment Table -->
                <table class="w-full border border-blue-500">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="border border-blue-500 px-4 py-2">NO.</th>
                            <th class="border border-blue-500 px-4 py-2">CHEQUE NO.</th>
                            <th class="border border-blue-500 px-4 py-2">DATE PAYMENT</th>
                            <th class="border border-blue-500 px-4 py-2">BOOKING ID</th>
                            <th class="border border-blue-500 px-4 py-2">TOUR ID</th>
                            <th class="border border-blue-500 px-4 py-2">Net price</th>
                            <th class="border border-blue-500 px-4 py-2">RECEIPT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentHistory as $index => $payment)
                        <tr class="text-center">
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $payment->checknumber }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $payment->payment_date }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $payment->booking_user_list_account_id_account }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $payment->booking_Tour_id_Tour }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $payment->total_price}}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($payment->receipt_url)
                                    <a href="/" target="_blank">
                                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                                            View Receipt
                                        </button>
                                    </a>
                                @else
                                    <button class="bg-red-700 text-white px-4 py-2 rounded-lg cursor-not-allowed" disabled>
                                        No Receipt
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach 

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.body.classList.toggle('sidebar-open');
    });
    </script>

</body>

</html>
