<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - Sanayi360</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #343a40;
            color: white;
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Modal -->
    <div class="modal show" tabindex="-1" style="display: block;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Hakkımızda</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="window.history.back();"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Sanayi 360, kullanıcıların güvenilir sanayi dükkanlarını bulmalarına yardımcı olmak için tasarlanmıştır. Sanayi sektörü ve dükkanlar hakkında detaylı bilgiler sunarak kullanıcıların doğru tercih yapmasını sağlıyoruz.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Geri Dön</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
