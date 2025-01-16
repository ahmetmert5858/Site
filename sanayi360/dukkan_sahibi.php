<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$database = "sanayi360";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Ortalama hız ve fiyat hesaplama
$sql = "
SELECT 
    d.dükkan_ismi,
    AVG(r.hiz) AS ortalama_hiz,
    AVG(r.fiyat) AS ortalama_fiyat
FROM 
    dükkanlar d
JOIN 
    ratings r 
ON 
    d.dükkan_id = r.dükkan_id
GROUP BY 
    d.dükkan_id
";

$result = $conn->query($sql);

// Verileri hazırlama
$shops = [];
$speeds = [];
$prices = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $shops[] = $row['dükkan_ismi'];
        $speeds[] = round($row['ortalama_hiz'], 2);
        $prices[] = round($row['ortalama_fiyat'], 2);
    }
}

// Kategorilere göre en yüksek ortalama hız
$sql_hiz = "
SELECT 
    d.kategori,
    d.dükkan_ismi,
    AVG(r.hiz) AS ortalama_hiz
FROM 
    dükkanlar d
JOIN 
    ratings r 
ON 
    d.dükkan_id = r.dükkan_id
GROUP BY 
    d.kategori, d.dükkan_id
ORDER BY 
    d.kategori, ortalama_hiz DESC
";

$result_hiz = $conn->query($sql_hiz);
$top_hiz = [];
if ($result_hiz->num_rows > 0) {
    while ($row = $result_hiz->fetch_assoc()) {
        $top_hiz[$row['kategori']][] = [
            'dükkan' => $row['dükkan_ismi'],
            'ortalama_hiz' => round($row['ortalama_hiz'], 2)
        ];
    }
}

// Kategorilere göre en yüksek ortalama fiyat
$sql_fiyat = "
SELECT 
    d.kategori,
    d.dükkan_ismi,
    AVG(r.fiyat) AS ortalama_fiyat
FROM 
    dükkanlar d
JOIN 
    ratings r 
ON 
    d.dükkan_id = r.dükkan_id
GROUP BY 
    d.kategori, d.dükkan_id
ORDER BY 
    d.kategori, ortalama_fiyat DESC
";

$result_fiyat = $conn->query($sql_fiyat);
$top_fiyat = [];
if ($result_fiyat->num_rows > 0) {
    while ($row = $result_fiyat->fetch_assoc()) {
        $top_fiyat[$row['kategori']][] = [
            'dükkan' => $row['dükkan_ismi'],
            'ortalama_fiyat' => round($row['ortalama_fiyat'], 2)
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dükkan Sahibi Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            background-color: #f4f4f9;
            color: #333;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            position: fixed;
            padding: 20px 10px;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 1px solid #7f8c8d;
            padding-bottom: 10px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #ecf0f1;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background-color: #34495e;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            flex: 1;
        }
        .dashboard-title {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .chart-container, .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .chart-container h3, .table-container h3 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #34495e;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dükkan Sahibi Paneli</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Ayarlar</a></li>
            <li><a href="index.html">Çıkış Yap</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="dashboard-title">Dükkan Sahibi Dashboard</div>
        
        <div class="chart-container">
            <h3>Ortalama Hız (Çubuk Grafik)</h3>
            <canvas id="barChartSpeed"></canvas>
        </div>

        <div class="chart-container">
            <h3>Ortalama Fiyat (Çubuk Grafik)</h3>
            <canvas id="barChartPrice"></canvas>
        </div>
        
        <div class="table-container">
            <h3>Kategorilere Göre En Yüksek Ortalama Hız</h3>
            <?php foreach ($top_hiz as $kategori => $dükkanlar): ?>
                <h4>Kategori: <?php echo htmlspecialchars($kategori); ?></h4>
                <table>
                    <thead>
                        <tr>
                            <th>Dükkan</th>
                            <th>Ortalama Hız</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dükkanlar as $dükkan): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dükkan['dükkan']); ?></td>
                                <td><?php echo htmlspecialchars($dükkan['ortalama_hiz']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>

        <div class="table-container">
            <h3>Kategorilere Göre En Yüksek Ortalama Fiyat</h3>
            <?php foreach ($top_fiyat as $kategori => $dükkanlar): ?>
                <h4>Kategori: <?php echo htmlspecialchars($kategori); ?></h4>
                <table>
                    <thead>
                        <tr>
                            <th>Dükkan</th>
                            <th>Ortalama Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dükkanlar as $dükkan): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dükkan['dükkan']); ?></td>
                                <td><?php echo htmlspecialchars($dükkan['ortalama_fiyat']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const shops = <?php echo json_encode($shops); ?>;
        const speeds = <?php echo json_encode($speeds); ?>;
        const prices = <?php echo json_encode($prices); ?>;

        // Ortalama Hız (Çubuk Grafik)
        new Chart(document.getElementById('barChartSpeed'), {
            type: 'bar',
            data: {
                labels: shops,
                datasets: [{
                    label: 'Ortalama Hız',
                    data: speeds,
                    backgroundColor: 'rgba(52, 152, 219, 0.5)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Ortalama Fiyat (Çubuk Grafik)
        new Chart(document.getElementById('barChartPrice'), {
            type: 'bar',
            data: {
                labels: shops,
                datasets: [{
                    label: 'Ortalama Fiyat',
                    data: prices,
                    backgroundColor: 'rgba(231, 76, 60, 0.5)',
                    borderColor: 'rgba(231, 76, 60, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
