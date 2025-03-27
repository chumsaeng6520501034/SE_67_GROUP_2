<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-fixed h-screen flex justify-center items-center" 
      style="background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');">
  
    <div class="flex h-screen">
        @include('components.sidebarAdmin')
        
        <div class="flex-1 p-6">
            <!-- Search and Add Button -->
            <div class="flex justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <input type="text" id="searchInput" class="p-2 border border-gray-600 bg-white text-gray-500 rounded-md w-[1110px] mx-auto" placeholder="Search..." onkeyup="searchTable()">
                    <button class="bg-blue-900 text-white px-4 py-2 rounded-md">Search</button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-400 text-center bg-white text-black shadow-lg mb-6" id="accountTable">
                    <thead class="bg-gray-900 text-gray-300">
                        <tr>
                            <th class="border border-gray-600 p-3">NO.</th>
                            <th class="border border-gray-600 p-3">USERNAME</th>
                            <th class="border border-gray-600 p-3">PERMISSION</th>
                            <th class="border border-gray-600 p-3">E-mail</th>
                            <th class="border border-gray-600 p-3">OPTION</th>
                            <th class="border border-gray-600 p-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $index => $account)
                            <tr class="bg-gray-100 even:bg-gray-200 text-black">
                                <td class="border border-gray-400 p-3">{{ $index + 1 }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->username }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->permittion_acc }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->email }}</td>
                                <td class="border border-gray-400 p-3">
                                    <div class="flex justify-center space-x-2">
                                        @if ($account->permittion_acc == 'user')
                                            <form action="/editCustomer" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $account->id_account }}">
                                                <button type="submit" class="bg-blue-900 px-4 py-2 rounded-md text-white">EDIT</button>
                                            </form>
                                        @elseif ($account->permittion_acc == 'guide')
                                            <form action="/editGuide" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $account->id_account }}">
                                                <button type="submit" class="bg-blue-900 px-4 py-2 rounded-md text-white">EDIT</button>
                                            </form>
                                        @elseif ($account->permittion_acc == 'corp')
                                            <form action="/editCorp" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $account->id_account }}">
                                                <button type="submit" class="bg-blue-900 px-4 py-2 rounded-md text-white">EDIT</button>
                                            </form>
                                        @else
                                        @endif
                                    </div>
                                </td>
                                <td class="border border-gray-400 p-3">
                                    <div class="flex justify-center">
                                        @if($account->permittion_acc !== 'admin')
                                            @if ($account->status !== 'pending')
                                                <form action="/statusChange" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $account->id_account }}">
                                                    <button type="submit" 
                                                            class="px-4 py-2 rounded-md text-white
                                                            {{ $account->status === 'available' ? 'bg-green-700' : 'bg-gray-300' }}">
                                                        {{ $account->status }}
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" onclick="openPopup('{{ $account->id_account }}', '{{ $account->status }}')" 
                                                        class="px-4 py-2 rounded-md text-white
                                                            {{ $account->status === 'available' ? 'bg-green-700' : ($account->status === 'pending' ? 'bg-yellow-600' : 'bg-gray-300') }}">
                                                    {{ ucfirst($account->status) }}
                                                </button>
                                            @endif
                                        @else
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Popup for status change -->
    <div id="popup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md shadow-lg">
            <h2 class="text-xl mb-4">Change Status</h2>
            <div class="flex justify-between">
                <button id="changeAvailable" class="bg-green-600 text-white px-4 py-2 rounded-md">Available</button>
                <button id="changeDisappear" class="bg-red-600 text-white px-4 py-2 rounded-md">Disappear</button>
            </div>
            <button id="closePopup" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
        </div>
    </div>

    <script>
        function openPopup(accountId, currentStatus) {
            const popup = document.getElementById('popup');
            popup.classList.remove('hidden');
            
            const changeAvailableButton = document.getElementById('changeAvailable');
            const changeDisappearButton = document.getElementById('changeDisappear');
            const closePopupButton = document.getElementById('closePopup');
            
            changeAvailableButton.onclick = function() {
                changeStatus(accountId, 'avai'); // ส่งไปเส้นทาง '/statusAvai'
            };
            
            changeDisappearButton.onclick = function() {
                changeStatus(accountId, 'dis'); // ส่งไปเส้นทาง '/statusDis'
            };
            
            closePopupButton.onclick = function() {
                popup.classList.add('hidden');
            };
        }

        function changeStatus(accountId, status) {
            // สร้างฟอร์มและส่งคำขอไปยังเส้นทางที่ต้องการ
            const form = document.createElement('form');
            form.method = 'POST';
            
            if (status === 'avai') {
                form.action = '/statusAvai'; // ส่งไปที่ /statusAvai
            } else if (status === 'dis') {
                form.action = '/statusDis'; // ส่งไปที่ /statusDis
            }
            
            form.innerHTML = `
                <input type="hidden" name="id" value="${accountId}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>

</body>
</html>
