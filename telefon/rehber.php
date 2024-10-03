<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telefon Rehberi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

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
?>

<body class='bg-dark'>
    <div class="container mt-5">
        <h1 class="text-center text-white">Telefon Rehberi</h1>

        <!-- Arama Formu -->
        <form action="rehber.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Kişi ara..."
                    aria-label="Kişi ara...">
                <button class="btn btn-primary" type="submit">Ara</button>
                <button class="btn btn-secondary" type="submit" name="clear" value="1">Aramayı Temizle</button>
            </div>
        </form>

        <!-- Sıralama Seçenekleri -->
        <form action="rehber.php" method="GET" class="mb-4">
            <label for="orderSelect" class="text-white">Sıralama:</label>
            <select id="orderSelect" name="order" class="form-select" onchange="this.form.submit()">
                <option value="">Seçin...</option>
                <option value="asc" <?= isset($_GET['order']) && $_GET['order'] === 'asc' ? 'selected' : '' ?>>A'dan Z'ye</option>
                <option value="desc" <?= isset($_GET['order']) && $_GET['order'] === 'desc' ? 'selected' : '' ?>>Z'den A'ya</option>
            </select>
        </form>

        <table class="table table-dark table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Telefon</th>
                    <th>İkinci Telefon</th>
                    <th>Email</th>
                    <th>Grup</th>
                    <th>Adres</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sıralama sorgusu
                $orderQuery = 'ORDER BY id DESC';  // Default sıralama

                if (isset($_GET['order']) && $_GET['order'] === 'asc') {
                    $orderQuery = 'ORDER BY ad ASC';  // A'dan Z'ye sıralama
                } elseif (isset($_GET['order']) && $_GET['order'] === 'desc') {
                    $orderQuery = 'ORDER BY ad DESC';  // Z'den A'ya sıralama
                }

                // Arama sorgusu
                $searchQuery = '';
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $searchQuery = "WHERE ad LIKE '%$search%' OR soyad LIKE '%$search%' OR telefon LIKE '%$search%' OR email LIKE '%$search%' OR adres LIKE '%$search%' OR grup LIKE '%$search%'";
                }

                $query = $db->query("SELECT * FROM rehber $searchQuery $orderQuery");
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['ad'] . "</td>";
                    echo "<td>" . $row['soyad'] . "</td>";
                    echo "<td>" . $row['telefon'] . "</td>";
                    echo "<td>" . $row['ikinci_telefon'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['grup'] . "</td>";
                    echo "<td>" . $row['adres'] . "</td>";
                    echo "<td>
                            <a href='guncelle.php?id=" . $row['id'] . "' class='btn btn-light btn-sm'>" . $editIcon . "</a> 
                            <a href='sil.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>" . $deleteIcon . "</a>
                         </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary"><?= $addIcon ?></a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
                