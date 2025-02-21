<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
    .carousel-item img {
        width: 80%;
        height: 90vh;
    }
    .login-form {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 60%; /* Adjusted width */
    }
    .login-header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .login-logo {
        width: 50px;
        margin-right: 10px;
    }
    .login-title {
        font-size: 1.5em;
        font-weight: bold;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .btn-primary {
        margin-top: 20px;
    }
    .form-control:focus {
        box-shadow: 0 0 5px 2px #d4edda; /* Bootstrap light success */
        border-color: #d4edda; /* Bootstrap light success */
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row w-100">
        <div class="col-7 d-flex justify-content-center align-items-center">
            <div class="login-form">
                <div class="login-header">
                    <img src="<?php echo base_url('assets/logo.png'); ?>" alt="Logo" class="login-logo">
                    <div class="login-title">Number 1 Feeds Corporation</div>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <button type="button" class="btn btn-primary w-100" onclick='userLogin()'>Login</button>
            </div>
        </div>
        <div class="col-5">
            <div id="carouselExampleIndicators" class="carousel slide w-100" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo base_url('assets/carousel_photo/Breeder.jpg'); ?>" class="d-block mx-auto" alt="Breeder">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('assets/carousel_photo/Finisher.jpg'); ?>" class="d-block mx-auto" alt="Finisher">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('assets/carousel_photo/Grower.jpg'); ?>" class="d-block mx-auto" alt="Grower">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('assets/carousel_photo/Lactating.jpg'); ?>" class="d-block mx-auto" alt="Lactating">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('assets/carousel_photo/Pre-Starter.jpg'); ?>" class="d-block mx-auto" alt="Pre-Starter">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('assets/carousel_photo/Starter.jpg'); ?>" class="d-block mx-auto" alt="Starter">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function userLogin() {
        var username = $('#username').val();
        var password = $('#password').val();
        var csrfName = '<?= csrf_token() ?>';
        var csrfHash = $('input[name="<?= csrf_token() ?>"]').val();

        if (username === '' || password === '') {
            alert('Username and password cannot be empty.');
            return;
        }

        $.ajax({
            url: '<?= base_url('login/authenticate') ?>',
            type: 'POST',
            data: {
                username: username,
                password: password,
                [csrfName]: csrfHash
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    window.location.href = '<?= base_url('/') ?>';
                } else {
                    alert('Error: ' + data.message);
                }
            }
        });
    }
</script>
<?= $this->endSection() ?>