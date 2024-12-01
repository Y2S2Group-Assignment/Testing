
<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_springboot';

    $conn = mysqli_connect($servername, $username, $password, "$dbname");
    if(!$conn){
        die("Connection failed caused: " . mysqli_connect_error());
    }
?>