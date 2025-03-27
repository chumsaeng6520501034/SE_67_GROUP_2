<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Booking Receipt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="relative min-h-screen flex items-center justify-center p-4 bg-gray-900 text-gray-800">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://www.bsr.org/images/heroes/bsr-travel-hero..jpg" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-gray-900 p-4 flex items-center space-x-4 z-50 shadow-lg">
        <a href="/guideAllPayment" class="text-2xl text-white font-bold pl-4 hover:text-gray-300 transition">
            &#x2190;
        </a>
        <div class="text-2xl text-white font-semibold">PAYMENT</div>
    </nav>

    <div class="relative w-full max-w-md mx-auto">
        <!-- Receipt Container -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-6 text-center">
                <h2 class="text-3xl font-bold text-white tracking-wider">ใบเสร็จรับเงิน</h2>
                <p class="text-white opacity-80 mt-2">{{ucwords($tourData->name)}}</p>
            </div>

            <!-- Receipt Details -->
            <div class="p-6 space-y-4 text-gray-700">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">เลขที่การจอง</p>
                        <p class="font-semibold text-blue-700">{{$bookingData->id_booking}}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">วันที่</p>
                        <p class="font-semibold text-blue-700">{{date("d/m/Y", strtotime($paymentData->payment_date))}}</p>
                    </div>
                </div>

                <div class="border-t border-b border-gray-200 py-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">ชื่อ</span>
                        <span class="font-semibold">{{$userData->name." ".$userData->surname}}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">รหัสทัวร์</span>
                        <span class="font-semibold text-blue-600">{{$tourData->id_tour}}</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">จำนวนคน</span>
                        <span class="font-semibold">{{$bookingData->adult_qty+$bookingData->kid_qty}}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ราคาทัวร์</span>
                        <span class="font-semibold">{{number_format($paymentData->total_price)}}</span>
                    </div>
                </div>

                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">ยอดรวม</span>
                        <span class="text-2xl font-bold text-green-600">฿{{number_format($paymentData->total_price)}}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 p-4 text-center">
                <p class="text-xs text-gray-500">THANK YOU FOR USING SERVICE</p>
            </div>
        </div>
    </div>
</body>
</html>