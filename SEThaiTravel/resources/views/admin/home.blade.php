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
                <div class="flex items-center space-x-2 ">
                    <input type="text" id="searchInput" class="p-2 border border-gray-600 bg-white text-gray-500 rounded-md w-[1110px] mx-auto" placeholder="Search..." onkeyup="searchTable()">
                    <button class="bg-blue-900  text-white px-4 py-2 rounded-md">Search</button>
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

    <script>
        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('accountTable');
            const rows = table.getElementsByTagName('tr');
            
            // Loop through all rows, except the header row
            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];
                let username = row.cells[1].textContent.toLowerCase();
                let permission = row.cells[2].textContent.toLowerCase();
                let email = row.cells[3].textContent.toLowerCase();
                let status = row.cells[5].querySelector('button') ? row.cells[5].querySelector('button').textContent.toLowerCase() : ''; // ดึงข้อความจากปุ่มในคอลัมน์สถานะ

                // Check if the search input matches any column (USERNAME, PERMISSION, EMAIL, or STATUS)
                if (username.includes(searchInput) || permission.includes(searchInput) || email.includes(searchInput) || status.includes(searchInput)) {
                    row.style.display = ''; // Show matching row
                } else {
                    row.style.display = 'none'; // Hide non-matching row
                }
            }
        }
    </script>

</body>
</html>
