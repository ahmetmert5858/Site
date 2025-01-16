<?php
// Veritabanından dükkanlar bilgilerini al
$query = "SELECT * FROM dükkanlar";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dükkan Puanlama</title>
</head>
<body>
    <h1>Dükkan Puanlama</h1>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="dukkans">
            <h3><?php echo $row['dükkan_ismi']; ?></h3>
            <form action="puanlama.php" method="POST">
                <input type="hidden" name="dükkan_id" value="<?php echo $row['dükkan_id']; ?>">
                <label for="speed">Hız Puanı:</label>
                <input type="number" name="speed" min="1" max="5" required><br>
                <label for="price">Fiyat Puanı:</label>
                <input type="number" name="price" min="1" max="5" required><br>
                <input type="submit" value="Puanla">
            </form>
        </div>
    <?php endwhile; ?>

</body>
</html>
