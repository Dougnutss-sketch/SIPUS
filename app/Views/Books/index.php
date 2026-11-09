<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Data Buku</h3>
        <p class="text-muted mb-0">Kelola koleksi buku perpustakaan.</p>
    </div>

    <a href="<?= site_url('books/new') ?>" class="btn btn-primary">
        Tambah Buku
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted">Jumlah seluruh buku</div>
                <div class="fs-3 fw-bold"><?= esc($statistics['total_books'] ?? 0) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted">Eksemplar tersedia</div>
                <div class="fs-3 fw-bold"><?= esc($statistics['available_copies'] ?? 0) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    Buku yang sudah memiliki riwayat peminjaman tidak dapat dihapus agar jejak transaksi,
    laporan, dan hubungan data peminjamannya tetap utuh. Jika buku tidak lagi digunakan,
    ubah statusnya menjadi nonaktif.
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('books') ?>" method="get" class="row g-3 mb-4">
            <div class="col-lg-4">
                <label for="book-search" class="form-label">Cari judul buku</label>
                <input type="search"
                       name="q"
                       id="book-search"
                       class="form-control"
                       value="<?= esc($search) ?>"
                       placeholder="Masukkan judul buku">
            </div>
            <div class="col-lg-3">
                <label for="category-filter" class="form-label">Kategori</label>
                <select name="category" id="category-filter" class="form-select">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= esc($category['id']) ?>"
                            <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-3 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input type="checkbox"
                           name="active"
                           value="1"
                           id="active-filter"
                           class="form-check-input"
                           <?= $activeOnly ? 'checked' : '' ?>>
                    <label class="form-check-label" for="active-filter">
                        Tampilkan buku aktif saja
                    </label>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="<?= site_url('books') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <p class="text-muted">
            Menampilkan <?= count($books) ?> buku
            <?php if ($search !== '' || $categoryId !== null || $activeOnly): ?>
                sesuai filter.
            <?php else: ?>
                dalam urutan judul.
            <?php endif; ?>
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($books)): ?>
                        <?php $no = 1; ?>

                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($book['code']) ?></td>
                                <td>
                                    <a href="<?= site_url('books/detail/' . $book['id']) ?>">
                                        <?= esc($book['title']) ?>
                                    </a>
                                </td>
                                <td><?= esc($book['category_name']) ?></td>
                                <td><?= esc($book['author']) ?></td>
                                <td>
                                    <?= esc($book['stock_available']) ?>
                                    /
                                    <?= esc($book['stock_total']) ?>
                                </td>
                                <td>
                                    <?php if ($book['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('books/detail/' . $book['id']) ?>"
                                       class="btn btn-sm btn-info">
                                        Detail
                                    </a>

                                    <a href="<?= site_url('books/edit/' . $book['id']) ?>"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= site_url('books/delete/' . $book['id']) ?>"
                                          method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">

                                        <?= csrf_field() ?>

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                Tidak ada buku yang cocok dengan filter.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>