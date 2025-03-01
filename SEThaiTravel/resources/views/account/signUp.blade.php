<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center h-screen flex justify-center items-center" style="background-image: url('https://my.kapook.com/imagescontent/fb_img/816/s_96528_4076.jpg');">

    <div class="bg-white bg-opacity-50 backdrop-blur-lg p-12 rounded-2xl shadow-2xl w-96"> 
        <h2 class="text-4xl font-bold text-center text-blue-900 mb-6">SIGN UP</h2>
        <form>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">User Name</label>
                <input type="text" name="username" class="w-full p-3 border rounded-lg text-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" class="w-full p-3 border rounded-lg text-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" class="w-full p-3 border rounded-lg text-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Sign up as</label>
                <select name="role" class="w-full p-3 border rounded-lg text-lg" required>
                    <option value="">Select Role...</option>
                    <option value="customer">CUSTOMER</option>
                    <option value="guide">GUIDE</option>
                    <option value="corporation">CORPORATION</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white p-3 rounded-lg text-lg font-semibold shadow-md hover:bg-blue-800 transition">
                SUBMIT
            </button>
        </form>
    </div>
    <script>
        document.getElementById("signup-form").addEventListener("submit", function(event) {
            event.preventDefault();
            let role = document.getElementById("role-select").value;

            if (role === "customer") {
                window.location.href = "#";
            } else if (role === "guide") {
                window.location.href = "#";
            } else if (role === "corporation") {
                window.location.href = "#";
            } else {
                alert("Please select a role.");
            }
        });
    </script>

</body>
</html>
