<?php

$get_sql = "SELECT `name` FROM `library_settings` WHERE 1";
$get_name = mysqli_query($con, $get_sql);
$get_name_row = mysqli_fetch_assoc($get_name);

?>

<div class="admin_panel_wrapper">
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" style="padding: 0 20px !important">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 pe-3 library-name" href="#">
            <i class="fa-solid fa-book-open"></i> &nbsp;<?php echo $get_name_row['name']?>
        </a>

        <div class="flex-shrink-0 dropdown ms-sm-auto">
            <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" id="dropdownUser2"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-user me-1"></i>
            </a>
            <ul id="admin-options" class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2"
                style="right: 0; left: auto">
                <li><a class="dropdown-item" href="../options/profile.php">Admin profile</a></li>
                <li><a class="dropdown-item" href="../options/library_settings.php">Library settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../options/logout.php">Sign out</a></li>
            </ul>
        </div>

        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="mt-4 mt-md-0 col-md-3 col-lg-2 d-md-block bg-light admin_sidebar collapse"
                style="">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($this_page == "home" ? active : "") ?>" aria-current="page"
                                href="../dashboard/index.php">
                                <i class="fa-solid fa-house me-2"></i>
                                Dashboard
                            </a>
                            <a class="nav-link <?php echo ($this_page == "category" ? active : "") ?>"
                                aria-current="page" href="../category/category.php">
                                <i class="fa-solid fa-table-list me-2"></i>
                                Category
                            </a>
                            <a class="nav-link <?php echo ($this_page == "rack" ? active : "") ?>" aria-current="page"
                                href="../location_rack/location_rack.php">
                                <i class="fa-solid fa-window-maximize me-2"></i>
                                Location Rack
                            </a>
                            <a class="nav-link <?php echo ($this_page == "books" ? active : "") ?>" aria-current="page"
                                href="../books/books.php">
                                <i class="fa-solid fa-book me-2"></i>
                                Books
                            </a>
                            <a class="nav-link <?php echo ($this_page == "users" ? active : "") ?>" aria-current="page"
                                href="../users/users.php">
                                <i class="fa-solid fa-users me-2"></i>
                                Users
                            </a>
                            <a class="nav-link <?php echo ($this_page == "book_issue" ? active : "") ?>"
                                aria-current="page" href="../Issues/index.php">
                                <i class="fa-solid fa-book-open-reader me-2"></i>
                                Issued books
                            </a>
                            <a class="nav-link <?php echo ($this_page == "book_fine" ? active : "") ?>"
                                aria-current="page" href="../fine/index.php">
                                <i class="fa-solid fa-money-check-dollar me-2"></i>
                                Fine
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">