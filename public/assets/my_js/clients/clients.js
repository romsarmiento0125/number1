var base_url = $('#base_url').val();
var client_table_data;

function showLoader() {
    $('#loader').show();
}

function hideLoader() {
    $('#loader').hide();
}

$(document).ready(function () {
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

function get_table_clients() {
    showLoader();
    $.ajax({
        url: base_url + '/clients/get_table_clients',
        type: 'POST',
        success: function (response) {
            var data = JSON.parse(response);
            client_table(data);
            hideLoader();
        },
        error: function () {
            hideLoader();
        }
    });
}

function client_table(data) {
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
                data: function (data) {
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
                data: function (data) {
                    return '<button type="button" class="btn btn-warning edit_client"><i class="fa fa-pencil"></i></button>';
                }
            }
        ],
        columnDefs: [
            { targets: '_all', className: 'content_center' },
            { targets: [6], className: 'text-center' }
        ],
        drawCallback: function () {
            initButton();
        }
    });
}

function initButton() {
    $('.edit_client').off('click');
    $('.edit_client').on('click', function () {
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

$('#save_client').click(function () {
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
        url: base_url + '/clients/save_client',
        type: 'POST',
        data: {
            client_name: client_name,
            client_tin: client_tin,
            client_business_name: client_business_name,
            client_term: client_term,
            client_address: client_address
        },
        success: function (response) {
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
        error: function () {
            hideLoader();
        }
    });
});

$('#save_edit_client').click(function () {
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
        url: base_url + '/clients/edit_client',
        type: 'POST',
        data: {
            client_name: client_name,
            client_name_attr: client_name_attr,
            client_tin: client_tin,
            client_business_name: client_business_name,
            client_term: client_term,
            client_address: client_address
        },
        success: function (response) {
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
        error: function () {
            hideLoader();
        }
    });
});

function isClientNameExists(client_name) {
    var exists = false;
    client_table_data.rows().every(function () {
        var data = this.data();
        if (data.client_name === client_name) {
            exists = true;
            return false;
        }
    });
    return exists;
}

function clear_modal_fields() {
    $('#client_name').val('');
    $('#client_tin').val('');
    $('#client_business_name').val('');
    $('#client_address').val('');
}