<?php
    $serverName = "localhost";
    $username = "Ange";
    $password = "PhPynov2223";

    // Creating a connection
    $conn = new mysqli($serverName, $username, $password);
    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    //creating a database
    $sql = "CREATE DATABASE db";
    if ($conn->query($sql) === TRUE)
    {
        echo "Database created sucessfully";
    }
    else
    {
        echo "Error creating database : " . $conn->error;
    }
    // closing connection
    $conn->close();
?>