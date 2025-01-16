<?php
session_start(); // Kullanıcı oturumunu başlat
include('db.php'); // Veritabanı bağlantısı

// Puanlama mesajı
$rating_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dükkan_id']) && isset($_POST['speed']) && isset($_POST['price'])) {
    $dükkan_id = $_POST['dükkan_id'];
    $hiz = $_POST['speed'];
    $fiyat = $_POST['price'];
    $kullanici_adi = $_SESSION['kullanici_adi']; // Oturumdan kullanıcı adı al

    // Puan verisini veritabanına ekle
    if ($dükkan_id >= 1 && $dükkan_id <= 12) {
        $stmt = $conn->prepare("INSERT INTO ratings (kullanici_adi, dükkan_id, hiz, fiyat, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("siii", $kullanici_adi, $dükkan_id, $hiz, $fiyat);

        if ($stmt->execute()) {
            $rating_message = "Puanlama başarıyla kaydedildi!";
        } else {
            $rating_message = "Puanlama kaydedilemedi. Lütfen tekrar deneyin.";
        }

        $stmt->close();
    } else {
        $rating_message = "Geçersiz dükkan ID. Lütfen 1 ile 12 arasında bir değer girin.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puanlama Sonucu</title>
</head>
<body>
    <div class="container">
        <?php if ($rating_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $rating_message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
