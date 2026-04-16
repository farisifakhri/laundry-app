<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>Struk Laundry 58mm</title>

<style>
:root {
  --paper-width: 58mm;
  --font-size: 11.5px;
  --line-height: 1.3;
}

/* RESET */
*,
*::before,
*::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html, body {
  background: #eee;
  font-family: monospace;
  font-size: var(--font-size);
  line-height: var(--line-height);
  color: #000;
}

/* ========== WRAPPER ========== */
.receipt-wrapper {
  width: var(--paper-width);
  margin: 8px auto;
  padding: 8px 6px 12px;
  background: #fff;
}

/* ========== HEADER ========== */
.logo {
  text-align: center;
  margin-bottom: 4px;
}

.logo img {
  max-width: 45mm;
}

.title {
  text-align: center;
  font-size: 13px;
  font-weight: bold;
  letter-spacing: 0.5px;
}

.subtitle {
  text-align: center;
  font-size: 11px;
  margin-top: 2px;
  margin-bottom: 6px;
}

/* ========== LINE ========== */
.hr {
  border-top: 1px dashed #000;
  margin: 6px 0;
}

/* ========== INFO ========== */
.info div {
  display: flex;
  justify-content: space-between;
  gap: 4px;
  margin: 2px 0;
}

/* ========== ITEM LIST ========== */
.items {
  margin-top: 6px;
}

.item {
  margin-bottom: 4px;
}

.item-name {
  font-weight: bold;
}

.item-meta {
  display: flex;
  justify-content: space-between;
  margin-top: 1px;
  font-size: 11px;
}

/* ========== TOTAL ========== */
.totals {
  margin-top: 6px;
  padding-top: 5px;
  border-top: 1px dashed #000;
}

.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
  font-size: 13px;
}

/* ========== BARCODE ========== */
.barcode {
  text-align: center;
  margin-top: 8px;
}

.barcode img {
  max-width: 100%;
}

/* ========== FOOTER ========== */
.note {
  text-align: center;
  font-size: 11px;
  margin-top: 6px;
}

.thanks {
  text-align: center;
  font-size: 12px;
  margin-top: 3px;
  font-weight: bold;
}

/* ========== PRINT MODE ========== */
@media print {
  html, body {
    background: #fff;
  }

  @page {
    size: 58mm auto;
    margin: 0;
  }

  .receipt-wrapper {
    width: 58mm;
    margin: 0;
    padding: 6px 4px 8px;
  }
}
</style>

</head>

<body>

<?php
$id_transaksi = $_POST['id_transaksi'] ?? '-';
$items = isset($_POST['detail_layanan']) ? json_decode($_POST['detail_layanan'], true) : [];
$pelanggan = $_POST['nama_pelanggan'] ?? '-';
$telepon = $_POST['telp_pelanggan'] ?? '-';
$alamat = $_POST['alamat_pelanggan'] ?? '-';
$total = $_POST['total'] ?? 0;
$created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');

$estimasi = date('d-m-Y', strtotime($created_at . ' +3 days'));
?>

<div class="receipt-wrapper" id="receipt">

  <!-- ===== HEADER ===== -->
  <div class="logo">
    <img src="assets/img/logo.png">
  </div>

  <div class="title">NUGRAHA LAUNDRY</div>
  <div class="subtitle">
    Cepat • Bersih • Terpercaya<br>
    Telp : 0812-3456-7890
  </div>

  <div class="hr"></div>

  <!-- ===== INFO TRANSAKSI ===== -->
  <div class="info">
    <div><span>ID</span><span><?= htmlspecialchars($id_transaksi) ?></span></div>
    <div><span>Tanggal</span><span><?= date('d-m-Y H:i', strtotime($created_at)) ?></span></div>
    <div><span>Pelanggan</span><span><?= htmlspecialchars($pelanggan) ?></span></div>
    <div><span>Telepon</span><span><?= htmlspecialchars($telepon) ?></span></div>
    <div><span>Selesai</span><span><?= $estimasi ?></span></div>
  </div>

  <div class="hr"></div>

  <!-- ===== ITEM LIST ===== -->
  <div class="items">

    <?php if (!empty($items)) : ?>
      <?php foreach ($items as $it) : ?>
        <div class="item">
          <div class="item-name"><?= htmlspecialchars($it['layanan']) ?></div>
          <div class="item-meta">
            <span><?= $it['qty'] ?> x</span>
            <span>Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div>Tidak ada layanan</div>
    <?php endif; ?>

  </div>

  <!-- ===== TOTAL ===== -->
  <div class="totals">
    <div class="total-row">
      <span>TOTAL</span>
      <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
    </div>
  </div>

  <!-- ===== BARCODE ===== -->
  <div class="barcode">
    <img
      src="https://barcode.tec-it.com/barcode.ashx?data=<?= urlencode($id_transaksi) ?>&code=Code128&dpi=96"
      alt="Barcode"
    >
  </div>

  <!-- ===== FOOTER ===== -->
  <div class="note">
    Simpan struk ini sebagai bukti pengambilan
  </div>
  <div class="thanks">
    Terima Kasih 🙏
  </div>

</div>

<script>
  window.onload = function() {
    window.print();
  };
</script>

</body>
</html>
