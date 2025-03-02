<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center h-screen flex justify-center items-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">

    <div class="bg-white bg-opacity-50 backdrop-blur-lg p-12 rounded-2xl shadow-2xl w-96"> 
        <h2 class="text-4xl font-bold text-center text-blue-900 mb-6">LOG IN</h2>
        <form action="/checkLogIn" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">User Name</label>
                <input type="text" name="username" class="w-full p-3 border rounded-lg text-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" class="w-full p-3 border rounded-lg text-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white p-3 rounded-lg text-lg font-semibold shadow-md hover:bg-blue-800 transition">
                SUBMIT
            </button>
        </form>
    </div>
</body>
</html>
