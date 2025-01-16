<?php
session_start();

// Veritabanı bağlantısı
$conn = new mysqli('localhost', 'root', '', 'sanayi360');
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Yorum gönderme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['kullanici_adi'])) {
    $yorum = $_POST['comment'];
    $kullanici_adi = $_SESSION['kullanici_adi']; // Oturumdan kullanıcı adı al
    $dükkan_id = $_POST['dükkan_id']; // Formdan gelen dükkan_id değeri

    if (!empty($yorum)) {
        // Yorum verisini veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO comments (yorum, kullanici_adi, dükkan_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $yorum, $kullanici_adi, $dükkan_id);

        if ($stmt->execute()) {
            // Yorum başarılı, ilgili dükkanın sayfasına yönlendir ve başarı mesajı ekle
            header("Location: dükkan.php?id=" . $dükkan_id . "&success=true"); // Yönlendirme ile başarı mesajını ekliyoruz
            exit();
        } else {
            echo "Yorum gönderilemedi. Lütfen tekrar deneyin.";
        }

        $stmt->close();
    } else {
        echo "Lütfen yorum kısmını boş bırakmayın.";
    }
} else {
    echo "Yorum yapabilmek için giriş yapmanız gerekiyor.";
}

$conn->close();
?>
