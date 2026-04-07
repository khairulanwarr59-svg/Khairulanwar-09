<?php
$file_trx = 'transaksi.json';
$transaksi = json_decode(file_get_contents($file_trx), true);

if (isset($_POST['update_trx'])) {
    $idx = $_POST['index'];
    $transaksi[$idx]['qty'] = $_POST['new_qty'];
    $transaksi[$idx]['total_harga'] = $transaksi[$idx]['qty'] * ($_POST['harga_satuan']);
    file_put_contents($file_trx, json_encode($transaksi, JSON_PRETTY_PRINT));
    header("Location: laporanbulanan.php");
}
?>
<td>
    <form method="POST" class="d-flex gap-1">
        <input type="hidden" name="index" value="<?= $key ?>">
        <input type="hidden" name="harga_satuan" value="<?= $t['total_harga'] / $t['qty'] ?>">
        <input type="number" name="new_qty" class="form-control form-control-sm" style="width: 60px" value="<?= $t['qty'] ?>">
        <button name="update_trx" class="btn btn-sm btn-info">Update</button>
    </form>
</td>