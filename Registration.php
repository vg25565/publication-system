<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <style>
        /* Custom styles for captcha text */
        #image {
            user-select: none;
            text-decoration: line-through;
            font-style: italic;
            font-size: 1.5rem;
            border: 2px solid red;
            color: red;
        }
    </style>
    <script>
        let captcha;
        function generate() {
            document.getElementById("submit").value = "";
            captcha = document.getElementById("image");
            let uniquechar = "";
            const randomchar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (let i = 0; i < 5; i++) {
                uniquechar += randomchar.charAt(Math.random() * randomchar.length);
            }
            captcha.innerHTML = uniquechar;
        }

        function printmsg() {
            const usr_input = document.getElementById("submit").value;
            if (usr_input === captcha.innerHTML) {
                document.getElementById("key").innerHTML = "Matched";
                document.getElementById("key").classList.add('text-green-500');
                document.getElementById("key").classList.remove('text-red-500');
                generate();
            } else {
                document.getElementById("key").innerHTML = "Not Matched";
                document.getElementById("key").classList.add('text-red-500');
                document.getElementById("key").classList.remove('text-green-500');
                generate();
            }
        }
    </script>
</head>
<body onload="generate()" class="bg-cover bg-center bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-teal-400 text-2xl font-medium mb-6 text-center">Register</h2>
        <form class="space-y-6">
            <input type="text" placeholder="Username" required class="w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-teal-300">
            <input type="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-teal-300">
            <input type="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-teal-300">
            
            <div class="flex items-center space-x-4">
                <input type="text" id="submit" placeholder="Captcha code" required class="w-full p-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-teal-300">
                <div onclick="generate()" class="text-teal-500 cursor-pointer">
                    <i class="fas fa-sync fa-lg"></i>
                </div>
                <div id="image" class="w-28 h-10 flex items-center justify-center border-2 border-red-500"></div>
            </div>
            
            <button type="button" onclick="printmsg()" class="w-full py-3 text-white bg-teal-400 rounded-lg shadow-md hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-300">Register</button>
        </form>
        <p id="key" class="mt-4 text-center"></p>
    </div>
</body>
</html>
