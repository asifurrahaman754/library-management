<?php include "header.php";?>

<div class="home-container">
    <div class="container">
        <h1 class="fs-1 text-center home-title" style="color: #f7d21d">Welcome to Library Management System</h1>
        <p class="text-center">Your all in one management tool for your library</p>
        <p class="text-center fs-3 mt-5 text home-middle-txt">Select one of the process below to proceed</p>

        <p class="text-center down"><i class="fa-solid fa-angles-down"></i></p>

        <div class="row gy-3 process-btn-wrapper">
            <div class="col-sm-6">
                <a href="admin_login.php" class="button d-flex button-admin"><span><i style="margin-right:1rem"
                            class="fa-solid fa-user-astronaut"></i></span> I am an
                    Admin <span style="margin-Left:auto">
                        <i class="fa-solid fa-angle-right"></i></span></a>
            </div>
            <div class="col-sm-6"><a href="user_login.php" class="button d-flex button-user"><span><i
                            style="margin-right:1rem" class="fa-regular fa-user"></i></span> I
                    am an User
                    <span style="margin-Left:auto">
                        <i class="fa-solid fa-angle-right"></i></span></a></div>
        </div>
    </div>
</div>


<?php include "footer.php";?>