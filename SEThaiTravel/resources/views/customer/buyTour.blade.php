<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-6 pt-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Payment Section -->
            <div class="md:col-span-2 bg-white text-black p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">เลือกชำระเงิน</h2>
                
                <!-- Pay Later Option -->
                <div class="border rounded-lg p-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_option" id="pay-later" class="form-radio">
                        <span>จ่ายวันที่ 7 เมษายน 2568</span>
                    </label>
                    <div class="bg-green-100 p-4 mt-2 rounded-md">
                        <p class="text-green-700 font-bold">[ไม่ต้องจ่ายทันที] จองตอนนี้ แต่จ่ายวันที่ 7 เมษายน 2568</p>
                        <p class="text-gray-600 text-sm">ยกเลิกการจองฟรีก่อน 23:59 น. ของวันที่ 8 เมษายน 2568</p>
                    </div>
                </div>

                <div id="pay-later-form" class="hidden mt-4">
                    <label class="block mb-2 font-bold">ชื่อ *</label>
                    <input type="text" class="w-full border p-2 rounded" placeholder="ชื่อจริง">
                    <label class="block mt-4 mb-2 font-bold">นามสกุล *</label>
                    <input type="text" class="w-full border p-2 rounded" placeholder="นามสกุล">
                    <label class="block mt-4 mb-2 font-bold">เบอร์โทร *</label>
                    <input type="text" class="w-full border p-2 rounded" placeholder="เบอร์โทรศัพท์">
                </div>

                <!-- Pay Now Option -->
                <div class="border rounded-lg p-4 mt-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_option" id="pay-now" class="form-radio">
                        <span>จ่ายทันที</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-10">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-10">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/PromptPay-logo.png" class="h-10">
                    </label>
                </div>

                <div id="payment-methods" class="hidden mt-4">
                    <h3 class="text-lg font-bold mb-2">เลือกวิธีชำระเงิน</h3>
                    <select id="payment-dropdown" class="w-full border p-2 rounded">
                        <option value="" selected disabled>-- เลือกวิธีชำระเงิน --</option>
                        <option value="credit-card-form">บัตรเครดิต</option>
                        <option value="promptpay-qrcode">PromptPay</option>
                    </select>

                    <!-- Credit Card Form -->
                    <div id="credit-card-form" class="payment-option hidden mt-4 bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">ข้อมูลบัตรเครดิต</h2>
                        <label class="block mb-2 font-bold">ชื่อบนบัตร *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="ชื่อบนบัตร">
                        <label class="block mt-4 mb-2 font-bold">หมายเลขบัตรเครดิต *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="หมายเลขบัตร">
                        <label class="block mt-4 mb-2 font-bold">วันหมดอายุ *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="ดด/ปป">
                        <label class="block mt-4 mb-2 font-bold">รหัส CVC *</label>
                        <input type="text" class="w-full border p-2 rounded" placeholder="CVC">
                    </div>

                    <!-- PromptPay QR Code -->
                    <div id="promptpay-qrcode" class="payment-option hidden mt-4 text-center">
                        <h2 class="text-xl font-bold mb-2">สแกน QR Code เพื่อชำระเงิน</h2>
                        <img src="https://www.theodoostore.com/web/image/app/54311/app_icon" class="w-40 mx-auto">
                        <p class="text-gray-600 text-sm mt-2">*กรุณาชำระเงินและแจ้งหลักฐาน</p>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="bg-white text-black p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">สรุปรายละเอียดการจอง</h2>
                <img src="https://static.independent.co.uk/2025/01/03/14/newFile-12.jpg" class="w-full h-40 object-cover rounded-md">
                <h3 class="text-lg font-bold mt-4">ไดมอนด์ บางกอก อพาร์ทเมนท์</h3>
                <p class="text-gray-600">พัก 2 คืน • 2 ผู้เข้าพัก</p>
                <p class="text-red-600 mt-2">* ราคานี้เหลือเพียง 4 คนสุดท้าย</p>
                <div class="text-lg font-semibold text-gray-700 flex justify-between border-b pb-2 mb-2">
                    <span>ราคาเดิม:</span> <span class="line-through text-gray-500">฿7,580.00</span>
                </div>
                <div class="text-lg font-semibold text-gray-700 flex justify-between border-b pb-2 mb-2">
                    <span>ส่วนลด:</span> <span class="text-green-600">-฿2,332.07</span>
                </div>
                <div class="text-lg font-semibold text-gray-700 flex justify-between border-b pb-2 mb-2">
                    <span>ภาษีและค่าธรรมเนียม:</span> <span class="text-red-600">฿367.98</span>
                </div>
                <div class="text-xl font-bold text-blue-600 flex justify-between pt-2 mt-2">
                    <span>ราคารวมสุทธิ:</span> <span>฿2,446.95</span>
                </div>
                <p class="text-gray-600 text-sm">สามารถสะสมแต้มเพื่อใช้ในการจองครั้งถัดไป</p>
            </div>
        </div>

        <!-- Confirm / Cancel Buttons -->
        <div class="flex justify-between mt-6">
            <button class="bg-red-700 text-white px-6 py-3 rounded-lg shadow-md text-xl font-bold">Cancel</button>
            <button class="bg-blue-900 text-white px-6 py-3 rounded-lg shadow-md text-xl font-bold">Summit</button>
        </div>
    </div>

    <script>
        document.getElementById('pay-later').addEventListener('change', function() {
            document.getElementById('pay-later-form').classList.remove('hidden'); // แสดงฟอร์ม Pay Later
            document.getElementById('payment-methods').classList.add('hidden'); // ซ่อน Pay Now
        });

        document.getElementById('pay-now').addEventListener('change', function() {
            document.getElementById('pay-later-form').classList.add('hidden'); // ซ่อน Pay Later
            document.getElementById('payment-methods').classList.remove('hidden'); // แสดง Pay Now
        });

        // เมื่อเลือก dropdown จะแสดงฟอร์มทันที
        document.getElementById('payment-dropdown').addEventListener('change', function() {
            let selectedOption = this.value;
            showPaymentOption(selectedOption);
        });

        function showPaymentOption(id) {
            // ซ่อนทุกตัวเลือกก่อน
            document.querySelectorAll('.payment-option').forEach(el => el.classList.add('hidden'));

            // แสดงฟอร์มที่เลือก
            if (id && document.getElementById(id)) {
                document.getElementById(id).classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
