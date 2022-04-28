<?php 
//get the library name
$library_name_query = "SELECT `name` FROM `library_settings` WHERE 1";
$library_name = mysqli_fetch_assoc(mysqli_query($con, $library_name_query));
?>

<header class="d-flex ps-3 pe-3 fw-bold fs-6 pt-2 pb-2 text-center text-white text-uppercase"
    style="background: #611547">
    <a href="home.php"
        class="text-white text-truncate flex-grow-1 flex-shrink-1"><?php echo $library_name['name']; ?></a>

    <div class="ms-md-auto d-flex me-2 ms-2">
        <a href="profile.php" class="text-white" style="cursor: pointer"><i class="fa-solid fa-user"></i></a>
        <a data-bs-toggle="tooltip" data-bs-placement="left" title="issued book list" href="book_issue.php"
            class="text-white ms-3" style="cursor: pointer"><i class="fa-solid fa-book"></i></a>
    </div>
</header>