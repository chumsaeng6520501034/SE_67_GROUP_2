<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-cover bg-center h-screen flex justify-center items-center"
    style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-gray-900 p-4 flex items-center space-x-4 z-50 shadow-lg">
        <a href="/" class="text-2xl text-white font-bold pl-4 hover:text-gray-300 transition">
            &#x2190;
        </a>
        <div class="text-2xl text-white font-semibold">TRAVEL & TOUR</div>
    </nav>
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
            @if ($errors->has('login_failed'))
                <div class="bg-red-500 text-white p-4 rounded-md shadow-md mb-4">
                    {{ $errors->first('login_failed') }}
                </div>
            @endif
            <button type="submit"
                class="w-full bg-blue-900 text-white p-3 rounded-lg text-lg font-semibold shadow-md hover:bg-blue-800 transition mt-4">
                SUBMIT
            </button>
        </form>
    </div>
</body>

</html>
