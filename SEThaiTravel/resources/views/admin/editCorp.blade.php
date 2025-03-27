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

      <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-gray-900 p-4 flex items-center space-x-4 z-50 shadow-lg">
        <a href="/corporation" class="text-2xl text-white font-bold pl-4 hover:text-gray-300 transition">
            &#x2190;
        </a>
        <div class="text-2xl text-white font-semibold">TRAVEL & TOUR</div>
    </nav>

      <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white/10 backdrop-blur-2xl p-10 rounded-2xl shadow-lg w-[900px]">
            <h2 class="text-center text-4xl font-bold text-[#002D62] mb-6">Edit Corporation</h2>
            <form action="/updateCorp" method="POST">
                @csrf
                {{-- @dd($account->account_id_account) --}}
                <input type="hidden" name="id" value="{{ $account->account_id_account }}">
            
                <!-- Row 1 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-white font-medium">USERNAME</label>
                        <input type="text" name="username" value="{{ $account->username }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">PASSWORD</label>
                        <input type="text" name="password" value="{{ $account->password }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">EMAIL</label>
                        <input type="text" name="email" value="{{ $account->email }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>

                <!-- Row 1 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-white font-medium">ID</label>
                        <input type="number" name="ID" value="{{ $account->account_id_account }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Name</label>
                        <input type="text" name="name" value="{{ $account->name }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Owner</label>
                        <input type="text" name="name_owner" value="{{ $account->name_owner }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>
                
                <!-- Row 2 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-white font-medium">Phone Number</label>
                        <input type="tel" name="phone_number" value="{{ $account->phone_number }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Nationality</label>
                        <input type="number" name="nationality" value="{{ $account->nationality }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Logo</label>
                        <input type="text" name="logo" value="{{ $account->logo }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-white font-medium">Corp_license</label>
                        <input type="number" name="corp_license" value="{{ $account->corp_license }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Owner Country Code</label>
                        <input type="number" name="owner_country_code" value="{{ $account->owner_country_code }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">DoB</label>
                        <input type="date" name="dob" value="{{ $account->dob }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    
                </div>
                <!-- Row 3 -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="col-span-3">
                        <label class="block text-white font-medium">Address</label>
                        <input type="text" name="address" value="{{ $account->address }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Country</label>
                        <input type="text" name="country" value="{{ $account->country }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-white font-medium">Postcode</label>
                        <input type="text" pattern="[0-9]{5}" title="Enter a valid 5-digit postcode" name="postcode" value="{{ $account->postcode }}" class="w-full p-2 border rounded shadow-sm">
                    </div>
                </div>
                
                
                

                

                
                <div class="mt-6 text-center">
                    <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded shadow-lg text-lg hover:bg-blue-800 transition">
                        UPDATE
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
