<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="bg-blue-900 text-white p-4 flex items-center">
        <a href="/home" class="text-2xl mr-4">&#8592;</a>
        <h1 class="text-xl font-bold">PROFILE</h1>
    </div>
    
    <div class="container mx-auto mt-10 p-6 bg-blue-900 shadow-lg rounded-lg relative">
    <div class="relative flex justify-center mt-4">
        <label for="profile-upload" class="relative cursor-pointer">
            <img class="h-16 w-16 rounded-full mx-auto" src="https://avatars.githubusercontent.com/u/64538277"
                    alt="avatar" />
            <input type="file" id="profile-upload" class="hidden" accept="image/*" onchange="previewProfileImage(event)">
        </label>
    </div>

        
        <div class="mt-12 p-4">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded-lg shadow">
                <div>
                    <p class="font-semibold">Name :</p>
                    <p class="mt-1">{{$userData->name." ".$userData->surname}}</p>
                </div>
                <div>
                    <p class="font-semibold">User Name:</p>
                    <p class="mt-1">{{$accountData->username}}</p>
                </div>
                <div>
                    <p class="font-semibold">E-mail :</p>
                    <p class="mt-1">{{$accountData->email}}</p>
                </div>
                <div>
                    <p class="font-semibold">Phone :</p>
                    <p class="mt-1">{{$userData->phonenumber}}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Address :</p>
                    <p class="mt-1">{{$userData->address}}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Payment :</p>
                    <p class="mt-1">Visa: {{$userData->fake_BAN}}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
