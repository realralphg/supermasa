<?php
    // Connect to Database
    $conn = mysqli_connect('localhost', 'ralph', 'password', 'super_masa');

    // Check for Connection
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>