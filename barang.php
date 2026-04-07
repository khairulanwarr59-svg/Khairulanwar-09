<?php
$file = 'barang.json';
$data_barang = json_decode(file_get_contents($file), true);

// Tambah/Update Barang
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $index = -1;
    foreach($data_barang as $key => $b) if($b['id'] == $id) $index = $key;

    $item = ["id" => $id, "nama" => $_POST['nama'], "harga" => (int)$_POST['harga'], "stok" => (int)$_POST['stok']];
    
    if($index !== -1) $data_barang[$index] = $item; // Edit jika ID sama
    else $data_barang[] = $item; // Tambah jika ID baru

    file_put_contents($file, json_encode($data_barang, JSON_PRETTY_PRINT));
    header("Location: barang.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventaris - PT ESHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; padding-top: 50px; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="glass p-4 shadow">
                <h5 id="form-title">Form Barang</h5>
                <form method="POST">
                    <input type="text" name="id" id="id" class="form-control mb-2" placeholder="ID Barang" required>
                    <input type="text" name="nama" id="nama" class="form-control mb-2" placeholder="Nama Barang" required>
                    <input type="number" name="harga" id="harga" class="form-control mb-2" placeholder="Harga" required>
                    <input type="number" name="stok" id="stok" class="form-control mb-2" placeholder="Stok" required>
                    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Data</button>
                    <a href="barang.php" class="btn btn-sm btn-link text-white mt-2">Reset Form</a>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="glass p-4">
                <table class="table table-dark table-hover">
                    <thead><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach($data_barang as $b): ?>
                        <tr>
                            <td><?= $b['id'] ?></td>
                            <td><?= $b['nama'] ?></td>
                            <td>Rp<?= number_format($b['harga']) ?></td>
                            <td><?= $b['stok'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='edit(<?= json_encode($b) ?>)'>Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function edit(data) {
        document.getElementById('id').value = data.id;
        document.getElementById('nama').value = data.nama;
        document.getElementById('harga').value = data.harga;
        document.getElementById('stok').value = data.stok;
        document.getElementById('form-title').innerText = "Edit Barang: " + data.nama;
    }
</script>
</body>
</html>
<?php
$file = 'barang.json';
$barang = json_decode(file_get_contents($file), true);

// Proses Simpan/Update
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $exists = false;
    foreach ($barang as $key => $b) {
        if ($b['id'] == $id) {
            $barang[$key] = ["id"=>$id, "nama"=>$_POST['nama'], "harga"=>(int)$_POST['harga'], "stok"=>(int)$_POST['stok']];
            $exists = true; break;
        }
    }
    if (!$exists) $barang[] = ["id"=>$id, "nama"=>$_POST['nama'], "harga"=>(int)$_POST['harga'], "stok"=>(int)$_POST['stok']];
    file_put_contents($file, json_encode($barang, JSON_PRETTY_PRINT));
    header("Location: barang.php");
}

// Proses Hapus
if (isset($_GET['delete'])) {
    $barang = array_filter($barang, function($b) { return $b['id'] !== $_GET['delete']; });
    file_put_contents($file, json_encode(array_values($barang), JSON_PRETTY_PRINT));
    header("Location: barang.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gudang - PT ESHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #121212; color: white; }.glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); }</style>
</head>
<body class="p-4">
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h3>Manajemen Barang</h3>
        <a href="index.php" class="btn btn-outline-light btn-sm">Kembali</a>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="glass p-4">
                <h5 id="title">Tambah/Edit Barang</h5>
                <form method="POST">
                    <input type="text" name="id" id="id" class="form-control mb-2" placeholder="ID Barang" required>
                    <input type="text" name="nama" id="nama" class="form-control mb-2" placeholder="Nama Barang" required>
                    <input type="number" name="harga" id="harga" class="form-control mb-2" placeholder="Harga" required>
                    <input type="number" name="stok" id="stok" class="form-control mb-2" placeholder="Stok" required>
                    <button type="submit" name="save" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="glass p-4">
                <table class="table table-dark">
                    <thead><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach($barang as $b): ?>
                        <tr>
                            <td><?= $b['id'] ?></td>
                            <td><?= $b['nama'] ?></td>
                            <td><?= number_format($b['harga']) ?></td>
                            <td><?= $b['stok'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='edit(<?= json_encode($b) ?>)'>Edit</button>
                                <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function edit(data) {
        document.getElementById('id').value = data.id;
        document.getElementById('nama').value = data.nama;
        document.getElementById('harga').value = data.harga;
        document.getElementById('stok').value = data.stok;
    }
</script>
</body>
</html>