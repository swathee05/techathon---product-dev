<?php
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$Email = $_POST['Email'];

if (!empty($Username) || !empty($Password) || !empty($Email)) {

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "techathon";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT uname FROM signnup WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum > 0) {
            echo "Account already exists";
        } else {
            $stmt->close();
            $INSERT = "INSERT INTO signnup (uname, pwd, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $Username, $Password, $Email);
            
            if ($stmt->execute()) {
                echo "Account registered successfully";
            } else {
                echo "Account already exists";
            }
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required ";
    die();
}
?>
