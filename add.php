<?php
// Method - POST instead of GET
// Action - add.php - That's the file to process
// Use isset() to check whether the submit button was clicked
// Use if(empty) for first step Validation
// Use filter for emails and REGEX for other fields - Validation
// Echo each corresponding error array under each field in html section 
// Add value to input in html section to hold typed data

include('config/db_connect.php');

// Keep variables empty incase of use before SUBMIT Click
$email = $title = $ingredients = '';

// Associative Array of $errors - Also initializing array elements to ''
$errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');

if(isset($_POST['submit'])){

    // Check Email
    if(empty($_POST['email'])){
        $errors['email'] = 'an email is required <br />';
    }else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'email must be a valid email address <br />';
        }
    }
    
    // Check Title
    if(empty($_POST['title'])){
        $errors['title'] = 'a title is required <br />';
    }else{
        $title = $_POST['title'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title'] = 'Title must be letters and spaces only <br />';
        }
    }
    
    // Check Ingredients
    if(empty($_POST['ingredients'])){
        $errors['ingredients'] = 'at least one ingredient is required <br />';
    }else{
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $errors['ingredients'] = 'Ingredients must be letters and comma separated <br />';
        }
    }

    //Check for Errors and Redirect
    if(array_filter($errors)){
        // Display Errors in Form
    }else{
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // Create SQL
        $sql = "INSERT INTO masa(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

        // Save to DB and check!
        if(mysqli_query($conn, $sql)){
            //success
            header('location: index.php');
        }else{
            //error
            echo 'query error' . mysqli_error($conn);
        }
    }
} // End of POST Check
?>


<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container">
<h4 class="center white-text">Add Masa</h4>
<form class="white" action="add.php" method="POST">
    <label>Your Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
    <div class="red-text"><?php echo $errors['email']; ?></div>

    <label>Masa Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
    <div class="red-text"><?php echo $errors['title']; ?></div>

    <label>Ingredients (comma separated):</label>
    <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>"> 
    <div class="red-text"><?php echo $errors['ingredients']; ?></div>  
    
    <div class="center">
        <input type="submit" name="submit" value="submit" class="btn brand">
    </div>
</form>
</section>

<?php include('templates/footer.php'); ?>
    
</html>