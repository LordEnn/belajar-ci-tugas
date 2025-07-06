<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?= form_open('keranjang/edit') ?>



<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Foto</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>

        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><?= esc($item['name']) ?></td>
                <td>
                    <?php if (!empty($item['options']['foto'])) : ?>
                        <img src="<?= base_url('img/' . $item['options']['foto']) ?>" width="100">
                    <?php else : ?>
                        Tidak ada gambar
                    <?php endif; ?>
                </td>
                <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                <td>
                    <input type="number" name="qty<?= $i ?>" min="1" class="form-control" value="<?= esc($item['qty']) ?>">
<?php if (isset($item['rowid'])) : ?>
    <input type="hidden" name="rowid<?= $i ?>" value="<?= esc($item['rowid']) ?>">
<?php endif; ?>
                </td>
                <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
               <td>
</td>

            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="alert alert-info">
    Total: <?= number_to_currency($total, 'IDR') ?>
</div>

<div class="d-flex gap-2">
    <button class="btn btn-primary" type="submit">Update</button>
    <a href="<?= base_url('keranjang/clear') ?>" class="btn btn-warning">Kosongkan</a>
    <?php if (!empty($items)) : ?>
        <a href="<?= base_url('checkout') ?>" class="btn btn-success">Checkout</a>
    <?php endif; ?>
</div>

<?= form_close() ?>
<?= $this->endSection() ?>
