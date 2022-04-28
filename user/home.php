<?php 
include "../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_user_login())
{   
    header('location: ../user_login.php');
}

//get all the category
$category_query = "SELECT `name`,`total_books` FROM `category`";
$category_result = mysqli_query($con, $category_query);

//get the query result when the user search for a book 
$queryResult = null;
if(isset($_POST['search'])){
    $search_text = $_POST['search'];
    $search_query = "SELECT `image`,`name`,`ISBN` FROM `books` WHERE `name` = '$search_text'";
    $search_result = mysqli_query($con, $search_query);

    if(mysqli_num_rows($search_result) > 0){
        $queryResult = "Found";
    }else{
        $queryResult = "Not Found";
    }
}

?>

<?php include 'user_header.php' ?>

<div class="hero d-grid">
    <div class="container hero_content pt-5 pb-5 text-center m-auto" style="max-width: 600px">
        <h1 class="fs3 mb-5">Get your favourite books from the library just by searching</h1>

        <form method="post" class="input-group-lg position-relative">
            <span class="search_icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="search" class="form-control ps-5" aria-label="Sizing example input"
                placeholder="Search for books. E.g: rich dad poor dad" aria-describedby="inputGroup-sizing-lg" required>
        </form>
    </div>
</div>

<section class="pt-5 pb-4" style="background: #F9F3EE;">
    <div style="max-width: 1200px; margin:auto">
        <?php 
            if($queryResult == null){
                if(mysqli_num_rows($category_result) > 0){  
                    while($row = mysqli_fetch_assoc($category_result)) { 
                        //if the category is not empty
                        $total_book = $row['total_books'];
                        if($total_book){
                            $category_name = $row['name'];
                            include("./category_section.php");
                        };
                    }
                }else{
                    echo "<div class='fs-3 text-center mt-5'>Nothing to show</div>";
                }   
                
            }else if($queryResult == "Found"){
                while($row = mysqli_fetch_assoc($search_result)) { 
                    echo "<h1 class='fs-4 mb-5'>Search result for <span style='color: #611547' >".$search_text."</span></h1>";
                    
                    echo "<div onclick='passBookID(".$row['ISBN'].")' class='book_card ms-4 me-4'
                    style='max-width: 150px; cursor: pointer'>
                    <img class='rounded book_cover' height='200' width='150' src='../upload/".$row['image']."'alt='image thumbnail'>
                    <h1 class='mt-4 text-truncate fs-6'>".$row['name']."</h1>
                    </div>";
                }
            }else{
                echo "<h1 class='fs-4 mb-5'>Search result for <span style='color: #611547'>".$search_text."</span></h1>";
                echo "<div class='fs-5 mt-5 mb-5'>No book found</div>";
            }
    ?>
    </div>

    <script>
    //take send the book id to the issue page
    function passBookID(book_Id) {
        window.location.href = "book_info.php?id=" + book_Id;
    }
    </script>
</section>

<?php 
 include "../footer.php";
?>