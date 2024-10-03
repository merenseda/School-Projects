<?php
include('db.php');

// ID ile kişi bilgilerini al
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM rehber WHERE id = ?");
    $stmt->execute([$id]);
    $kisi = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kisi) {
        echo "Kişi bulunamadı!";
        exit();
    }
} else {
    echo "Geçersiz ID!";
    exit();
}
?>

<?php
$editIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg> - Düzenle';

$deleteIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
</svg> - Sil';

$addIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
</svg> - Yeni Kişi Ekle';

$showIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg> - Rehberi Görünrüle';

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kişi Bilgilerini Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <h1 class="text-center text-white">Kişi Bilgilerini Düzenle</h1>
        <form action="guncelle_islem.php" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $kisi['id']; ?>">

            <div class="mb-3">
                <label for="ad" class="form-label text-white">Ad:</label>
                <input type="text" name="ad" value="<?php echo $kisi['ad']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="soyad" class="form-label text-white">Soyad:</label>
                <input type="text" name="soyad" value="<?php echo $kisi['soyad']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefon" class="form-label text-white">Telefon Numarası:</label>
                <input type="number" name="telefon" placeholder="5xx-xxx-xx-xx" maxlength="11" value="<?php echo $kisi['telefon']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ikinci_telefon" class="form-label text-white">İkinci Telefon Numarası:</label>
                <input type="number" name="ikinci_telefon" placeholder="5xx-xxx-xx-xx" maxlength="11" value="<?php echo $kisi['ikinci_telefon']; ?>"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-white">Email:</label>
                <input type="email" name="email" value="<?php echo $kisi['email']; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="grup" class="form-label text-white">Grup:</label>
                <input type="text" name="grup" value="<?php echo $kisi['grup']; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="grup" class="form-label text-white">Adres:</label>
                <input type="text" name="adres" id="adres" class="form-control">
            </div>
            <button type="submit" class="btn btn-success"><?= $editIcon ?></button>
        </form>
        <div class="text-center mt-4">
            <a href="rehber.php" class="btn btn-primary"><?= $showIcon ?></a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>