<?php
    $current_page = basename($_SERVER['REQUEST_URI']);
?>
<style>
    .box {
        background-color: white;
        border-radius: 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 0 1rem; /* Add more space on both sides */
    }
    .nav-link {
        font-size: 1rem;
        margin: 0 0.5rem; /* Add a little space between nav links */
        border-radius: 25px;
    }
    .nav-link.active {
        background-color: rgba(0, 0, 0, 0.1);
        margin: 0.3rem 0;
        padding: 0.2rem 1.5rem !important;
    }
    .nav-link.active::before {
        content: '';
        display: inline-block;
        background: url('<?= base_url('assets/logo.png') ?>') no-repeat center center; /* Replace with the actual path to your logo */
        background-size: contain;
        width: 1rem;
        height: 1rem;
        margin-right: 8px;
        vertical-align: middle;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light mb-3">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <div class="box">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == '' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dahsboard' ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'sales_invoice' ? 'active' : '' ?>" href="<?= base_url('/sales_invoice') ?>">Sales Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'delivery_receipt' ? 'active' : '' ?>" href="<?= base_url('/delivery_receipt') ?>">Delivery Receipt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'clients' ? 'active' : '' ?>" href="<?= base_url('/clients') ?>">Clients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'products' ? 'active' : '' ?>" href="<?= base_url('/products') ?>">Products</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
