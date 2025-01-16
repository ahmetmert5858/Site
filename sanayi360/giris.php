<?php
session_start(); // Kullanıcı oturumunu başlatır

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sanayi360";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}

$error_message = ""; // Hata mesajı değişkeni

// Form verisi gönderildiğinde kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini güvenli bir şekilde al
    $kullanici_adi = isset($_POST["username"]) ? $_POST["username"] : null;
    $sifre = isset($_POST["sifre"]) ? $_POST["sifre"] : null;

    if ($kullanici_adi && $sifre) {
        // Kullanıcıyı veritabanında kontrol et
        $sql = "SELECT rol FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $kullanici_adi, $sifre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Kullanıcı bulundu, oturum bilgilerini ayarla
            $row = $result->fetch_assoc();
            $_SESSION["kullanici_adi"] = $kullanici_adi;
            $_SESSION["rol"] = $row["rol"];
            $_SESSION["admin_logged_in"] = ($row["rol"] == "admin"); // admin_logged_in oturum değişkenini ayarla

            // Kullanıcının rolüne göre yönlendirme yap
            if ($row["rol"] == "kullanici") {
                header("Location: anasayfa.php");
            } elseif ($row["rol"] == "admin") {
                header("Location: admin_dashboard.php");
            } elseif ($row["rol"] == "dukkan_sahibi") {
                header("Location: dukkan_sahibi.php");
            }
            exit();
        } else {
            // Hata mesajı kullanıcı adı veya şifre yanlışsa
            $error_message = "Kullanıcı adı veya şifre yanlış.";
        }
    } else {
        // Hata mesajı, kullanıcı adı ve şifre boş ise
        $error_message = "Lütfen kullanıcı adı ve şifre giriniz.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <script>
        // PHP'den gelen hata mesajını alıp pop-up olarak göster ve yönlendir
        <?php if (isset($error_message) && $error_message): ?>
            alert("<?php echo $error_message; ?>");
            window.location.href = 'index.html'; // Hata sonrası index.html'ye yönlendir
        <?php endif; ?>
    </script>
</head>
<body>
    <h1>Giriş Yap</h1>
    <form method="POST" action="giris.php">
        <label for="kullanici_adi">Kullanıcı Adı:</label>
        <input type="text" id="kullanici_adi" name="username" required>
        <br>
        <label for="sifre">Şifre:</label>
        <input type="password" id="sifre" name="sifre" required>
        <br>
        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>
