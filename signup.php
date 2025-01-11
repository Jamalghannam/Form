
<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password =$_POST['password'];
//     $confirm_password =$_POST['confirm_password'];

    
//     echo "Name: $name<br>";
//     echo "Email: $email<br>";
//     echo "Password: $password<br>";
//     echo "Confirm Password: $confirm_password<br>";

    
//     if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
//         echo "All fields are required.";
//     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         echo "Invalid email format.";
//     } elseif ($password !== $confirm_password) {
//         echo "Passwords do not match.";
//     } else {
//         echo "Welcome, $name!";
//     }

//     $gender = $_POST["gender"] ?? "";

//     if ($gender === "male") {
//         echo "male";
//     } elseif ($gender === "female") {
//         echo "female";
//     } else {
//         echo "not female";
//     }

//     echo $_POST["birthday"];;
//     session_start();

// if (isset($_SESSION['user_email'])) {
//     echo "Welcome, " . $_SESSION['user_name'];
// } else {
//     echo "You are not logged in.";
// }




// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];


//     $_SESSION['user_email'] = $email;
//     $_SESSION['user_name'] = $name;
//     header("Location: auth.php");
//     exit();
// }
// }
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password =$_POST['password'];
//     $confirm_password =$_POST['confirm_password'];
// $query= "INSERT INTO users( name , email, password, gender, birthday, agree_terms, created_at)  
// VALUES ('$name','$email','$password',male,'2002-11-02','Yes',Now())";




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userauthentication";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

    $query = "INSERT INTO users (name, email, password, gender, birthday, agree_terms, created_at) 
              VALUES (:name, :email, :password, :gender, :birthday, :agree_terms, Now())";

    $stmt = $conn->prepare($query);

    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
    $gender = htmlspecialchars($_POST['gender'] ?? '');
    $birthday = htmlspecialchars($_POST['birthday'] ?? '');
    $agree_terms = isset($_POST['agree_terms']) ? "Yes" : "No";

    if (!$name || !$email || !$password || !$gender || !$birthday) {
        throw new Exception("Invalid input.");
    }

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':agree_terms', $agree_terms);

    $stmt->execute();
    echo "Record inserted successfully!";
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Validation Error: " . $e->getMessage();
}

$conn = null;




?>








