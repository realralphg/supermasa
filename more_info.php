<?php
include('config/db_connect.php');

// Check GET request id param
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Make SQL
    $sql = "SELECT * FROM masa WHERE id = $id";

    // Get query result
    $result = mysqli_query($conn, $sql);

    // Fetch result in array format
    $masa = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}

// Coding for DELETE
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM masa WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: index.php');
    }else{
        echo 'query error' . mysqli_error($conn);
    }
}
?>

<html>
<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if($masa){  ?>
        <h4><?php echo htmlspecialchars($masa['title']) ?></h4>
        <p>Created by: <?php echo htmlspecialchars($masa['email']) ?></p>
        <p><?php echo date($masa['created_at']) ?></p>
        <h5>Ingredients: </h5>
        <p><?php echo htmlspecialchars($masa['ingredients']) ?></p>

        <?php //Creating Delete Button and hidden field to hold ID ?>
        <form action="more_info.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $masa['id'] ?>">
            <input type="submit" name="delete" value="Delete" class="btn brand">
        </form>

    <?php }else{ ?>
        <h5> No Such Masa Exists! </h5>
    <?php } ?>
</div>

<?php include('templates/footer.php'); ?>
</html>