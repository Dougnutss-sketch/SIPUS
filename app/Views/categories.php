<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Kategori - SIPUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1 class="h3 mb-3">Data Kategori Buku</h1>
    <?php if (message=session()->getFlashdata('success')):?><divclass="alertalert-success"><?=esc(message) ?></div>
    <?php endif ?>
    <?php if (message=session()->getFlashdata('errors')):?><divclass="alertalert-danger"><ulclass="mb-0"><?phpforeach(message as $error):?><li><?=esc(error) ?></li><?phpendforeach?></ul></div>
    <?php endif ?>
    <?php if (message=session()->getFlashdata('error')):?><divclass="alertalert-danger"><?=esc(message) ?></div>
    <?php endif ?>
    <a href="<?= site_url('kategori/tambah') ?>"
       class="btn btn-primary mb-3">Tambah Kategori</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty(categories)):?><tr><tdcolspan="4"class="text-center">Belumadadatakategori.</td></tr><?phpelse:?><?phpforeach(categories as $i => $category): ?>
                <tr>
                    <td><?= i+1?></td><td><?=esc(category['name']) ?></td>
                    <td><?= esc($category['description'] ?? '') ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning"
                           href="<?= site_url('kategori/edit/' . $category['id']) ?>">
                            Edit
                        </a>
                        <form class="d-inline"
                              method="post"
                              action="<?= site_url('kategori/hapus/' . $category['id']) ?>"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-danger" type="submit">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
        </tbody>
    </table>
</div>
</body>
</html>