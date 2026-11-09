<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Detail Buku</h3>
        <p class="text-muted mb-0">Informasi lengkap buku dan riwayat peminjamannya.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('books/edit/' . $book['id']) ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('books') ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-bold">Informasi Buku</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Kode Buku</dt>
            <dd class="col-sm-9"><?= esc($book['code']) ?></dd>

            <dt class="col-sm-3">Judul</dt>
            <dd class="col-sm-9"><?= esc($book['title']) ?></dd>

            <dt class="col-sm-3">Kategori</dt>
            <dd class="col-sm-9"><?= esc($book['category_name']) ?></dd>

            <dt class="col-sm-3">Deskripsi Kategori</dt>
            <dd class="col-sm-9"><?= esc($book['category_description'] ?: '-') ?></dd>

            <dt class="col-sm-3">Penulis</dt>
            <dd class="col-sm-9"><?= esc($book['author']) ?></dd>

            <dt class="col-sm-3">Penerbit</dt>
            <dd class="col-sm-9"><?= esc($book['publisher'] ?: '-') ?></dd>

            <dt class="col-sm-3">Tahun Terbit</dt>
            <dd class="col-sm-9"><?= esc($book['published_year'] ?: '-') ?></dd>

            <dt class="col-sm-3">Stok Tersedia</dt>
            <dd class="col-sm-9">
                <?= esc($book['stock_available']) ?> dari <?= esc($book['stock_total']) ?> eksemplar
            </dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <?= $book['is_active'] ? 'Aktif' : 'Nonaktif' ?>
            </dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold">Riwayat Peminjaman</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Peminjaman</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Jumlah</th>
                        <th>Sudah Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($loanHistory)): ?>
                        <?php foreach ($loanHistory as $loan): ?>
                            <tr>
                                <td><?= esc($loan['loan_code']) ?></td>
                                <td><?= esc($loan['member_name']) ?> (<?= esc($loan['member_code']) ?>)</td>
                                <td><?= esc($loan['loan_date']) ?></td>
                                <td><?= esc($loan['due_date']) ?></td>
                                <td><?= esc($loan['quantity']) ?></td>
                                <td><?= esc($loan['quantity_returned']) ?></td>
                                <td><?= esc(ucfirst($loan['status'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat peminjaman buku.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
