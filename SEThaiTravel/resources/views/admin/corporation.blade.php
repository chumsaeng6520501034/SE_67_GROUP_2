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
                <table id="accountTable" class="w-full border border-gray-400 text-center bg-white text-black rounded-lg shadow-lg mb-6">
                    <thead class="bg-gray-900 text-gray-300">
                        <tr>
                            <th class="border border-gray-600 p-3">NO.</th>
                            <th class="border border-gray-600 p-3">ID</th>
                            <th class="border border-gray-600 p-3">NAME</th>
                            <th class="border border-gray-600 p-3">PHONE</th>
                            <th class="border border-gray-600 p-3">CORP LICENSE</th>
                            <th class="border border-gray-600 p-3">OPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($corporations as $index => $account)
                            <tr class="bg-gray-100 even:bg-gray-200 text-black">
                                <td class="border border-gray-400 p-3">{{ $index + 1 }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->account_id_account }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->name . '' . $account->surname }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->phone_number }}</td>
                                <td class="border border-gray-400 p-3">{{ $account->corp_license }}</td>
                                <td class="border border-gray-400 p-3 flex justify-center space-x-2">
                                    <form action="/editCorp" method="POST">
                                        @csrf
                                        {{-- @dd($account->account_id_account) --}}
                                        <input type="hidden" name="id" value="{{ $account->account_id_account }}">
                                        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-md">EDIT</button>
                                    
                                    </form>
                                    {{-- <form action="/deleteCorp" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $account->account_id_account }}">
                                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-md">DEL</button>
                                    </form> --}}
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
                    
                    // ดึงข้อมูลจากแต่ละคอลัมน์
                    let no = row.cells[0].textContent.toLowerCase();  // NO.
                    let id = row.cells[1].textContent.toLowerCase();  // ID
                    let name = row.cells[2].textContent.toLowerCase();  // NAME
                    let phone = row.cells[3].textContent.toLowerCase();  // PHONE
                    let corpLicense = row.cells[4].textContent.toLowerCase();  // GUIDE LICENSE
                    
                    // Check if the search input matches any column
                    if (no.includes(searchInput) || id.includes(searchInput) || name.includes(searchInput) || phone.includes(searchInput) || corpLicense.includes(searchInput)) {
                        row.style.display = ''; // Show matching row
                    } else {
                        row.style.display = 'none'; // Hide non-matching row
                    }
                }
            }
    </script>
</body>
</html>
