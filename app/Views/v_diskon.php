<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Manajemen Diskon</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (isset($mode) && ($mode == 'tambah' || $mode == 'edit')): ?>
        <div class="row">
            <div class="col-lg-6">
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= $mode == 'tambah' ? '/diskon/store' : '/diskon/update/' . $diskon['id'] ?>" method="post" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal"
                            value="<?= $mode == 'edit' ? $diskon['tanggal'] : old('tanggal') ?>"
                            <?= $mode == 'edit' ? 'readonly' : '' ?> required>
                    </div>
                    <div class="col-12">
                        <label for="nominal" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control" name="nominal"
                            value="<?= $mode == 'edit' ? $diskon['nominal'] : old('nominal') ?>" required>
                    </div>
                    <div class="text-start">
                        <button type="submit" class="btn btn-<?= $mode == 'tambah' ? 'success' : 'primary' ?>">
                            <?= $mode == 'tambah' ? 'Simpan' : 'Update' ?>
                        </button>
                        <a href="/diskon" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <a href="/diskon/add" class="btn btn-primary mb-3">Tambah Diskon</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diskon as $d): ?>
                        <tr>
                            <td><?= $d['id'] ?></td>
                            <td><?= $d['tanggal'] ?></td>
                            <td>Rp<?= number_format($d['nominal'], 0, ',', '.') ?></td>
                            <td>
                                <a href="/diskon/edit/<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/diskon/delete/<?= $d['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
