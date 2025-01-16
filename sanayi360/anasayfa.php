<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanayi360</title>
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        /* Navbar Styles - No changes */
        .navbar {
            background-color: #0044cc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 50px;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
            color: #ffffff !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #f0b400 !important;
        }

        /* Sidebar Styles - Modified */
        .sidebar {
            background-color: #ffffff;
            padding: 20px;
            border-right: 2px solid #ddd;
            height: 100vh; /* Full viewport height */
            position: fixed; /* Fixed positioning */
            top: 0;
            left: 0;
            width: 250px; /* Fixed width */
            z-index: 1000; /* Ensure it's above other content */
            overflow-y: auto; /* Scrollable if content overflows */
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .form-check-label {
            font-size: 1rem;
            color: #555;
        }

        .main-content {
            margin-left: 250px; /* Match sidebar width */
            padding: 20px;
        }

        /* Card Styles - Improved */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%; /* Equal height */
            display: flex;
            flex-direction: column;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            flex-grow: 1;
        }

        .card-text {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 10px;
            flex-grow: 1;
        }

        .btn-primary {
            background-color: #0044cc;
            border: none;
            padding: 8px 15px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 25px;
            transition: background-color 0.3s ease;
            align-self: flex-start;
            margin-top: auto;
        }

        .btn-primary:hover {
            background-color: #f0b400;
        }

        /* Row and Column Adjustments */
        #dükkanlarContainer .row {
            display: flex;
            flex-wrap: wrap;
        }

        #dükkanlarContainer .col-md-4 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#" style="display: flex; align-items: center; justify-content: flex-end; width: 7%;">
            <img src="sanayi360logo" alt="Sanayi360 Logo" style="height: 50px;"> Sanayi360
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="hakkimizda.php">Hakkımızda</a></li>
                <li class="nav-item"><a class="nav-link" href="iletisim.php">İletişim</a></li>
                <li class="nav-item"><a class="nav-link" href="index.html">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>
</nav>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <h3 class="mb-4">Dükkanlar</h3>
                <div class="row g-4">
                    <?php
                    $shops = [
                        ["name" => "Gmy Motor Yenileme", "image" => "SanayiGörseller/cmymotoryenileme/cmy3.jpg", "description" => "Kaliteli motor yenileme hizmetleri.", "link" => "cmy_motor_yenileme.php"],
                        ["name" => "Hasan Egzoz", "image" => "SanayiGörseller/hasanegzoz/hasan1.jpg", "description" => "Kaliteli egzoz hizmetleri ile aracınızın performansını arttırın.", "link" => "hasan_egzoz.php"],
                        ["name" => "Kar Oto Klima", "image" => "SanayiGörseller/karotoklima/kar1.jpg", "description" => "Aracınız için profesyonel klima hizmetleri.", "link" => "kar_oto_klima.php"],
                        ["name" => "Maslakland Otomotiv", "image" => "SanayiGörseller/maslaklandotomotiv/maslakland1.jpg", "description" => "Aracınız için her türlü otomotiv hizmeti.", "link" => "maslakland_otomotiv.php"],
                        ["name" => "Maslak Mekanik", "image" => "SanayiGörseller/maslakmekanik/mekanik1.jpg", "description" => "Her türlü mekanik arıza ve bakım hizmeti.", "link" => "maslak_mekanik.php"],
                        ["name" => "Maslak Oto Döşeme", "image" => "SanayiGörseller/maslakotodöşeme/otodöseme1.jpg", "description" => "Özel oto döşeme hizmetleri ile aracınızın iç mekanını yenileyin.", "link" => "maslak_oto_doseme.php"],
                        ["name" => "Maslak Oto Göçük", "image" => "SanayiGörseller/maslakotogöçük/otogöçük1.jpg", "description" => "Profesyonel oto göçük düzeltme hizmetiyle aracınızın dış yüzeyini yenileyin.", "link" => "maslak_oto_gocuk.php"],
                        ["name" => "Maslak Oto Lastik Rotbalans", "image" => "SanayiGörseller/maslakotolastikrotbalans/rotbalans1.jpg", "description" => "Profesyonel lastik rotbalans hizmeti ile güvenli sürüş sağlayın.", "link" => "maslak_oto_lastik.php"],
                        ["name" => "Maslak Oto Şanzıman", "image" => "SanayiGörseller/maslakotoşanzıman/şanzıman1.jpg", "description" => "Oto şanzıman hizmetleri ile aracınızda mükemmel performans sağlayın.", "link" => "maslak_oto_sanziman.php"],
                        ["name" => "Maslak Turbo", "image" => "SanayiGörseller/maslakturbo/turbo1.jpg", "description" => "Turbo sistemleri ile aracınızda gücü artırın.", "link" => "maslak_turbo.php"],
                        ["name" => "MK Oto Ekspertiz", "image" => "SanayiGörseller/mkotoekspertiz/ekspertiz1.jpg", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz.", "link" => "mk_ekspertiz.php"],
                        ["name" => "PDRC Göçük Düzeltme", "image" => "SanayiGörseller/pdrcgöçükdüzeltme/pdrc1.jpg", "description" => "Uzman ekibimizle aracınızdaki göçükleri profesyonelce düzeltiyoruz.", "link" => "pdrc_gocuk_duzeltme.php"],
                        ["name" => "Akts Motor", "image" => "SanayiGörseller/aktsmotor/202302241.jpg", "description" => "Kaliteli motor yenileme hizmetleri ile araçlarınız için en iyi çözümler.", "link" => "aktsmotor.php"],
                        ["name" => "Ahmet Motor", "image" => "SanayiGörseller/ahmetmotor/ahmet.jpg", "description" => "Kaliteli motor yenileme hizmetleri ile araçlarınız için en iyi çözümler.", "link" => "ahmetmotor.php"],
                        ["name" => "Akademi Ekspertiz", "image" => "SanayiGörseller/akademiekspertiz/akademi.jpg", "description" => "Aracınızın detaylı ekspertiz raporları için", "link" => "akademiekspertiz.php"],
                        ["name" => "Ak Egzoz", "image" => "SanayiGörseller/akegzoz/akegzoz.jpg", "description" => "Egzoz sistemlerinde profesyonel çözümler", "link" => "akegzoz.php"],
                        ["name" => "Altay Klima", "image" => "SanayiGörseller/altayklima/altayklima.jpg", "description" => "Araç içi klima sistemlerinde uzman desteği.", "link" => "altayklima.php"],
                        ["name" => "Bey Motor", "image" => "SanayiGörseller/beymotor/beymotor.jpg", "description" => "Yenilikçi motor yenileme çözümleri", "link" => "beymotor.php"],
                        ["name" => "Detay Ekspertiz", "image" => "SanayiGörseller/detayekspertiz/detay.jpg", "description" => "Aracınızın tüm detayları için güvenilir ekspertiz", "link" => "detayekspertiz.php"],
                        ["name" => "Elite Göçük", "image" => "SanayiGörseller/elitegöcük/elite.jpg", "description" => "Profesyonel oto göçük düzeltme hizmetiyle aracınızın dış yüzeyini yenileyin", "link" => "elitegocuk.php"],
                        ["name" => "Golden Ekspertiz", "image" => "SanayiGörseller/goldenekspertiz/golden.jpg", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz", "link" => "goldenekspertiz.php"],
                        ["name" => "Gözde Göçük", "image" => "SanayiGörseller/gözdegöcük/gözde.webp", "description" => "Profesyonel oto göçük düzeltme hizmetiyle aracınızın dış yüzeyini yenileyin", "link" => "gozdegocuk.php"],
                        ["name" => "Güneş Otomotiv", "image" => "SanayiGörseller/günesotomotiv/günes.jpg", "description" => "Otomotiv sektöründe profesyonel çözümler", "link" => "gunesotomotiv.php"],
                        ["name" => "Güven Otomotiv", "image" => "SanayiGörseller/güvenotomotiv/güven.jpg", "description" => "Otomotiv sektöründe profesyonel çözümler", "link" => "güvenotomotiv.php"],
                        ["name" => "Hızlı Otomotiv", "image" => "SanayiGörseller/hızlıotomotiv/hızlı.webp", "description" => "Otomotiv sektöründe profesyonel çözümler", "link" => "hızlıotomotiv.php"],
                        ["name" => "İlhan Motor", "image" => "SanayiGörseller/ilhanmotor/ilhan.jpg", "description" => "Motor sektöründe profesyonel çözümler", "link" => "ilhanmotor.php"],
                        ["name" => "Kocabaş Egzoz", "image" => "SanayiGörseller/kocabasegzoz/kocabas.webp", "description" => "Kaliteli egzoz hizmetleri ile aracınızın performansını arttırın.", "link" => "kocabasegzoz.php"],
                        ["name" => "Master Göçük", "image" => "SanayiGörseller/mastergöcük/master.webp", "description" => "Uzman ekibimizle aracınızdaki göçükleri profesyonelce düzeltiyoruz.", "link" => "mastergocuk.php"],
                        ["name" => "Mega Egzoz", "image" => "SanayiGörseller/megaegzoz/mega.jpg", "description" => "Kaliteli egzoz hizmetleri ile aracınızın performansını arttırın.", "link" => "megaegzoz.php"],
                        ["name" => "Net Ekspertiz", "image" => "SanayiGörseller/netekspertiz/net.jpg", "description" => "Aracınızın tüm detayları için güvenilir ekspertiz.", "link" => "netekspertiz.php"],
                        ["name" => "Nova Göçük", "image" => "SanayiGörseller/novagöcük/nova.jpg", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz.", "link" => "novagocuk.php"],
                        ["name" => "Onur Klima", "image" => "SanayiGörseller/onurklima/onur.jpg", "description" => "Araç içi klima sistemlerinde uzman desteği.", "link" => "onurklima.php"],
                        ["name" => "Prestij Klima", "image" => "SanayiGörseller/prestijklima/prestij.jpg", "description" => "Araç içi klima sistemlerinde uzman desteği.", "link" => "prestijklima.php"],
                        ["name" => "Serin Klima", "image" => "SanayiGörseller/serinklima/serin.jpg", "description" => "Araç içi klima sistemlerinde uzman desteği.", "link" => "serinklima.php"],
                        ["name" => "Usta Egzoz", "image" => "SanayiGörseller/ustaegzoz/usta.jpg", "description" => "Kaliteli egzoz hizmetleri ile aracınızın performansını arttırın.", "link" => "ustaegzoz.php"],
                        ["name" => "Uzman Ekspertiz", "image" => "SanayiGörseller/uzmanekspertiz/uzman.jpg", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz", "link" => "uzmanekspertiz.php"],
                        ["name" => "VIP Ekspertiz", "image" => "SanayiGörseller/vıpekspertiz/vıp.webp", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz", "link" => "vıpekspertiz.php"],
                        ["name" => "Yıldız Göçük", "image" => "SanayiGörseller/yıldızgöcük/yıldız.jpg", "description" => "Araçlarınızı uzman kadromuzla detaylı olarak inceleyip ekspertiz raporları hazırlıyoruz.", "link" => "yıldızgocuk.php"],
                        ["name" => "Yıldız Otomotiv", "image" => "SanayiGörseller/yıldızotomotiv/yıldız.jpg", "description" => "Otomotiv sektöründe profesyonel çözümler", "link" => "yıldızotomotiv.php"],
                        ];
                    foreach ($shops as $shop) {
                        echo '
                        <div class="col-md-4">
                            <div class="card">
                                <img src="' . $shop['image'] . '" class="card-img-top" alt="' . $shop['name'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $shop['name'] . '</h5>
                                    <p class="card-text">' . $shop['description'] . '</p>
                                    <a href="' . $shop['link'] . '" class="btn btn-primary">Detaylar</a>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
    <div class="container">
        <p>© 2024 Sanayi360. Tüm Hakları Saklıdır.</p>
        <p>
            <a href="hakkimizda.php">Hakkımızda</a> | <a href="iletisim.php">İletişim</a>
        </p>
    </div>
</footer>

<style>
    .footer {
        background-color: #0044cc;
        color: white;
        padding: 15px 0;
        text-align: center;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .footer .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer a {
        color: #f8f9fa;
        text-decoration: none;
    }

    .footer a:hover {
        color: #f0b400;
    }

    .footer p {
        margin: 5px 0;
    }

    @media (max-width: 768px) {
        .footer .container {
            padding: 0 15px;
        }
    }
</style>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth Scroll JavaScript -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>