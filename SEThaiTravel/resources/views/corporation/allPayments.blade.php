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
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
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
                <form action="/corpSearchAllPayment" method="get">
                    <div class="flex items-center space-x-4 mb-4 bg-white bg-opacity-50 p-3 rounded-lg shadow-lg w-full">
                        <div class="flex items-center w-full px-2">
                            <svg class="h-8 w-8 text-gray-500 mx-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"> 
                                <circle cx="11" cy="11" r="8" />  <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            <input type="text" name="searchKey" placeholder="Search" class="outline-none px-2 py-1 w-full">
                        </div>
                        <div class="flex items-center px-2 text-blue-900 text-xl mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 24" width="48" height="48" fill="currentColor">
                                <path d="M2 12l4-4v8l-4-4zM30 12l-4 4V8l4 4zM8 10h16v4H8v-4z"/>
                            </svg>
                            <input type="date" name="paymentDate" class="outline-none px-2 py-1">
                        </div>
                        <button type="submit" class="bg-blue-900 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-300 transform hover:scale-105 active:scale-95">
                            SEARCH
                        </button>
                    </div>
                </form>
                <!-- Payment Table -->
                <table class="w-full border border-blue-500">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="border border-white bg-blue-900 px-4 py-2">NO.</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">CHEQUE NO.</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">DATE PAYMENT</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">CustomerName</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">TOUR ID</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Net price</th>
                            <th class="border border-white bg-blue-900 px-4 py-2">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $index => $payment)
                        <tr class="text-center">
                            <td class="border border-white px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-white px-4 py-2">{{ $payment->checknumber }}</td>
                            <td class="border border-white px-4 py-2">{{ $payment->payment_date }}</td>
                            <td class="border border-white px-4 py-2">{{ $payment->name.' '.$payment->surname }}</td>
                            <td class="border border-white px-4 py-2">{{ $payment->booking_Tour_id_Tour }}</td>
                            <td class="border border-white px-4 py-2">{{ $payment->total_price }}</td>
                            <td class="border border-white px-4 py-2">
                                <form action="/corpPaymentDetail" method="GET">
                                    <input type="hidden" name="userID" value={{$payment->booking_user_list_account_id_account}}>
                                    <input type="hidden" name="tourID" value={{$payment->tour_id_tour}}>
                                    <input type="hidden" name="paymentID" value={{$payment->id_payment}}>
                                    <input type="hidden" name="bookingID" value={{$payment->id_booking}}>
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

    </script>

</body>

</html>