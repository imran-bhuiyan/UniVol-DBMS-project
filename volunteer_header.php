<!DOCTYPE html>
<html data-theme="cupcake">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.7/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    clifford: '#da373d',
                }
            }
        }
    }

    function logout() {

        window.location.href = 'volunteer_logout.php';
    }
    </script>

</head>

<body class="max-w-7xl mx-auto ">
    <!-- Head -->
    <section class="bg-white">
        <nav>
            <div class="text-white  flex p-4  gap-4">
                <div class="text-3xl bg-gray-900 text-center  flex-1 rounded-xl">
                    <h1 class="mt-4 ">VOLUNTEER PANEL</h1>
                </div>
                <div class=" p-4 gap-4 ">

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-danger btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Tailwind CSS Navbar component"
                                    src="https://i.pinimg.com/564x/8e/0c/fa/8e0cfaf58709f7e626973f0b00d033d0.jpg" />
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52 text-black">


                            <div class="flex">
                                <li><a href="vol_pass_change.php">Change Password</a></li>
                                <i class="fa-solid fa-key mt-2 "></i>
                            </div>
                            <div class="flex">
                                <li><a href="vol_reg_history.php">Registration History</a></li>
                                <i class="fa-solid fa-clock-rotate-left mt-2"></i>

                            </div>

                            <div class="flex">
                                <li><a href="volunteer_logout.php">Logout</a></li>
                                <i class="fa-solid fa-right-from-bracket mt-2 ml-2"></i>

                            </div>


                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </section>
    <!-- navbar  -->
    <section>
        <div class="navbar bg-green-100">
            <div class="navbar-start">
                <a class="btn btn-ghost text-xl" href="vol_social.php">Home</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <!-- this  -->
                    <li><a href="vol_social.php">Social</a></li>
                    <li><a href="vol_upcoming_event.php">Upcoming Events</a></li>
                    <li><a href="vol_event.php">My Event</a></li>
                    <li><a href="vol_badge_info.php">Badges Info</a></li>
                    <li><a href="vol_profile_details.php">My Profile</a></li>
                    <li><a href="vol_announcement.php">Announcement</a></li>
                    <li><a href="vol_leaderboard.php">Leaderboard</a></li>


                </ul>
            </div>

        </div>

    </section>
</body>

</html>