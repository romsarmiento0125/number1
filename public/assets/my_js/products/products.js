var base_url = $('#base_url').val();
var product_table_data;

function showLoader() {
    $('#loader').show();
}

function hideLoader() {
    $('#loader').hide();
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(price);
}

$(document).ready(function () {
    get_table_products();
});

function get_table_products() {
    showLoader();
    $.ajax({
        url: base_url + '/products/get_table_products',
        type: 'POST',
        beforeSend: function () {
            $('#loader').show();
        },
        success: function (response) {
            var data = JSON.parse(response);
            product_table(data);
            hideLoader();
        },
        error: function () {
            hideLoader();
        }
    });
}

function product_table(data) {
    product_table_data = $('#product_table').DataTable({
        destroy: true,
        data: data,
        columns: [
            { data: 'id', visible: false },
            { data: 'product_name' },
            { data: 'product_item' },
            { data: 'product_unit' },
            { data: 'product_weight' },
            {
                data: function (data) {
                    return formatPrice(data.product_price);
                }
            },
            {
                data: function (data) {
                    return '<button type="button" class="btn btn-warning edit_product"><i class="fa fa-pencil"></i></button>';
                }
            }
        ],
        columnDefs: [
            { targets: '_all', className: 'content_center' },
            { targets: [5], className: 'text-center' }
        ],
        drawCallback: function () {
            initButton();
        }
    });
}

function initButton() {
    $('.edit_product').off('click');
    $('.edit_product').on('click', function () {
        var data = product_table_data.row($(this).parents('tr')).data();
        $('#edit_product_name').val(data.product_name);
        $('#edit_product_name').attr('data-id', data.id);
        $('#edit_product_unit').val(data.product_unit);
        $('#edit_product_item').val(data.product_item);
        $('#edit_product_weight').val(data.product_weight);
        $('#edit_product_price').val(data.product_price);
        $('#editProductModal').modal('show');
    });
}

$('#save_product').click(function () {
    var product_data = {
        product_name: $('#product_name').val(),
        product_item: $('#product_item').val(),
        product_unit: $('#product_unit').val(),
        product_weight: $('#product_weight').val(),
        product_price: parseFloat($('#product_price').val()).toFixed(2)
    }

    if (product_data.product_name === '' || product_data.product_item === '' || product_data.product_unit === '' || product_data.product_weight === '' || product_data.product_price === '') {
        alert('All fields are required');
        return;
    }

    if (isProductNameExists(product_data.product_name)) {
        alert('Product name already exists');
        return;
    }

    if (isProductItemExists(product_data.product_item)) {
        alert('Product item code already exists');
        return;
    }

    showLoader();
    $.ajax({
        url: base_url + '/products/save_product',
        type: 'POST',
        data: JSON.stringify(product_data),
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert(data.message);
                get_table_products();
                clear_modal_fields();
                $('#addProductModal').modal('hide');
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

$('#save_edit_product').click(function () {
    var product_data = {
        product_name: $('#edit_product_name').val(),
        product_name_attr: $('#edit_product_name').attr('data-id'),
        product_unit: $('#edit_product_unit').val(),
        product_item: $('#edit_product_item').val(),
        product_weight: $('#edit_product_weight').val(),
        product_price: parseFloat($('#edit_product_price').val()).toFixed(2)
    }

    if (product_name === '' || product_unit === '' || product_item === '' || product_weight === '' || product_price === '') {
        alert('All fields are required');
        return;
    }

    showLoader();
    $.ajax({
        url: base_url + '/products/edit_product',
        type: 'POST',
        data: JSON.stringify(product_data),
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert(data.message);
                get_table_products();
                $('#editProductModal').modal('hide');
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

function isProductNameExists(product_name) {
    var exists = false;
    product_table_data.rows().every(function () {
        var data = this.data();
        if (data.product_name === product_name) {
            exists = true;
            return false;
        }
    });
    return exists;
}

function isProductItemExists(product_item) {
    var exists = false;
    product_table_data.rows().every(function () {
        var data = this.data();
        if (data.product_item === product_item) {
            exists = true;
            return false;
        }
    });
    return exists;
}

function clear_modal_fields() {
    $('#product_name').val('');
    $('#product_item').val('');
    $('#product_weight').val('');
    $('#product_price').val('');
}