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
        // Redirect to logout.php when the Logout button is clicked
        window.location.href = 'authority_logout.php';
    }
    </script>

</head>

<body class="max-w-7xl mx-auto bg-slate-200">

    <section class="bg-white">
        <nav>
            <div class="text-white  flex p-4  gap-4">
                <div class="text-3xl bg-gray-900 text-center  flex-1 rounded-xl">
                    <h1 class="mt-4 ">AUTHORITY PANEL</h1>
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
                                <li><a href="authority_pass_change.php">Change Password</a></li>
                                <i class="fa-solid fa-key mt-2 "></i>
                            </div>
                            <div class="flex">
                                <li><a href="authority_event_history.php">Event History</a></li>
                                <i class="fa-solid fa-clock-rotate-left mt-2"></i>

                            </div>
                            <div class="flex">
                                <li><a href="authority_my_announcements.php">My Announcements</a></li>
                                <i class="fa-solid fa-bullhorn mt-2"></i>
                            </div>

                            <div class="flex">
                                <li><a href="authority_logout.php">Logout</a></li>
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
        <div class="navbar bg-base-100">
            <div class="navbar-start">
                <a class="btn btn-ghost text-xl" href="authority_event_details.php">Home</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <!-- this  -->
                    <li><a href="authority_event_details.php">Events</a></li>
                    <li><a href="authority_create_event.php">Create Event</a></li>
                    <li><a href="authority_volunteer_list.php">Volunteer List</a></li>
                    <li><a href="authority_complain.php">Complain</a></li>
                    <li><a href="authority_announcement.php">Announcement</a></li>


                    <li><a href="authority_edit_profile.php">My Profile</a></li>
                </ul>
            </div>

        </div>

    </section>
</body>

</html>