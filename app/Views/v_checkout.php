<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <!-- Vertical Form -->
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?php $diskon = session()->get('diskon') ?? 0; ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>
        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?= session()->get('username'); ?>">
        </div>
        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat">
        </div> 
        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" id="kelurahan" name="kelurahan" required></select>
        </div>
        <div class="col-12">
            <label for="layanan" class="form-label">Layanan</label>
            <select class="form-control" id="layanan" name="layanan" required></select>
        </div>
        <div class="col-12">
            <label for="ongkir" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
        </div>
    </div>
    <div class="col-lg-6">
        <!-- Vertical Form -->
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)) : foreach ($items as $item) : ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Subtotal</td>
                        <td><?= number_to_currency($total, 'IDR') ?></td>
                    </tr>
                    <?php if ($diskon > 0): ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Diskon</td>
                        <td>-<?= number_to_currency($diskon, 'IDR') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Total</td>
                        <td><span id="total"><?= number_to_currency($total - $diskon, 'IDR') ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    var ongkir = 0;
    var total = <?= $total ?>;
    var diskon = <?= $diskon ?>;
    hitungTotal();

    $('#kelurahan').select2({
        placeholder: 'Ketik nama kelurahan...',
        ajax: {
            url: '<?= base_url('get-location') ?>',
            dataType: 'json',
            delay: 1500,
            data: function(params) {
                return { search: params.term };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });

    $("#kelurahan").on('change', function() {
        var id_kelurahan = $(this).val(); 
        $("#layanan").empty();
        ongkir = 0;

        $.ajax({
            url: "<?= site_url('get-cost') ?>",
            type: 'GET',
            data: { destination: id_kelurahan },
            dataType: 'json',
            success: function(data) { 
                data.forEach(function(item) {
                    var text = item["description"] + " (" + item["service"] + ") : estimasi " + item["etd"];
                    $("#layanan").append($('<option>', {
                        value: item["cost"],
                        text: text 
                    }));
                });
                hitungTotal(); 
            },
        });
    });

    $("#layanan").on('change', function() {
        ongkir = parseInt($(this).val());
        hitungTotal();
    });

    function hitungTotal() {
        var grandTotal = ongkir + total - diskon;
        $("#ongkir").val(ongkir);
        $("#total").html("IDR " + grandTotal.toLocaleString("id-ID"));
        $("#total_harga").val(grandTotal);
    }
});
</script>
<?= $this->endSection() ?>
