<!-- 
$check_email = 'osama@gmail.com';
$check_password = '123456';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

echo $_POST['email'];
echo "<br>";
echo $_POST['password'];
echo '<br>';


}
if($check_email == $_POST['email'] && $check_password == $_POST['password']){
    echo "welcome " . $_POST['email'];
    //header("Location: Test.php");
}
else{
    echo "rong email or password";
}

 -->

<?php


session_start();

try {
    $conn = new PDO("mysql:host=localhost;dbname=userauthentication;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo "Email and password are required.";
            exit();
        }

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if ($user && password_verify($password, $user['password'])) {
        //     $_SESSION['user_email'] = $user['email'];
        //     $_SESSION['user_name'] = $user['name'];

        //     echo "Login successful. Welcome, " . htmlspecialchars($user['name']);
        //     header("Location: dashboard.php");
        //     exit();
        // } else {
        //     echo "Invalid email or password.";
        // } 
        // if ($user) {
        //     if (password_verify($password, $user['password'])) {
        //         $_SESSION['user_email'] = $user['email'];
        //         $_SESSION['user_name'] = $user['name'];
        
        //         echo "Login successful. Welcome, " . htmlspecialchars($user['name']);
        //         header("Location: dashboard.php");
        //         exit();
        //     } else {
        //         echo "Invalid password.";
        //     }
        // } else {
        //     echo "Invalid email.";
        // }
        if ($user) { 
            if (password_verify($password, $user['password'])) { 
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
        
                echo "Login successful. Welcome, " . htmlspecialchars($user['name']);
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid email.";
        }
        
        
    }

    if (isset($_SESSION['user_email'])) {
        echo "Welcome back, " . htmlspecialchars($_SESSION['user_name']);
    } else {
        echo "You are not logged in.";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}



?>

