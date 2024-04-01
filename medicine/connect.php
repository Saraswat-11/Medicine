<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "test1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Check if password is not empty
    if (!empty($password)) {

        // Check if someone is already registered with the given email
        $stmt = $conn->prepare("SELECT email FROM registration WHERE email = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // No user found with the given email, proceed to insert into 'registration' table
            $stmt = $conn->prepare("INSERT INTO registration (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $username, $email, $password);

            if ($stmt->execute() === TRUE) {
               
                // Redirect to index.html
                header("Location: index.html");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Someone Already Registered Using This Email";
        }
    } else {
        echo "Please Fill The Whole Form";
    }
}

$conn->close();
?>