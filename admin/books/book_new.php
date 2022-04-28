<?php

//get all the exists category
$get_allCat_sql = "SELECT * FROM `category`";
$get_allCat_result = mysqli_query($con, $get_allCat_sql);

//get all the exists location rack
$get_allrack_sql = "SELECT * FROM `location_rack`";
$get_allrack_result = mysqli_query($con, $get_allrack_sql);

$error = "";
$success = "";
if(isset($_POST['submit'])){
    $book_name = $_POST['book_name'];
    $book_author = $_POST['book_author'];
    $category = $_POST['category'];
    $isbn = $_POST['book_isbn'];
    $book_rack = $_POST['book_rack'];
    $copies = $_POST['copies'];
    $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $created_date = $time->format('Y-m-d H:i:s');

    //check if the book name is already exist
    $check_book_sql = "SELECT * FROM `books` WHERE `ISBN` = '$isbn'";
    $check_book_result = mysqli_query($con, $check_book_sql);
    
    if(mysqli_num_rows($check_book_result) > 0){
        $error = "Book already exist!";
    }else{
        // image uploading-----------------------------------------------------
        $book_image_name = $_FILES['fileToUpload']['name'];
        $book_image_tmp = $_FILES['fileToUpload']['tmp_name'];
        $book_image_size = $_FILES['fileToUpload']['size'];
        $allowed_ext = array('jpg', 'jpeg', 'png');
        $book_image_ext = explode('.', $book_image_name);
        $book_image_ext = strtolower(end($book_image_ext));
        

        //if the image extension is not in the allowed format
        if(in_array($book_image_ext, $allowed_ext)){
            //if the image size is less than 5MB
            if($book_image_size < 5000000){
                $book_image = "book_".time().'.'.$book_image_ext;
                $book_image_path = "../../upload/".$book_image;
                move_uploaded_file($book_image_tmp, $book_image_path);
            }else{
                $error = "Image size is too large";
            }
        }else{
            $error = "Image format is not supported";
        }
        // image uploading-----------------------------------------------------

        //check if there is an error uploading the image
        if(!$error){
            $insert_book_sql = "INSERT INTO `books`(`image`,`author`, `name`, `category`, `ISBN`, `location_rack`, `book_copies`, `created`) VALUES ('$book_image','$book_author','$book_name','$category','$isbn','$book_rack','$copies','$created_date')";
            $insert_book_result = mysqli_query($con, $insert_book_sql);

            //increase the number of copies of the book in the category
            $inc_catBooks_sql = "UPDATE `category` SET `total_books` = `total_books` + 1 WHERE `name` = '$category'";
            $inc_catBooks_sql_result = mysqli_query($con, $inc_catBooks_sql);

            //increase the number of copies of the book in the location rack
            $inc_locationBooks_sql = "UPDATE `location_rack` SET `total_books` = `total_books` + '$copies' WHERE `name` = '$book_rack'";
            $inc_locationBooks_sql_result = mysqli_query($con, $inc_locationBooks_sql);


            if($insert_book_result){
                $success = "Book added successfully";
            }else{
                $error = "Adding Book failed";
            }
        }
    }
}

?>

<?php
    if($success != ""){
        echo '<div class="mt-5 m-auto alert alert-success alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$success.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    if($error != ""){
        echo '<div class="mt-5 m-auto alert alert-danger alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$error.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
?>

<div class="card mt-4 m-auto mb-3" style="max-width: 600px">
    <div class="card-header"><i class="fa-solid fa-book me-2"></i> Add new Book</div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="book_name" class="form-label">Book name</label>
                <input type="text" class="form-control" id="book_name" name="book_name" placeholder="Enter Book name"
                    required>
            </div>
            <div class="mb-3">
                <label for="book_author" class="form-label">Book author</label>
                <input type="text" class="form-control" id="book_author" name="book_author"
                    placeholder="Enter Book author" required>
            </div>
            <div class="mb-3">
                <label for="book_isbn" class="form-label">ISBN (International Standard Book
                    Number)</label>
                <input type="text" class="form-control" id="book_isbn" name="book_isbn"
                    placeholder="Enter Book ISBN number" max="20" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option selected value="">---select book category---</option>
                    <?php 
                    if(mysqli_num_rows($get_allCat_result) > 0){  
                        while($row = mysqli_fetch_assoc($get_allCat_result)) { 
                            if($row['status'] == 'Enable'){ ?>
                    <option value='<?php echo $row['name'] ?>'><?php echo $row['name'] ?></option>
                    <?php }
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="book_rack" class="form-label">Location rack</label>
                <select class="form-select" id="book_rack" name="book_rack" required>
                    <option selected value="">---select book location rack---</option>
                    <?php 
                    if(mysqli_num_rows($get_allrack_result) > 0){  
                        while($row = mysqli_fetch_assoc($get_allrack_result)) { ?>
                    <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                    <?php       
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="copies" class="form-label">Book copies</label>
                <input type="number" class="form-control" id="copies" name="copies"
                    placeholder="how many copies do you have?" value="1" required>
            </div>
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Select book cover</label>
                <input type="file" accept=".png, .jpg, .jpeg" class="form-control" id="fileToUpload" name="fileToUpload"
                    required>
            </div>
            <button type="submit" name="submit" class="mt-4 btn btn-primary">Submit</button>
        </form>
    </div>
</div>