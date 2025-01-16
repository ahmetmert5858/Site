<?php
session_start(); // Kullanıcı oturumunu başlat
include('db.php'); // Veritabanı bağlantısı

// Kullanıcı giriş yapmamışsa popup göster
if (!isset($_SESSION['kullanici_adi'])) {
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giriş veya Devam Et</title>
        <style>
            /* Modal Stil */
            .modal {
                display: block; /* Başlangıçta görünür */
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }
            .modal-content {
                background-color: #fff;
                margin: 15% auto;
                padding: 20px;
                border-radius: 8px;
                width: 80%;
                max-width: 400px;
                text-align: center;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
            .modal-content h2 {
                margin-bottom: 15px;
            }
            .modal-content button {
                padding: 10px 20px;
                margin: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            .btn-login {
                background-color: #4CAF50;
                color: white;
            }
            .btn-continue {
                background-color: #008CBA;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="modal">
            <div class="modal-content">
                <h2>Giriş Yapmadınız</h2>
                <p>Devam etmek için lütfen bir seçenek belirleyin:</p>
                <button class="btn-login" onclick="window.location.href='index.html';">Giriş Yap</button>
                <button class="btn-continue" onclick="window.location.href='anasayfa.php';">Anasayfada Gezinmeye Devam Et</button>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit(); // Kodun devamını çalıştırma
}
// Yorum gönderme mesajı
$comment_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $yorum = trim($_POST['comment']); // Yorum alanından gereksiz boşlukları temizle
    $kullanici_adi = $_SESSION['kullanici_adi']; // Oturumdan kullanıcı adı al
    $dükkan_id = 35; // Bu dükkanın ID'si 

    if (!empty($yorum)) {
        // Yorum verisini veritabanına onaysız olarak ekle
        $stmt = $conn->prepare("INSERT INTO comments (yorum, kullanici_adi, dükkan_id, onayli) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("ssi", $yorum, $kullanici_adi, $dükkan_id);

        if ($stmt->execute()) {
            $comment_message = "Yorumunuz başarıyla gönderildi ve onay bekliyor.";
        } else {
            $comment_message = "Yorum gönderilemedi. Lütfen tekrar deneyin.";
        }

        $stmt->close();
    } else {
        $comment_message = "Yorum boş bırakılamaz.";
    }
}

// Değerlendirme gönderme mesajı
$rating_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['speed']) && isset($_POST['price'])) {
    $speed = (int)$_POST['speed'];
    $price = (int)$_POST['price'];
    $kullanici_adi = $_SESSION['kullanici_adi']; // Oturumdan kullanıcı adı al
    $dükkan_id = 35; // Dükkan ID

    if ($speed > 0 && $price > 0) {
        // Değerlendirmeyi veritabanına kaydet
        $stmt = $conn->prepare("INSERT INTO ratings (hiz, fiyat, kullanici_adi, dükkan_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $speed, $price, $kullanici_adi, $dükkan_id);

        if ($stmt->execute()) {
            $rating_message = "Değerlendirmeniz başarıyla gönderildi!";
        } else {
            $rating_message = "Değerlendirme gönderilemedi. Lütfen tekrar deneyin.";
        }

        $stmt->close();
    } else {
        $rating_message = "Hız ve fiyat değerleri pozitif olmalıdır.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usta Egzoz</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-background: #E0E0E0;
            --text-color: #2c3e50;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
            background-color: var(--light-background);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            letter-spacing: 1px;
        }

        .container {
            max-width: 1200px;
            padding: 0 15px;
        }

        h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            text-align: center;
        }

        h1::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background-color: var(--accent-color);
            margin: 10px auto;
            border-radius: 2px;
        }

        .carousel-inner {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .carousel-inner img {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
    object-fit: contain; /* Görselin taşmasını önler */
}

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }

        .form-section, 
        .comment-section {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-top: 30px;
        }

        .form-control, 
        .form-select {
            border-color: var(--accent-color);
            border-radius: 6px;
            padding: 12px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 6px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .comment-section h4 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
        }

        .map-placeholder {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            margin-top: 30px;
        }

        .map-placeholder iframe {
            width: 100%;
            height: 400px;
            border: 0;
            filter: grayscale(20%) contrast(110%);
        }

        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }

        .footer a {
            color: var(--accent-color);
            margin: 0 10px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .carousel-inner img {
                height: 300px;
            }

            .form-section, 
            .comment-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="anasayfa.php">Sanayi360</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="hakkimizda.php">Hakkımızda</a></li>
                    <li class="nav-item"><a class="nav-link" href="iletisim.php">İletişim</a></li>
                </ul>
            </div>
        </div>
    </nav>

            <!-- Content -->
    <div class="container">
        <h1>Usta Egzoz</h1>
        <p class="text-center text-muted">Kaliteli egzoz hizmetleri ile aracınızın performansını arttırın</p>

        <!-- Image Gallery -->
        <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="SanayiGörseller/ustaegzoz/usta1.jpg" class="d-block w-100" alt="Hasan Egzoz 1">
                </div>
                <div class="carousel-item">
                    <img src="SanayiGörseller/ustaegzoz/usta.jpg" class="d-block w-100" alt="Hasan Egzoz 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Önceki</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sonraki</span>
            </button>
        </div>

        <!-- Yorum Başarı Mesajı -->
        <?php if ($comment_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $comment_message; ?>
            </div>
        <?php endif; ?>

        <!-- Değerlendirme Başarı Mesajı -->
        <?php if ($rating_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $rating_message; ?>
            </div>
        <?php endif; ?>

        <!-- Değerlendirme Formu -->
<div class="mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-2">
            <h4 class="mb-0" style="font-size: 1.1rem;">Dükkan Değerlendirmesi</h4>
        </div>
        <div class="card-body">
            <?php
            // Ortalama puanları hesapla
            $dükkan_id = 35;
            $sql = "SELECT AVG(hiz) as ort_hiz, AVG(fiyat) as ort_fiyat FROM ratings WHERE dükkan_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $dükkan_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            $ort_hiz = number_format($row['ort_hiz'], 1);
            $ort_fiyat = number_format($row['ort_fiyat'], 1);
            ?>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="border rounded p-2 text-center">
                        <div class="small text-muted mb-1">Ortalama Hız</div>
                        <div class="h5 mb-0 text-primary"><?php echo $ort_hiz; ?><small class="text-muted">/5</small></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-2 text-center">
                        <div class="small text-muted mb-1">Ortalama Fiyat</div>
                        <div class="h5 mb-0 text-primary"><?php echo $ort_fiyat; ?><small class="text-muted">/5</small></div>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="speedRating" class="form-label small">Hız:</label>
                        <select id="speedRating" class="form-select form-select-sm" name="speed">
                            <option value="" selected disabled>Puan Verin</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="priceRating" class="form-label small">Fiyat:</label>
                        <select id="priceRating" class="form-select form-select-sm" name="price">
                            <option value="" selected disabled>Puan Verin</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Değerlendirme Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Yorumlar -->
        <div class="comment-section">
            <h4>Yorumlar</h4>
            <?php
            // Yorumları veritabanından al ve listele 
$dükkan_id = 35; // dükkan ID'si
$sql = "SELECT kullanici_adi, yorum, created_at FROM comments WHERE dükkan_id = ? AND onayli = 1 ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dükkan_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='mb-3'>";
        echo "<strong>" . htmlspecialchars($row['kullanici_adi']) . "</strong> (" . $row['created_at'] . ")";
        echo "<p>" . htmlspecialchars($row['yorum']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Henüz yorum yapılmamış.</p>";
}
$stmt->close();

            ?>

            <!-- Yorum Gönderme -->
            <h4>Yorum Yap</h4>
            <form action="" method="POST">
                <div class="mb-3">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Yorumunuzu buraya yazın..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Yorum Gönder</button>
            </form>
        </div>

                    <!-- Harita -->
<div class="map-placeholder">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3058.8205371673025!2d29.00412431540256!3d41.11356617929014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa011c1e5c123%3A0x90c9d3f0db59bba!2sMaslak%20Oto%20Sanayi%20Sitesi!5e0!3m2!1str!2str!4v1234567890!5m2!1str!2str" 
        width="100%" 
        height="300" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Sanayi360. Tüm hakları saklıdır. 
        <a href="https://twitter.com">Twitter</a> | 
        <a href="https://facebook.com">Facebook</a> | 
        <a href="https://instagram.com">Instagram</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>