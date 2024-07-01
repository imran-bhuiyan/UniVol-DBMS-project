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
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('details');


        function closeDropdowns() {
            dropdowns.forEach(dropdown => {
                dropdown.removeAttribute('open');
            });
        }


        document.body.addEventListener('click', function(event) {
            const target = event.target;


            if (!target.closest('details')) {
                closeDropdowns();
            }
        });


        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });

    function logout() {

        window.location.href = 'admin_logout.php';
    }
    </script>

</head>

<body class="max-w-7xl mx-auto">

    <section class="bg-white">
        <nav>
            <div class="text-white  flex p-4  gap-4">
                <div class="text-3xl bg-gray-900 text-center  flex-1 rounded-xl ">
                    <h1 class="mt-4 ">ADMIN PANEL</h1>
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
                                <li><a href="admin_see_pages.php">Settings</a></li>
                                <i class="fa-solid fa-gear mt-2"></i>
                            </div>

                            <div class="flex">
                                <li><a href=" admin_logout.php">Logout</a></li>
                                <i class="fa-solid fa-right-from-bracket mt-2 ml-2"></i>

                            </div>


                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </nav>
    </section>
    <!-- navbar  -->
    <section>
        <div class="navbar bg-base-100">
            <div class="navbar-start">
                <a class="btn btn-ghost text-xl" href="admin_dashboard.php">Home</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">

                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="admin_vol_page.php">Volunteer</a></li>

                    <!-- dropdrown  -->

                    <li tabindex="0">
                        <details>
                            <summary>Club</summary>
                            <ul class="p-2">
                                <li><a href="admin_create_club.php">Create</a></li>
                                <li><a href="admin_manage_club.php">Manage</a></li>
                            </ul>
                        </details>
                    </li>
                    <!-- end  -->


                    <!-- dropdrown  -->
                    <li tabindex="1">
                        <details>
                            <summary>Authority</summary>
                            <ul class="p-2">
                                <li>
                                    <a href="admin_create_authority.php">Create</a>
                                </li>
                                <li><a href="admin_manage_authority.php">Manage</a></li>
                            </ul>
                        </details>
                    </li>
                    <!-- end  -->
                    <!-- dropdrown  -->
                    <li tabindex="1">
                        <details>
                            <summary>Events</summary>
                            <ul class="p-2">
                                <li><a href="admin_create_event.php">Create</a></li>
                                <li><a href="admin_manage_event.php">Manage</a></li>
                            </ul>
                        </details>
                    </li>
                    <!-- end  -->


                    <li><a href=" admin_event_request.php">Event Request</a></li>
                    <li><a href=" admin_issues.php">Issues</a></li>
                    <li><a href=" admin_queries.php">Queries</a></li>
                    <li><a href="admin_pass_change.php">Change Password</a></li>
                </ul>
            </div>

        </div>

    </section>
</body>

</html>