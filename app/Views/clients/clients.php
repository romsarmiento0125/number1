<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/my_css/clients/clients.css') ?>">

<div class="loader" id="loader"></div>

<div class="mx-5">
    <div class="row">
        <div class="col-12">
            <div class="client_box">
                <div class="client_title">
                    <p>Clients</p>
                </div>
                <hr>
                <div class="">
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Client</button>
                    <div class="">
                        <table id="client_table" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Name</th>
                                    <th>TIN&nbsp;Code</th>
                                    <th>Address</th>
                                    <th>Company</th>
                                    <th>Term</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal_box">
                        <div class="row mb-3">
                            <div class="col-6 px-3">
                                <div class="d-flex align-items-center">
                                    <p>Name:&nbsp;</p>
                                    <input type="text" class="form-control" id="client_name">
                                </div>
                            </div>
                            <div class="col-6 px-3">
                                <div class="d-flex align-items-center">
                                    <p>TIN:&nbsp;</p>
                                    <input type="text" class="form-control" id="client_tin">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 px-3">
                                <div class="d-flex align-items-center">
                                    <p>Business&nbsp;name:&nbsp;</p>
                                    <input type="text" class="form-control" id="client_business_name">
                                </div>
                            </div>
                            <div class="col-6 px-3">
                                <div class="d-flex align-items-center">
                                    <p>Term:&nbsp;</p>
                                    <select class="select2" id="client_term" style="width: 100%;">
                                        <option value="cod">COD</option>
                                        <option value="7">7 Days</option>
                                        <option value="15">15 Days</option>
                                        <option value="21">21 Days</option>
                                        <option value="30">30 Days</option>
                                        <option value="45">45 Days</option>
                                        <option value="60">60 Days</option>
                                        <option value="flex">FLEX</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 px-3">
                                <div class="d-flex align-items-center">
                                    <p>Address:&nbsp;</p>
                                    <input type="text" class="form-control" id="client_address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='save_client'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Client</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal_box">
                    <div class="row mb-3">
                        <div class="col-6 px-3">
                            <div class="d-flex align-items-center">
                                <p>Name:&nbsp;</p>
                                <input type="text" class="form-control" id="edit_client_name">
                            </div>
                        </div>
                        <div class="col-6 px-3">
                            <div class="d-flex align-items-center">
                                <p>TIN:&nbsp;</p>
                                <input type="text" class="form-control" id="edit_client_tin">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 px-3">
                            <div class="d-flex align-items-center">
                                <p>Business&nbsp;name:&nbsp;</p>
                                <input type="text" class="form-control" id="edit_client_business_name">
                            </div>
                        </div>
                        <div class="col-6 px-3">
                            <div class="d-flex align-items-center">
                                <p>Term:&nbsp;</p>
                                <select class="select2" id="edit_client_term" style="width: 100%;">
                                        <option value="cod">COD</option>
                                        <option value="7">7 Days</option>
                                        <option value="15">15 Days</option>
                                        <option value="21">21 Days</option>
                                        <option value="30">30 Days</option>
                                        <option value="45">45 Days</option>
                                        <option value="60">60 Days</option>
                                        <option value="flex">FLEX</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 px-3">
                            <div class="d-flex align-items-center">
                                <p>Address:&nbsp;</p>
                                <input type="text" class="form-control" id="edit_client_address">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='save_edit_client'>Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/my_js/clients/clients.js') ?>"></script>

<?= $this->endSection() ?>