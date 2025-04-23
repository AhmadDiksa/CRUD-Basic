<?php require "..\controller\user.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .foto-profil {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard User</h2>
        <div class="row">
            <div class="col-md-4">
                <!-- Profil User -->
                <div class="card">
                    <div class="card-body text-center">
                        <?php if ($user['foto']): ?>
                            <img src="../uploads/<?= $user['foto'] ?>" class="foto-profil mb-3" alt="Foto Profil">
                        <?php else: ?>
                            <img src="uploads/default.jpg" class="foto-profil mb-3" alt="Foto Default">
                        <?php endif; ?>
                        <h4><?= $user['nama_lengthap'] ?></h4>
                        <p class="text-muted">@<?= $user['user'] ?></p>
                        <p><?= $user['email'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Form Edit Profil -->
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Profil</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= $user['nama_lengthap'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="<?= $user['user'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Foto Profil</label>
                                <input type="file" name="foto" class="form-control-file">
                                <?php if ($user['foto']): ?>
                                    <small class="text-muted">Foto saat ini: <a href="uploads/<?= $user['foto'] ?>" target="_blank"><?= $user['foto'] ?></a></small>
                                <?php endif; ?>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>