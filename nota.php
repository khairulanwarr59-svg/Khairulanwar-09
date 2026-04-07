<?php
session_start();
if (empty($_SESSION['keranjang'])) {
    die("Keranjang kosong!");
}

$transaksi_file = 'transaksi.json';
$barang_file = 'barang.json';

$data_transaksi = json_decode(file_get_contents($transaksi_file), true);
$data_barang = json_decode(file_get_contents($barang_file), true);

$id_transaksi = "TRX-" . time();
$tanggal = date('Y-m-d');
$jam = date('H:i:s');
$total_bayar = 0;

foreach ($_SESSION['keranjang'] as $item) {
    $total_bayar += $item['subtotal'];
    
    // Simpan ke array transaksi
    $new_trx = [
        'id_transaksi' => $id_transaksi,
        'tanggal' => $tanggal,
        'jam' => $jam,
        'id_barang' => $item['id'],
        'nama_barang' => $item['nama'],
        'qty' => $item['qty'],
        'total_harga' => $item['subtotal']
    ];
    $data_transaksi[] = $new_trx;

    // Update Stok Barang
    foreach ($data_barang as &$b) {
        if ($b['id'] == $item['id']) {
            $b['stok'] -= $item['qty'];
        }
    }
}

// Simpan kembali ke JSON
file_put_contents($transaksi_file, json_encode($data_transaksi, JSON_PRETTY_PRINT));
file_put_contents($barang_file, json_encode($data_barang, JSON_PRETTY_PRINT));

$cetak_item = $_SESSION['keranjang'];
unset($_SESSION['keranjang']); // Kosongkan keranjang setelah sukses
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nota - PT ESHA Farmasi</title>
    <style>
        body { font-family: monospace; width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; }
        .center { text-align: center; }
        hr { border-top: 1px dashed #000; }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <strong>PT ESHA FARMASI</strong><br>
        Jl. Kesehatan No. 1<br>
        ID: <?= $id_transaksi ?>
    </div>
    <hr>
    <?= $tanggal ?> <?= $jam ?><br>
    <hr>
    <?php foreach($cetak_item as $i): ?>
        <?= $i['nama'] ?> x<?= $i['qty'] ?> <br>
        Rp<?= number_format($i['subtotal']) ?><br>
    <?php endforeach; ?>
    <hr>
    <strong>TOTAL: Rp<?= number_format($total_bayar) ?></strong>
    <br><br>
    <div class="center">Terima Kasih</div>
</body>
</html>
<?php
session_start();
if (empty($_SESSION['cart'])) die("Keranjang kosong!");

$file_trx = 'transaksi.json';
$file_brg = 'barang.json';
$trxs = json_decode(file_get_contents($file_trx), true);
$brgs = json_decode(file_get_contents($file_brg), true);

$id_trx = "TRX-" . time();
$metode = $_POST['metode'];
$grand_total = 0;

foreach ($_SESSION['cart'] as $item) {
    $grand_total += $item['total'];
    $trxs[] = [
        "id_transaksi" => $id_trx, "tanggal" => date('Y-m-d'), "jam" => date('H:i:s'),
        "id_barang" => $item['id'], "nama_barang" => $item['nama'],
        "qty" => $item['qty'], "total_harga" => $item['total'], "metode" => $metode
    ];

    // Potong Stok
    foreach ($brgs as &$b) { if ($b['id'] == $item['id']) $b['stok'] -= $item['qty']; }
}

file_put_contents($file_trx, json_encode($trxs, JSON_PRETTY_PRINT));
file_put_contents($file_brg, json_encode($brgs, JSON_PRETTY_PRINT));

$items = $_SESSION['cart'];
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nota ESHA Farmasi</title>
    <style>body { font-family: monospace; width: 300px; margin: auto; padding: 20px; border: 1px solid #000; }</style>
</head>
<body onload="window.print()">
    <center><strong>PT ESHA FARMASI</strong><br>Nota Digital</center><hr>
    ID: <?= $id_trx ?><br>Bayar: <?= $metode ?><hr>
    <?php foreach($items as $i): ?>
        <?= $i['nama'] ?> x<?= $i['qty'] ?> = <?= number_format($i['total']) ?><br>
    <?php endforeach; ?><hr>
    <strong>TOTAL: Rp <?= number_format($grand_total) ?></strong>
    <p><center>Terima Kasih</center></p>
    <a href="penjualan.php">Kembali</a>
</body>
</html>