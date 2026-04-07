<?php
session_start();
$data_barang = json_decode(file_get_contents('barang.json'), true);

if (isset($_POST['tambah'])) {
    $_SESSION['keranjang'][] = [
        'id' => $_POST['id'],
        'nama' => $_POST['nama_hidden'],
        'harga' => $_POST['harga_hidden'],
        'qty' => $_POST['qty'],
        'subtotal' => $_POST['harga_hidden'] * $_POST['qty']
    ];
}
?>
<form action="nota.php" method="POST">
    <div class="mt-4 p-3 glass">
        <h5>Metode Pembayaran</h5>
        <select name="metode_bayar" class="form-select mb-3" required>
            <option value="Tunai">Uang Tunai</option>
            <option value="QRIS">QRIS / E-Wallet</option>
            <option value="Debit">Kartu Debit</option>
        </select>
        <button type="submit" class="btn btn-success btn-lg w-100">Selesaikan & Cetak Nota</button>
    </div>
</form>
<?php
session_start();
$barang = json_decode(file_get_contents('barang.json'), true);

if (isset($_POST['add'])) {
    foreach ($barang as $b) {
        if ($b['id'] == $_POST['id_barang']) {
            $_SESSION['cart'][] = [
                'id' => $b['id'], 'nama' => $b['nama'], 
                'harga' => $b['harga'], 'qty' => $_POST['qty'], 
                'total' => $b['harga'] * $_POST['qty']
            ];
            break;
        }
    }
}

if (isset($_GET['clear'])) { unset($_SESSION['cart']); header("Location: penjualan.php"); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir - PT ESHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #0a0a0a; color: white; }.glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 20px; border-radius: 15px; }</style>
</head>
<body class="p-4">
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="glass shadow">
                <h4>Cari Barang</h4>
                <form method="POST">
                    <select name="id_barang" class="form-select mb-2">
                        <?php foreach($barang as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= $b['nama'] ?> (Rp<?= number_format($b['harga']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="qty" class="form-control mb-2" value="1" min="1">
                    <button name="add" class="btn btn-primary w-100">Tambah</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="glass shadow">
                <h4>Keranjang Belanja</h4>
                <table class="table table-dark">
                    <thead><tr><th>Nama</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        <?php $total = 0; if(!empty($_SESSION['cart'])): foreach($_SESSION['cart'] as $c): $total += $c['total']; ?>
                        <tr><td><?= $c['nama'] ?></td><td><?= $c['qty'] ?></td><td><?= number_format($c['total']) ?></td></tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
                <h3 class="text-end">Total: Rp <?= number_format($total) ?></h3>
                <form action="nota.php" method="POST">
                    <label>Metode Pembayaran:</label>
                    <select name="metode" class="form-select mb-3">
                        <option value="Tunai">Tunai</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Debit">Debit</option>
                    </select>
                    <div class="d-flex gap-2">
                        <a href="?clear=1" class="btn btn-danger">Reset</a>
                        <button class="btn btn-success flex-grow-1">Bayar Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>