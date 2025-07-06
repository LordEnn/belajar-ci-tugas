<?= $this->extend('layout') ?>
<?= $this->section('content') ?> 
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>



<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Data Berhasil Ditambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah Data
                    </button>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length">
                                <label>Show 
                                    <select class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_filter text-end">
                                <label>Search:
                                    <input type="search" class="form-control form-control-sm" placeholder="" style="width: auto; display: inline-block;">
                                </label>
                            </div>
                        </div>
                    </div>

                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategori as $index => $kat) : ?>
                                <tr>
                                    <th scope="row"><?php echo $index + 1 ?></th>
                                    <td><?php echo $kat['nama'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $kat['id'] ?>">
                                            Ubah
                                        </button>
                                        <a href="<?= base_url('kategori/delete/' . $kat['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini ?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal Begin -->
                                <div class="modal fade" id="editModal-<?= $kat['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('kategori/edit/' . $kat['id']) ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label for="name">Nama Kategori</label>
                                                        <input type="text" name="nama" class="form-control" id="nama" value="<?= $kat['nama'] ?>" placeholder="Nama Kategori" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="description">Deskripsi</label>
                                                        <textarea name="deskripsi" class="form-control" id="deskripsi"><?= $kat['deskripsi'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Edit Modal End -->
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kategori') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Kategori" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi kategori"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal End -->

<?= $this->endSection() ?>