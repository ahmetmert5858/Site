<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_dashboard.php?error=unauthorized");
    exit();
}

require_once 'db.php';

// İstatistikleri alma fonksiyonu
function getStatistics($conn) {
    $stats = [];

    // Kategoriye göre toplam dükkânlar
    $sql = "SELECT kategori, COUNT(*) as count FROM dükkanlar GROUP BY kategori";
    $result = $conn->query($sql);
    $stats['shop_categories'] = $result->fetch_all(MYSQLI_ASSOC);

    // Toplam dükkân sayısı
    $sql = "SELECT COUNT(*) as total_shops FROM dükkanlar";
    $result = $conn->query($sql);
    $stats['total_shops'] = $result->fetch_assoc()['total_shops'];

    // Toplam kullanıcı sayısı (sadece 'kullanici' rolündeki kullanıcılar)
    $sql = "SELECT COUNT(*) as total_users FROM kullanicilar WHERE rol = 'kullanici'";
    $result = $conn->query($sql);
    $stats['total_users'] = $result->fetch_assoc()['total_users'];

    // Onay bekleyen yorumlar
    $sql = "SELECT COUNT(*) as pending_comments FROM comments WHERE onayli = 0";
    $result = $conn->query($sql);
    $stats['pending_comments'] = $result->fetch_assoc()['pending_comments'];

    // Ortalama puanlar
    $sql = "SELECT AVG(hiz) as avg_speed, AVG(fiyat) as avg_price FROM ratings";
    $result = $conn->query($sql);
    $stats['avg_ratings'] = $result->fetch_assoc();

    // İncelenecek yorumlar
    $sql = "SELECT c.*, d.dükkan_ismi FROM comments c 
            JOIN dükkanlar d ON c.dükkan_id = d.dükkan_id 
            WHERE c.onayli = 0";
    $result = $conn->query($sql);
    $stats['comments_for_review'] = $result->fetch_all(MYSQLI_ASSOC);

    // Dükkânları listele
    $sql = "SELECT dükkan_id, dükkan_ismi, kategori FROM dükkanlar";
    $result = $conn->query($sql);
    $stats['shops'] = $result->fetch_all(MYSQLI_ASSOC);

    return $stats;
}

// Dükkân silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_shop'])) {
    $shop_id = $_POST['dükkan_id'];
    
    // Önce ilgili kayıtları sil
    $delete_queries = [
        "DELETE FROM comments WHERE dükkan_id = ?",
        "DELETE FROM ratings WHERE dükkan_id = ?",
        "DELETE FROM dükkanlar WHERE dükkan_id = ?"
    ];
    
    foreach ($delete_queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $shop_id);
        $stmt->execute();
        $stmt->close();
    }
}

$stats = getStatistics($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Yönetim Paneli</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Yönetim Paneli</h1>
            <a href="index.html" class="bg-red-500 text-white px-4 py-2 rounded">Çıkış Yap</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kategoriler Grafiği -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl mb-4">Dükkan Kategorileri</h2>
                <canvas id="shopCategoriesChart"></canvas>
            </div>

            <!-- Hızlı İstatistikler -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl mb-4">Hızlı İstatistikler</h2>
                <p>Toplam Dükkân Sayısı: <strong><?php echo $stats['total_shops']; ?></strong></p>
                <p>Toplam Kullanıcı Sayısı: <strong><?php echo $stats['total_users']; ?></strong></p>
                <p>Onay Bekleyen Yorumlar: <strong><?php echo $stats['pending_comments']; ?></strong></p>
                <p>Ortalama Hız Puanı: <strong><?php echo number_format($stats['avg_ratings']['avg_speed'], 2); ?>/5</strong></p>
                <p>Ortalama Fiyat Puanı: <strong><?php echo number_format($stats['avg_ratings']['avg_price'], 2); ?>/5</strong></p>
            </div>

            <!-- Yorum Onaylama -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl mb-4">Onay Bekleyen Yorumlar</h2>
                <?php foreach ($stats['comments_for_review'] as $comment): ?>
                    <div class="mb-4 p-2 bg-gray-100 rounded">
                        <p><strong><?php echo htmlspecialchars($comment['kullanici_adi']); ?></strong> 
                           - <?php echo htmlspecialchars($comment['dükkan_ismi']); ?></p>
                        <p><?php echo htmlspecialchars($comment['yorum']); ?></p>
                        <div class="mt-2">
                            <form method="post" action="approve_comment.php" class="inline">
                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                <button type="submit" name="action" value="approve" 
                                    class="bg-green-500 text-white px-2 py-1 rounded mr-2">Onayla</button>
                                <button type="submit" name="action" value="reject" 
                                    class="bg-red-500 text-white px-2 py-1 rounded">Reddet</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Dükkânları Silme -->
            <div class="bg-white p-4 rounded shadow col-span-full">
                <h2 class="text-xl mb-4">Dükkânları Yönet</h2>
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 text-left">Dükkan İsmi</th>
                            <th class="p-2 text-left">Kategori</th>
                            <th class="p-2 text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['shops'] as $shop): ?>
                            <tr class="border-b">
                                <td class="p-2"><?php echo htmlspecialchars($shop['dükkan_ismi']); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($shop['kategori']); ?></td>
                                <td class="p-2 text-center">
                                    <form method="post" onsubmit="return confirm('Bu dükkânı silmek istediğinizden emin misiniz?');">
                                        <input type="hidden" name="dükkan_id" value="<?php echo $shop['dükkan_id']; ?>">
                                        <button type="submit" name="delete_shop" 
                                            class="bg-red-500 text-white px-2 py-1 rounded">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Dükkan Kategorileri Grafiği
        var ctx = document.getElementById('shopCategoriesChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [<?php echo '"' . implode('", "', array_column($stats['shop_categories'], 'kategori')) . '"'; ?>],
                datasets: [{
                    data: [<?php echo implode(", ", array_column($stats['shop_categories'], 'count')); ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)', 
                        'rgba(54, 162, 235, 0.6)', 
                        'rgba(255, 206, 86, 0.6)', 
                        'rgba(75, 192, 192, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true,
                title: { display: true, text: 'Dükkan Kategorileri' }
            }
        });
    </script>
</body>
</html>