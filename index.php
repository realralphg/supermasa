<?php
    
    include('config/db_connect.php');

    // Query for Masas
    $sql = 'SELECT title, ingredients, id FROM masa';

    // Make Query and get result
    $result = mysqli_query($conn, $sql);

    // Fetch a the resulting rows as an array
    $masas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free $result from memory
    mysqli_free_result($result);

    // Close Connection
    mysqli_close($conn);

    // The Explode Function converts comma separated values to arrays
    // explode(',' , $masas['ingredients']);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<h4 class="center white-text"> Masa! </h4>
<div class="container">
    <div class="row">
        <?php foreach($masas as $masa){ ?>
            <div class="col s6 md3">
                <div class="card">
                    <img src="img/forMasa.png" class="masa" style="height: 150px; max-width: 160px;">
                    <div class="card-content center">
                        <h5><?php echo htmlspecialchars($masa['title']); ?></h5>
                        <ul>
                            <?php foreach(explode(',', $masa['ingredients']) as $ing){ ?>
                                <li> <?php echo htmlspecialchars($ing); ?> </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="card-action right-align">
                        <a href="more_info.php?id=<?php echo $masa['id'] ?>" class="brand-text"> More Info</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>
    
</html>