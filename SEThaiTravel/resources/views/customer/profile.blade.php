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
        <a href="#" class="text-2xl mr-4">&#8592;</a>
        <h1 class="text-xl font-bold">PROFILE</h1>
    </div>
    
    <div class="container mx-auto mt-10 p-6 bg-blue-900 shadow-lg rounded-lg relative">
    <div class="relative flex justify-center mt-4">
        <label for="profile-upload" class="relative cursor-pointer">
            <img id="profileImage" src="https://simplyfox.co.uk//wp-content/uploads/2018/08/iStock-640299760-1249910_1080x675.jpg" 
                alt="Profile Picture" class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg">
            <input type="file" id="profile-upload" class="hidden" accept="image/*" onchange="previewProfileImage(event)">
        </label>
    </div>

        
        <div class="mt-12 p-4">
            <div class="grid grid-cols-2 gap-4 bg-gray-100 p-4 rounded-lg shadow">
                <div>
                    <p class="font-semibold">Name :</p>
                    <p class="mt-1">John Doe</p>
                </div>
                <div>
                    <p class="font-semibold">Birthday :</p>
                    <p class="mt-1">01/01/1990</p>
                </div>
                <div>
                    <p class="font-semibold">E-mail :</p>
                    <p class="mt-1">johndoe@example.com</p>
                </div>
                <div>
                    <p class="font-semibold">Phone :</p>
                    <p class="mt-1">123-456-7890</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Address :</p>
                    <p class="mt-1">123 Street, City, Country</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="font-semibold">Payment :</p>
                    <p class="mt-1">Visa - **** 1234</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
