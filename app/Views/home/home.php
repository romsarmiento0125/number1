<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .fluid-container img {
        width: 100%;
        height: 40vh;
    }
    .nav-box {
        width: 100%;
        height: 250px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .nav-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .nav-box div {
        position: absolute;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        width: 100%;
        text-align: center;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .nav-box:hover div {
        opacity: 1;
    }
    .nav-box:hover {
        background-color: rgba(224, 224, 224, 0.8);
    }

</style>

<div class="main-div">
    <div class="fluid-container">
        <img src="<?php echo base_url('assets/banner.jpg'); ?>" alt="">
    </div>
    
    <div class="p-4">
        <div class="row">
            <div class="col-4 mb-3">
                <a href="/dashboard" class="nav-box">
                    <img src="<?= base_url('assets/carousel_photo/Breeder.jpg') ?>" alt="Module 1">
                    <div>Dashboard</div>
                </a>
            </div>
            <div class="col-4 mb-3">
                <a href="/sales_invoice" class="nav-box">
                    <img src="<?= base_url('assets/home_photo/sales_invoice_module.png') ?>" alt="Module 2">
                    <div>Sales Invoice</div>
                </a>
            </div>
            <div class="col-4 mb-3">
                <a href="/delivery_receipt" class="nav-box">
                    <img src="<?= base_url('assets/carousel_photo/Grower.jpg') ?>" alt="Module 3">
                    <div>Delivery Receipt</div>
                </a>
            </div>
            <div class="col-4 mb-3">
                <a href="/clients" class="nav-box">
                    <img src="<?= base_url('assets/home_photo/clients_module.png') ?>" alt="Module 4">
                    <div>Clients</div>
                </a>
            </div>
            <div class="col-4 mb-3">
                <a href="/products" class="nav-box">
                    <img src="<?= base_url('assets/home_photo/products_module.png') ?>" alt="Module 5">
                    <div>Products</div>
                </a>
            </div>
            <div class="col-4 mb-3">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>