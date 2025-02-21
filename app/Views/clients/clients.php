<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .client_box {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 15px; 
        background-color: #f9f9f9;
        border-top: 5px solid #80b380; 
    }

    .client_title p{
        font-size: 1.3rem;
        font-weight: 600;
    }

    .modal_box {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        /* box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3); */
    }

    .content_center {
        align-content: center;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 999;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

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

<script>
    var client_table_data;

    function showLoader() {
        $('#loader').show();
    }

    function hideLoader() {
        $('#loader').hide();
    }

    $(document).ready(function() {
        get_table_clients();
        $('#addClientModal').on('shown.bs.modal', function () {
            $('.select2').select2({
                dropdownParent: $('#addClientModal')
            });
        });
        $('#editClientModal').on('shown.bs.modal', function () {
            $('.select2').select2({
                dropdownParent: $('#editClientModal')
            });
        });
    });

    function get_table_clients () {
        showLoader();
        $.ajax({
            url: '<?= base_url('clients/get_table_clients') ?>',
            type: 'POST',
            success: function(response) {
                var data = JSON.parse(response);
                client_table(data);
                hideLoader();
            },
            error: function() {
                hideLoader();
            }
        });
    }

    function client_table (data) {
        client_table_data = $('#client_table').DataTable({
            destroy: true,
            data: data,
            columns: [
                { data: 'id', visible: false },
                { data: 'client_name' },
                { data: 'client_tin' },
                { data: 'client_address' },
                { data: 'client_business_name' },
                { 
                    data: function(data) {
                        var term = '';
                        switch (data.client_term) {
                            case 'cod':
                                term = 'COD';
                                break;
                            case '7':
                                term = '7 Days';
                                break;
                            case '15':
                                term = '15 Days';
                                break;
                            case '21':
                                term = '21 Days';
                                break;
                            case '30':
                                term = '30 Days';
                                break;
                            case '45':
                                term = '45 Days';
                                break;
                            case '60':
                                term = '60 Days';
                                break;
                            case 'flex':
                                term = 'FLEX';
                                break;
                        }
                        return term;
                    }
                },
                { 
                    data: function(data) {
                        return '<button type="button" class="btn btn-warning edit_client"><i class="fa fa-pencil"></i></button>'; 
                    }
                }
            ],
            columnDefs: [
                { targets: '_all', className: 'content_center' },
                { targets: [6], className: 'text-center' }
            ],
            drawCallback: function() {
                initButton();
            }
        });
    }

    function initButton() {
        $('.edit_client').off('click');
        $('.edit_client').on('click', function() {
            var data = client_table_data.row($(this).parents('tr')).data();
            $('#edit_client_name').val(data.client_name);
            $('#edit_client_name').attr('data-id', data.id);
            $('#edit_client_tin').val(data.client_tin);
            $('#edit_client_business_name').val(data.client_business_name);
            $('#edit_client_term').val(data.client_term).trigger('change');
            $('#edit_client_address').val(data.client_address);
            $('#editClientModal').modal('show');
        });
    }

    $('#save_client').click(function() {
        var client_name = $('#client_name').val();
        var client_tin = $('#client_tin').val();
        var client_business_name = $('#client_business_name').val();
        var client_term = $('#client_term').val();
        var client_address = $('#client_address').val();

        if (client_name === '' || client_term === '') {
            alert('Client name and term are required');
            return;
        }

        if (isClientNameExists(client_name)) {
            alert('Client name already exists');
            return;
        }

        showLoader();
        $.ajax({
            url: '<?= base_url('clients/save_client') ?>',
            type: 'POST',
            data: {
                client_name: client_name,
                client_tin: client_tin,
                client_business_name: client_business_name,
                client_term: client_term,
                client_address: client_address
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    get_table_clients();
                    clear_modal_fields();
                    $('#addClientModal').modal('hide');
                } else if (data.status === 'exists') {
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
                hideLoader();
            },
            error: function() {
                hideLoader();
            }
        });
    });

    $('#save_edit_client').click(function() {
        var client_name = $('#edit_client_name').val();
        var client_name_attr = $('#edit_client_name').attr('data-id');
        var client_tin = $('#edit_client_tin').val();
        var client_business_name = $('#edit_client_business_name').val();
        var client_term = $('#edit_client_term').val();
        var client_address = $('#edit_client_address').val();

        if (client_name === '' || client_term === '') {
            alert('Client name and term are required');
            return;
        }

        showLoader();
        $.ajax({
            url: '<?= base_url('clients/edit_client') ?>',
            type: 'POST',
            data: {
                client_name: client_name,
                client_name_attr: client_name_attr,
                client_tin: client_tin,
                client_business_name: client_business_name,
                client_term: client_term,
                client_address: client_address
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    get_table_clients();
                    $('#editClientModal').modal('hide');
                } else {
                    alert('Error: ' + data.message);
                }
                hideLoader();
            },
            error: function() {
                hideLoader();
            }
        });
    });

    function isClientNameExists(client_name) {
        var exists = false;
        client_table_data.rows().every(function() {
            var data = this.data();
            if (data.client_name === client_name) {
                exists = true;
                return false;
            }
        });
        return exists;
    }

    function clear_modal_fields () {
        $('#client_name').val('');
        $('#client_tin').val('');
        $('#client_business_name').val('');
        $('#client_address').val('');
    }
</script>

<?= $this->endSection() ?>