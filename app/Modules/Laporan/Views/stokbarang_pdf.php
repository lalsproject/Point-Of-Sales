<?php
function Ribuan($angka)
{

    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <title>Print PDF</title>
    <style>
        .container {
            padding-left: 10px;
        }

        table {
            border: 1px solid #424242;
            border-collapse: collapse;
            padding: 0;
        }

        th {
            background-color: #f2f2f2;
            color: black;
            padding: 15px;
        }

        tr,
        td {
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!--  <img src="<?= base_url() . '/' . $logo; ?>" width="80" height="80" alt="Logo" style="float:left;margin-top: 10px;margin-right: 10px;"> -->
        <h1 style="margin-bottom: 5px;"><?= $toko['nama_toko'] ?? "Laporan Stock"; ?></h1>
        <?php if ($toko) : ?> <?= $toko['alamat_toko']; ?> - Telp/WA: <?= $toko['telp']; ?> - Email: <?= $toko['email']; ?> - NIB: <?= $toko['NIB']; ?> <?php endif; ?>
        <hr />
        <h1 align="center">Laporan <?= mediumdate_indo($tgl_start); ?> &mdash; <?= mediumdate_indo($tgl_end); ?></h1>
        <h4>Stok Barang Terjual</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Outlet</th>
                    <th scope="col">Code Item</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <!-- <td><?= $no++; ?></td> -->
                        <td><?= $row['nama_toko']; ?></td>
                        <td><?= $row['kode_barang']; ?></td>
                        <td><?= $row['barcode']; ?></td>
                        <td width="200"><?= $row['nama_barang']; ?><br />SKU: <?= $row['sku'] ?? "-"; ?></td>
                        <td><?= $row['satuan']; ?></td>
                        <td><?= Ribuan($row['stok']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>