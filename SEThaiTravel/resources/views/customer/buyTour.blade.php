<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-gray-900 p-4 flex items-center space-x-4 z-50">
        <a href="/home" class="text-2xl text-white font-bold pl-4">
            &#x2190;
        </a>
        <div class="text-2xl text-white font-bold">PAYMENT</div>
    </nav>
    <form action="/customerBooking" method="GET">
    <div class="container mx-auto p-6 pt-16 mt-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white text-black p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">ข้อมูลผู้จอง</h2>
                <!-- User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block mb-2 font-bold">ชื่อ *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="ชื่อของคุณ" readonly value={{session('userID')->name}}>
                    </div>
                    <div>
                        <label class="block mb-2 font-bold">นามสกุล *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="นามสกุลของคุณ" readonly value={{session('userID')->surname}} >
                    </div>
                    <!-- Section: จำนวนผู้เดินทาง -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-bold mb-4">จำนวนผู้เดินทาง</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- จำนวนผู้ใหญ่ -->
                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                <span class="font-bold">ผู้ใหญ่</span>
                                <div class="flex items-center">
                                    <button type="button" onclick="updateCount('adults', -1)" class="bg-gray-300 text-black px-3 py-1 rounded-md">-</button>
                                    <span id="adults-count" class="mx-4">1</span>
                                    <input type="hidden" name="adultqty" value="1" id="adult">
                                    <button type="button" onclick="updateCount('adults', 1)" class="bg-gray-300 text-black px-3 py-1 rounded-md">+</button>
                                </div>
                            </div>

                            <!-- จำนวนเด็ก -->
                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                <span class="font-bold">เด็ก</span>
                                <div class="flex items-center">
                                    <button type="button" onclick="updateCount('children', -1)" class="bg-gray-300 text-black px-3 py-1 rounded-md">-</button>
                                    <span id="children-count" class="mx-4">0</span>
                                    <input type="hidden" name="kidqty" value="0" id="kid">
                                    <button type="button" onclick="updateCount('children', 1)" class="bg-gray-300 text-black px-3 py-1 rounded-md">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2 font-bold">DESCRIPTION</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="detail..." name="description">
                    </div>
                </div>
                <!-- Payment Section -->
                <h2 class="text-xl font-bold mb-4">เลือกชำระเงิน</h2>
                <!-- Pay Later Option -->
                <div class="border rounded-lg p-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_option" id="pay-later" class="form-radio" value="later" checked>
                        <span>PAY LATER</span>
                    </label>
                </div>

                <!-- Pay Now Option -->
                <div class="border rounded-lg p-4 mt-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_option" id="pay-now" class="form-radio" value="now">
                        <span>จ่ายทันที</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-10">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-10">
                        <img src="https://icon2.cleanpng.com/20180816/zbz/a237bfa5f0bc15bec6ec41b3115bbab0.webp" class="h-10">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/American_Express_logo_%282018%29.svg/800px-American_Express_logo_%282018%29.svg.png" class="h-10">
                    </label>
                </div>

                <div id="payment-methods" class="hidden mt-4">
                    <h3 class="text-lg font-bold mb-2">เลือกวิธีชำระเงิน</h3>
                    <select id="payment-dropdown" class="w-full border p-2 rounded">
                        <option value="" selected disabled>-- เลือกวิธีชำระเงิน --</option>
                        <option value="credit-card-form">VISA</option>
                        <option value="credit-card-form">MASTER CARD</option>
                        <option value="credit-card-form">AMEX</option>
                        <option value="credit-card-form">JCB</option>
                    </select>

                    <!-- Credit Card Form -->
                    <div id="credit-card-form" class="payment-option hidden mt-4 bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">ข้อมูลบัตรเครดิต</h2>
                        <label class="block mb-2 font-bold">ชื่อบนบัตร *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="ชื่อบนบัตร">
                        <label class="block mt-4 mb-2 font-bold">หมายเลขบัตรเครดิต *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="หมายเลขบัตร" name="checknumber">
                        <label class="block mt-4 mb-2 font-bold">วันหมดอายุ *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="ดด/ปป">
                        <label class="block mt-4 mb-2 font-bold">รหัส CVC *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="CVC">
                    </div>
                </div>
            </div>

            <div class="bg-white text-black p-6 rounded-lg shadow-md flex flex-col h-full">
                <h2 class="text-xl font-bold mb-4">สรุปรายละเอียดการจอง</h2>
                
                @if (is_null($tourData->tourImage))
                    <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" class="w-full h-40 object-cover rounded-md">
                @else
                    <img src="{{ asset('storage/' . $tourData->tourImage) }}" class="w-full h-40 object-cover rounded-md">
                @endif
                
                <h3 class="text-lg font-bold mt-4">{{$tourData->name}}</h3>
                <div class="text-base font-semibold  flex justify-between pt-2 mt-4">
                    <p><span>Description:</span><br><span>{{$tourData->description}}</span></p>
                </div>
                <!-- เพิ่มการใช้ flex-grow เพื่อให้เนื้อหาข้างบนขยาย และราคาสุทธิจะอยู่ล่างสุด -->
                <div class="text-xl font-bold text-blue-600 flex justify-between pt-2 mt-auto">
                    <span>ราคารวมสุทธิ:</span> <span id="totalPrice">{{$tourData->price}}</span>
                </div>
            </div>
        </div>
        <input type="hidden" name="tourPrice" value={{$tourData->price}}>
        <input type="hidden" name="tourID" value={{$tourData->id_tour}}>
        <!-- Confirm -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded-lg shadow-md text-xl font-bold">Submit</button>
        </div>
    </form>
    </div>
    <script>
        let member;
        let price= @json($tourData->price);
        if(@json($totalMember)=== null){
            member=0;
        }
        else{
            member=@json($totalMember);
        }
        let maxCapacity = @json($tourData->tour_capacity)-member; // จำนวนที่ Tour เปิดรับ
        let adults = 1;
        let children = 0;
        let total = adults+children;
        function updateCount(type, change) {
            if (type === 'adults') {
                if (adults + children + change > maxCapacity || adults + change < 1) return;
                adults += change;
                total = adults+children;
                document.getElementById('adults-count').innerText = adults;
                document.getElementById('totalPrice').innerText = price * total;
                document.getElementById('adult').value = adults;
            } else if (type === 'children') {
                if (adults + children + change > maxCapacity || children + change < 0) return;
                children += change;
                total = adults+children;
                document.getElementById('children-count').innerText = children;
                document.getElementById('totalPrice').innerText = price * total;
                document.getElementById('kid').value = children;
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            let payNow = document.getElementById('pay-now');
            let payLater = document.getElementById('pay-later');
            let paymentDropdown = document.getElementById('payment-dropdown');

            if (payNow) {
                payNow.addEventListener('change', function () {
                    let paymentMethods = document.getElementById('payment-methods');
                    if (paymentMethods) paymentMethods.classList.remove('hidden');
                });
            }

            if (payLater) {
                payLater.addEventListener('change', function () {
                    let paymentMethods = document.getElementById('payment-methods');
                    if (paymentMethods) paymentMethods.classList.add('hidden');
                });
            }

            if (paymentDropdown) {
                paymentDropdown.addEventListener('change', function () {
                    showPaymentOption(this.value);
                });
            }

            function showPaymentOption(id) {
                document.querySelectorAll('.payment-option').forEach(el => el.classList.add('hidden'));
                let selectedOption = document.getElementById(id);
                if (selectedOption) selectedOption.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
