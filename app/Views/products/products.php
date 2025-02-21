<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/my_css/products/products.css') ?>">

<div class="loader" id="loader"></div>

<div class="mx-5">
    <div class="row">
        <div class="col-12">
            <div class="product_box">
                <div class="product_title">
                    <p>Products</p>
                </div>
                <hr>
                <div class="">
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                    <div class="">
                        <table id="product_table" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Name</th>
                                    <th>Item&nbsp;Code</th>
                                    <th>Units</th>
                                    <th>Weight&nbsp;(kg)</th>
                                    <th>Price</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal_box">
            <div class="row mb-3">
                <div class="col-6 px-3">
                    <div class="d-flex align-items-center">
                        <p>Name:&nbsp;</p>
                        <input type="text" class="form-control" id="product_name">
                    </div>
                </div>
                <div class="col-6 px-3">
                    <div class="d-flex align-items-center">
                        <p>Item&nbsp;code:&nbsp;</p>
                        <input type="text" class="form-control" id="product_item">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Units:&nbsp;</p>
                        <input type="text" class="form-control" id="product_unit">
                    </div>
                </div>
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Weight&nbsp;(kg):&nbsp;</p>
                        <input type="number" class="form-control" id="product_weight">
                    </div>
                </div>
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Price:&nbsp;</p>
                        <input type="number" class="form-control" id="product_price">
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='save_product'>Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Edit Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal_box">
            <div class="row mb-3">
                <div class="col-6 px-3">
                    <div class="d-flex align-items-center">
                        <p>Name:&nbsp;</p>
                        <input type="text" class="form-control" id="edit_product_name">
                    </div>
                </div>
                <div class="col-6 px-3">
                    <div class="d-flex align-items-center">
                        <p>Item&nbsp;code:&nbsp;</p>
                        <input type="text" class="form-control" id="edit_product_item">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Units:&nbsp;</p>
                        <input type="text" class="form-control" id="edit_product_unit">
                    </div>
                </div>
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Weight&nbsp;(kg):&nbsp;</p>
                        <input type="number" class="form-control" id="edit_product_weight">
                    </div>
                </div>
                <div class="col-4 px-3">
                    <div class="d-flex align-items-center">
                        <p>Price:&nbsp;</p>
                        <input type="number" class="form-control" id="edit_product_price">
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='save_edit_product'>Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/my_js/products/products.js') ?>"></script>

<?= $this->endSection() ?>