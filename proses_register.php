<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kampus";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kencanadewi44@gmail.com'; 
            $mail->Password   = 'xhbn hcyb mnwx rrqd';      
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
            $mail->Port       = 587;                               

            $mail->setFrom('kencanadewi44@gmail.com', 'Portal Akademik');
            $mail->addAddress($email, $username);                  

            $mail->isHTML(true);
            $mail->Subject = 'Konfirmasi Registrasi Akun';
            $mail->Body    = "<h3>Halo, $username!</h3>
                              <p>Terima kasih telah melakukan registrasi.</p>
                              <p>Akun kamu telah berhasil dibuat di sistem akademik kami.</p>
                              <br>
                              <p>Salam hangat,<br>Tim Admin</p>";

            $mail->send();
            echo "<script>alert('Registrasi sukses! Email konfirmasi telah dikirim.'); window.location.href='index.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Registrasi berhasil, tetapi email gagal dikirim. Error: {$mail->ErrorInfo}'); window.location.href='index.php';</script>";
        }

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>