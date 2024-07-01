<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVol</title>
    <!-- Link to the Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="index.php">
                <img src="logo/logo3.png" alt="UniVol Logo" class="h-20 ">
            </a>

            <div class="flex list-none text-black font-bold">
                <li><a href=" index.php" class="block px-4 py-2 hover:bg-gray-300 transition duration-300">HOME</a></li>
                <li><a href="index_event.php"
                        class="block px-4 py-2 hover:bg-gray-300 transition duration-300">EVENTS</a></li>
                <li><a href="index_about_us.php" class="block px-4 py-2 hover:bg-gray-300 transition duration-300">ABOUT
                        US</a></li>
                <li><a href="index_top_vol.php" class="block px-4 py-2 hover:bg-gray-300 transition duration-300">TOP
                        CONTRIBUTOR</a></li>
                <li><a href="index_contact_us.php"
                        class="block px-4 py-2 hover:bg-gray-300 transition duration-300">CONTACT US</a></li>
            </div>
            <div class="relative group">
                <button class="btn brand-dropdown-trigger bg-white hover:text-white text-black rounded-full px-6 py-2"
                    onclick="toggleDropdown()">Login<i class="material-icons right"></i></button>
                <ul id="login-dropdown"
                    class="dropdown-content hidden absolute bg-blue-400 text-white rounded-md shadow-md mt-2 space-y-2 w-52">
                    <li><a href="VolunteerLogin.php"
                            class="block px-4 py-2 hover:bg-gray-300 transition duration-300">Volunteer</a></li>
                    <li><a href="ClubLogin.php"
                            class="block px-4 py-2 hover:bg-gray-300 transition duration-300">Club</a></li>
                    <li><a href="AuthorityLogin.php"
                            class="block px-4 py-2 hover:bg-gray-300 transition duration-300">Authority</a></li>
                    <li><a href="AdminLogin.php"
                            class="block px-4 py-2 hover:bg-gray-300 transition duration-300">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
    // Toggle dropdown visibility
    function toggleDropdown() {
        var dropdown = document.getElementById('login-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('login-dropdown');
        if (!event.target.closest('.group') && !event.target.closest('.dropdown-content')) {
            dropdown.classList.add('hidden');
        }
    });
    </script>
</body>

</html>