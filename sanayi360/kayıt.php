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

// Hata mesajı değişkeni
$error_message = "";

// Form verisi gönderildiğinde kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini güvenli bir şekilde al
    $kullanici_adi = isset($_POST['kullanici_adi']) ? trim(htmlspecialchars($_POST['kullanici_adi'])) : '';
    $sifre = isset($_POST['sifre']) ? trim($_POST['sifre']) : '';
    $rol = 'kullanici'; // Varsayılan rol: kullanici

    // Kullanıcı adı veya şifre boş mu?
    if (empty($kullanici_adi) || empty($sifre)) {
        echo "<script>alert('Lütfen tüm alanları doldurun.');</script>";
    } else {
        // Kullanıcı adı daha önce kullanıldı mı kontrol et
        $sql_check = "SELECT * FROM kullanicilar WHERE kullanici_adi = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $kullanici_adi);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Kullanıcı adı mevcutsa hata mesajı göster
            echo "<script>
                    alert('Bu kullanıcı adı zaten mevcut. Lütfen başka bir kullanıcı adı seçin.');
                    window.location.href = 'index.html';
                  </script>";
        } else {
            // Şifre hashlenmeden direkt olarak veritabanına eklenir
            $sql = "INSERT INTO kullanicilar (kullanici_adi, sifre, rol) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $kullanici_adi, $sifre, $rol);

            if ($stmt->execute()) {
                // Kayıt başarılı
                echo "<script>
                        alert('Kayıt başarılı. Giriş yapabilirsiniz.');
                        window.location.href = 'index.html';
                      </script>";
            } else {
                // Hata oluşursa
                echo "<script>alert('Kayıt sırasında bir hata oluştu.');</script>";
            }
        }

        // Statement ve bağlantıyı kapat
        $stmt_check->close();
        $stmt->close();
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
