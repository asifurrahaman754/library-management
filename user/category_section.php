<?php 
    //get all the books from the categories
    $get_books_sql = "SELECT `image`,`name`, `ISBN` FROM `books` WHERE `category`= '$category_name'";
    $get_books = mysqli_query($con, $get_books_sql);
?>

<div class="mb-5 mt-5">

    <h1 class='fs-4 mb-4 ps-2'><?php echo $category_name ?></h1>

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php   while($row = mysqli_fetch_assoc($get_books)) { ?>

            <div class="swiper-slide">
                <div onclick="passBookID(<?php echo $row['ISBN'] ?>)" class="book_card ms-4 me-4"
                    style="max-width: 150px; cursor: pointer">
                    <img class="rounded book_cover" height="200" width="150" src="../upload/<?php echo $row['image'] ?>"
                        alt="">
                    <h1 class="mt-4 text-black text-truncate fs-6"><?php echo $row['name'] ?></h1>
                </div>
            </div>

            <?php   } ?>

            <script>
            //take send the book id to the issue page
            function passBookID(book_Id) {
                window.location.href = "book_info.php?&id=" + book_Id;
            }
            </script>
        </div>
    </div>
</div>