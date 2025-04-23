<?php require "..\controller\crud.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .foto-user {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<!-- <div class="text-right"> 
    <a href="logout.php" class="btn btn-danger m-10">Logout</a>
</div> -->


<div class="container mt-4">
    <h2 class="mb-4">Manajemen User</h2>
    
    <!-- Container untuk tombol Logout dan Tambah User -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
        <i class="bi bi-person-plus"></i> Tambah User
    </button>
    <div class="d-flex justify-content-between mb-3">
        <a href="../logout.php" class="btn btn-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

        <!-- Tabel Data User -->
        <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th>Level Akses</th>
                <th>Last Login</th>
                <th>Last IP</th>
                <th>Status</th>  <!-- Kolom is_aktif -->
                <th>Dibuat Pada</th> <!-- Kolom created_at -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td>
                        <?php if ($row['foto']): ?>
                            <img src="../uploads/<?= $row['foto'] ?>" class="foto-user" alt="Foto User">
                        <?php else: ?>
                            <img src="../uploads/default.jpg" class="foto-user" alt="Foto Default">
                        <?php endif; ?>
                    </td>
                    <td><?= $row['nama_lengthap'] ?></td>
                    <td><?= $row['user'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['level_akses'] ?></td>
                    <td><?= $row['last_login'] ? $row['last_login'] : 'Belum pernah login' ?></td>
                    <td><?= $row['last_ip'] ? $row['last_ip'] : '-' ?></td>
                    <td>
                        <?php if ($row['is_aktif'] == 1): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Non-Aktif</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d-m-Y H:i:s', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Level Akses</label>
                                <select name="level_akses" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control-file" required>
                            </div>
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit User -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $id = $_GET['edit'];
            $stmt = $conn->prepare("SELECT * FROM tb_user WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            ?>
            <div class="modal fade show" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" style="display: block;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="<?= $user['nama_lengthap'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $user['user'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" value="<?= $user['pass'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Level Akses</label>
                                    <select name="level_akses" class="form-control" required>
                                        <option value="admin" <?= $user['level_akses'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="user" <?= $user['level_akses'] == 'user' ? 'selected' : '' ?>>User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control-file">
                                    <?php if ($user['foto']): ?>
                                        <small class="text-muted">Foto saat ini: <a href="uploads/<?= $user['foto'] ?>" target="_blank"><?= $user['foto'] ?></a></small>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if (isset($_GET['edit'])): ?>
                $('#editModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>
</html>
