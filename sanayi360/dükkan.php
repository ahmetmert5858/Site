<?php
session_start();
include('db.php'); // Veritabanı bağlantısı

// Eğer success parametresi varsa başarı mesajı göster
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<div class='alert alert-success' role='alert'>Yorumunuz başarıyla gönderildi!</div>";
}

$dükkan_id = isset($_GET['id']) ? $_GET['id'] : 0; // URL'den dükkan_id'yi al

// Dükkan bilgilerini veritabanından al (dükkan_id'ye göre)
$sql = "SELECT * FROM dükkanlar WHERE dükkan_id = $dükkan_id";
$result = $conn->query($sql);

// Dükkan bilgisi bulunmazsa hata mesajı
if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger' role='alert'>Dükkan bulunamadı.</div>";
    exit();
}

$dükkan = $result->fetch_assoc(); // Dükkan bilgisini al

// Yorumları al
$sql_comments = "SELECT * FROM comments WHERE dükkan_id = $dükkan_id ORDER BY created_at DESC";
$comments_result = $conn->query($sql_comments);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($dükkan['dükkan_ismi']); ?> - Yorumlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sanayi360</a>
        </div>
    </nav>

    <!-- Dükkan Bilgileri -->
    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($dükkan['dükkan_ismi']); ?></h1>
        <p><?php echo htmlspecialchars($dükkan['aciklama']); ?></p>

        <!-- Yorumlar -->
        <h3>Yorumlar</h3>
        <?php if ($comments_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($row = $comments_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($row['kullanici_adi']); ?></strong> <small><?php echo $row['created_at']; ?></small>
                        <p><?php echo nl2br(htmlspecialchars($row['yorum'])); ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Henüz yorum yapılmamış.</p>
        <?php endif; ?>

        <!-- Yorum Gönderme Formu -->
        <?php if (isset($_SESSION['kullanici_adi'])): ?>
            <form action="submit_comment.php" method="POST" class="mt-4">
                <textarea class="form-control" rows="4" name="comment" placeholder="Yorum yapın..." required></textarea>
                <input type="hidden" name="dükkan_id" value="<?php echo $dükkan_id; ?>" />
                <button type="submit" class="btn btn-primary mt-2">Yorum Gönder</button>
            </form>
        <?php else: ?>
            <p>Yorum yapabilmek için <a href="giris.php">giriş yapın</a>.</p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
