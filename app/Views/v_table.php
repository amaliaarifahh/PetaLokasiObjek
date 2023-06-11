<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #A62349;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-home"></i> Lokasi Terdampak Bencana Gempa Bumi Cianjur <i class="fas fa-home"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (auth()->loggedIn()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('') ?>"><i class="fas fa-map"></i> Peta</a>
                        </li>
                    <?php endif; ?>

                    <?php if (auth()->loggedIn()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('objek') ?>"><i class="fas fa-plus-circle"></i> Input Data</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link <?= auth()->loggedIn() ? 'text-danger' : '' ?>" href="
                        <?= auth()->loggedIn() ? base_url('logout') : base_url('login') ?>"><i class="fas fa-sign-in-alt"></i>
                            <?= auth()->loggedIn() ? 'Logout' : 'Login' ?> </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card border-dark my-3 mb-3">
            <div class="card">
                <div class="card-shadow mt-3"></div>
                <div class="card-header text-center">
                    <h3><i class="fas fa-table mx-2"></i>TABEL DATA OBJEK</h3>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) :
                        $flashdata = session()->getFlashdata('message'); ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $flashdata ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="table_objek" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1;
                                foreach ($objek as $obj) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $obj['nama'] ?></td>
                                        <td><?= $obj['deskripsi'] ?></td>
                                        <td>
                                            <a href="<?= 'https://www.google.com/maps/dir/?api=1&destination=' .
                                                            $obj['latitude'] . ',' . $obj['longitude'] . '&travelmode=driving' ?>
                                                            " target="_blank" title="Tampilkan rute">
                                                <?= $obj['latitude'] . ',' . $obj['longitude'] ?>
                                            </a>
                                        </td>
                                        <td><img src="<?= base_url('upload/foto/') . '/' . $obj['foto'] ?>" alt="tetot" width="200"></td>
                                        <td><?= $obj['created_at'] ?></td>
                                        <td><?= $obj['updated_at'] ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="<?= base_url('objek/edit/') . "/" . $obj['id'] ?>" class="btn btn-warning btn-sm mx-2"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('objek/hapus/') . "/" .  $obj['id'] ?>" type="button" class="btn btn-danger btn-sm mx-2" onclick="return confirm 
                                    ('Apakah yakin data <?= $obj['nama'] ?> akan dihapus?')"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#table_objek').DataTable();
        });
    </script>
</body>

</html>