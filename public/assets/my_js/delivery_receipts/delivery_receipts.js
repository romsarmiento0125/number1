var base_url = $('#base_url').val();
var clients = [];
var products = [];
var delivery_receipt = [];
var edit_item_id = 0;
var unique_item_id = 0;
var selected_product_id = 0;
var selected_item_code = "";
var item_table_data = [];
var item_table_list;
var input_counter = 0;
var discount_list = [];
var receipt_list_table = [];
var to_archive_items = [];

$(document).ready(function () {
    get_products_clients_dr();
    add_discount_input();
    initialize_inputs();
    $('#item_remove_discount').hide();
    $('#client_date_details').val(new Date().toISOString().split('T')[0]);
});

$('#clients_details').change(function () {
    clientShowDetails($(this).val());
});

$('#products_details').change(function () {
    productShowDetails($(this).val());
});

$('#item_qty_details').on('input', function () {
    calculateAmount();
});

$('#item_price_details').on('input', function () {
    calculateAmount();
});

function initialize_inputs() {
    $('.item_discounts_details').on('input', function () {
        get_all_discount_value();
        calculateTotalAmount();
    });
}
function showLoader() {
    $('#loader').show();
}

function hideLoader() {
    $('#loader').hide();
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(price);
}

function roundToTwoDecimals(number) {
    return parseFloat(number.toFixed(2));
}

function get_products_clients_dr() {
    showLoader();
    $.ajax({
        url: base_url + '/delivery_receipt/get_products_clients_dr',
        type: 'POST',
        success: function (response) {
            $('#loader').hide();
            var data = JSON.parse(response);
            products = data.products.map(function (product) {
                return {
                    id: product.id,
                    product_name: product.product_name,
                    product_item: product.product_item,
                    product_weight: product.product_weight,
                    product_price: product.product_price,
                    product_name_item: product.product_name + ' ( ' + product.product_item + ' )'
                };
            });
            clients = data.clients.map(function (client) {
                return {
                    id: client.id,
                    client_name: client.client_name,
                    client_tin: client.client_tin,
                    client_business_name: client.client_business_name,
                    client_term: client.client_term,
                    client_address: client.client_address
                };
            });

            delivery_receipt = data.delivery_receipt.map(function (dr) {
                return {
                    dr_id: dr.id,
                    client_name: dr.client_name,
                    client_term: dr.client_term,
                    dr_status: dr.dr_status,
                    dr_date: dr.dr_date
                }
            });

            populateSelect('#clients_details', clients, 'client_name');
            populateSelect('#products_details', products, 'product_name_item');
            delivery_receipt_table();

            hideLoader();
        },
        error: function (xhr) {
            if (xhr.status === 500) {
                var response = JSON.parse(xhr.responseText);
                alert(response.error);
            } else {
                alert('Call a system admin.');
            }
        }
    });
}

function populateSelect(selector, items, textProperty) {
    var select = $(selector);
    select.empty();
    select.append($('<option></option>').attr('value', '').text('')); // Add blank option
    items.forEach(function (item) {
        var option = $('<option></option>').attr('value', item.id).text(item[textProperty]);
        select.append(option);
    });
}

function clientShowDetails(id) {
    var selectedItem = clients.find(client => client.id == id);
    if (selectedItem) {
        $('#client_tin_details').text(selectedItem.client_tin);
        $('#client_address_details').text(selectedItem.client_address);
        $('#client_company_details').text(selectedItem.client_business_name);
        $('#client_term_details').val(selectedItem.client_term).change();
        $('#clients_details').attr('data-client-id', selectedItem.id); // Add this line
    }
}

function productShowDetails(id) {
    var selectedItem = products.find(product => product.id == id);
    selected_product_id = selectedItem.id;
    selected_item_code = selectedItem.product_item;
    if (selectedItem) {
        $('#item_price_details').val(selectedItem.product_price);
        calculateAmount();
    }
}

function totalAmountToCalculate(amount, discount, qty) {
    return amount - (discount * qty);
}

function calculateTotalAmount() {
    var amount = $('#item_amount_details').attr('data-amount');
    var discount = 0;
    get_all_discount_value();
    discount = table_total_discount(discount_list);
    var qty = $('#item_qty_details').val();
    $('#item_total_details').text(formatPrice(totalAmountToCalculate(amount, discount, qty))).attr('data-total', totalAmountToCalculate(amount, discount, qty));
}

function amountToCalculate(price, qty) {
    return price * qty;
}

function calculateAmount() {
    var price = $('#item_price_details').val();
    var qty = $('#item_qty_details').val();
    $('#item_amount_details').text(formatPrice(amountToCalculate(price, qty))).attr('data-amount', amountToCalculate(price, qty));
    calculateTotalAmount();
}

function add_item_details() {
    var item_id = edit_item_id != 0 ? edit_item_id : 0;
    var unique_id = unique_item_id != 0 ? unique_item_id : new Date().getTime();
    var add_item_price = $('#item_price_details').val();
    var add_item_qty = $('#item_qty_details').val();

    if (selected_product_id === 0 || selected_item_code === "") {
        alert("Product is empty.");
        return;
    }

    if (add_item_price === "") {
        alert("Item price is empty.");
        return;
    }

    if (add_item_qty === "") {
        alert("Quantity is empty.");
        return;
    }

    get_all_discount_value(); // Ensure discount_list is updated before adding the item

    item_table_data.push(
        {
            id: item_id,
            unique_id: unique_id,
            product_id: selected_product_id,
            item_code: selected_item_code,
            item_price: add_item_price,
            item_qty: add_item_qty,
            item_discount: discount_list
        }
    );
    item_list_table();
    compute_totals();
    clear_item_fields();
}

function clear_item_fields() {
    selected_product_id = 0;
    selected_item_code = "";
    $('#products_details').empty();
    populateSelect('#products_details', products, 'product_name_item');
    $('#item_price_details').val('');
    $('#item_qty_details').val('');
    $('#item_amount_details').text('').attr('data-amount', '');
    $('#item_total_details').text('').attr('data-total', '');
    $('#add_input_discount').empty();
    input_counter = 0;
    edit_item_id = 0;
    unique_item_id = 0;
    add_discount_input();
}

function item_list_table() {
    item_table_list = $('#item_list_table').DataTable({
        destroy: true,
        data: item_table_data,
        columns: [
            { data: 'unique_id', visible: false },
            { data: 'item_code' },
            { data: 'item_price' },
            { data: 'item_qty' },
            {
                data: function (data) {
                    return formatPrice(amountToCalculate(data.item_price, data.item_qty));
                }
            },
            {
                data: function (data) {
                    var discount = table_total_discount(data.item_discount);
                    return formatPrice(discount * data.item_qty);
                }
            },
            {
                data: function (data) {
                    var discount = table_total_discount(data.item_discount);
                    return formatPrice(totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), discount, data.item_qty));
                }
            },
            {
                data: function (data) {
                    var edit_button = '<button type="button" class="btn btn-warning mx-1 edit_summary_btn"><i class="fa fa-pencil"></i></button>';
                    var remove_button = '<button type="button" class="btn btn-danger mx-1 remove_summary_btn"><i class="fa fa-trash"></i></button>';
                    return edit_button + remove_button;
                }
            }
        ],
        columnDefs: [
            { targets: '_all', className: 'content_center' },
            { targets: [7], className: 'text-center' }
        ],
        drawCallback: function () {
            initSummaryButton();
        }
    });
}

function initSummaryButton() {
    $('.edit_summary_btn').off('click');
    $('.edit_summary_btn').on('click', function () {
        var data = item_table_list.row($(this).parents('tr')).data();
        populateDeliveryReceiptDetails(data);
        removeItemFromTable(data.unique_id);
    });

    $('.remove_summary_btn').off('click');
    $('.remove_summary_btn').on('click', function () {
        var data = item_table_list.row($(this).parents('tr')).data();
        showUniversalModal("Delete Item", "Are you sure you want to delete this item?", function () {
            if (data.id === 0) {
            }
            else {
                to_archive_items.push(
                    {
                        id: data.id
                    }
                );
            }
            removeItemFromTable(data.unique_id);
        });
    });
}

function populateDeliveryReceiptDetails(data) {
    edit_item_id = data.id;
    unique_item_id = data.unique_id;

    $('#products_details').val(data.product_id).trigger('change');
    $('#item_price_details').val(data.item_price);
    $('#item_qty_details').val(data.item_qty);
    $('#item_amount_details').text(formatPrice(amountToCalculate(data.item_price, data.item_qty))).attr('data-amount', amountToCalculate(data.item_price, data.item_qty));
    $('#item_total_details').text(formatPrice(totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), table_total_discount(data.item_discount), data.item_qty))).attr('data-total', totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), table_total_discount(data.item_discount), data.item_qty));
    $('#add_input_discount').empty();
    input_counter = 0;
    data.item_discount.forEach(function (discount, index) {
        add_discount_input();
        $('#item_discount_value_' + (index + 1)).val(discount.discount);
        $('#item_discount_label_' + (index + 1)).val(discount.label);
    });
}

function removeItemFromTable(unique_id) {
    item_table_data = item_table_data.filter(function (item) {
        return item.unique_id !== unique_id;
    });
    item_list_table();
    compute_totals();
}

function compute_totals() {
    $('#discount_summary').empty();
    var sum_tot_amnt = 0;
    var sum_disc = 0;
    item_table_data.forEach(function (item) {
        sum_tot_amnt = sum_tot_amnt + (parseFloat(item.item_price) * parseInt(item.item_qty));
        sum_disc = sum_disc + (table_total_discount(item.item_discount) * parseInt(item.item_qty));
        show_discount_summary(item.item_discount, parseInt(item.item_qty));
    });
    $('#summary_sub_total').text(formatPrice(roundToTwoDecimals(sum_tot_amnt))).attr('data-sub-total', roundToTwoDecimals(sum_tot_amnt));
    $('#summary_total_amount').text(formatPrice(roundToTwoDecimals(sum_tot_amnt - sum_disc))).attr('data-total-amount', roundToTwoDecimals(sum_tot_amnt - sum_disc));
}

function add_discount_input() {
    input_counter++;
    if (input_counter > 1) {
        $('#item_remove_discount').show();
    }
    else {
        $('#item_remove_discount').hide();
    }
    var dicount_input = '<div class="col-5 mb-2">' +
        '<div class="d-flex align-items-center">' +
        '<p>Discount:&nbsp;</p>' +
        '<input type="number" class="form-control item_discounts_details" id="item_discount_value_' + input_counter + '">' +
        '</div>' +
        '</div>';
    var discount_label = '<div class="col-7 mb-2">' +
        '<div class="d-flex align-items-center">' +
        '<p>Discount&nbsp;Label:&nbsp;</p>' +
        '<input type="text" class="form-control item_discounts_details" id="item_discount_label_' + input_counter + '">' +
        '</div>' +
        '</div>';
    $('#add_input_discount').append(dicount_input);
    $('#add_input_discount').append(discount_label);
    initialize_inputs();
}

function remove_discount_input() {
    const container = $("#add_input_discount");
    input_counter--;
    if (input_counter > 1) {
        $('#item_remove_discount').show();
    }
    else {
        $('#item_remove_discount').hide();
    }
    container.children().last().remove();
    container.children().last().remove();
    initialize_inputs();
}

function get_all_discount_value() {
    discount_list = [];
    for (var i = 1; i <= input_counter; i++) {
        var dis_val = $('#item_discount_value_' + i).val();
        var dis_label = $('#item_discount_label_' + i).val();
        discount_list.push(
            {
                label: dis_label,
                discount: dis_val
            }
        );
    }
}

function table_total_discount(data) {
    var disc = 0;
    data.forEach(function (dis) {
        disc = disc + parseFloat(dis.discount) || 0;
    });
    return disc;
}

function show_discount_summary(dis_data, qty) {
    var disc_sum;
    dis_data.forEach(function (dis) {
        if (dis.discount == '') {
            return;
        }
        disc_sum = '<div class="d-flex align-items-center mb-1">' +
            '<p class="fw-bold">' + dis.discount + '</p>' +
            '<p class="mx-2">x</p>' +
            '<p class="fw-bold">' + qty + '</p>' +
            '<p class="mx-2">=</p>' +
            '<p class="fw-bold">' + (formatPrice((dis.discount * qty))) + '</p>' +
            '<p class="fw-bold ms-2">' + dis.label + '</p>' +
            '</div>';
        $('#discount_summary').append(disc_sum);
    });
}

function clearTableAndSummary() {
    item_table_data = [];
    to_archive_items = [];
    item_list_table();
    $('#item_freight_details').val('0');
    $('#summary_sub_total').text('').attr('data-sub-total', '');
    $('#summary_total_amount').text('').attr('data-total-amount', '');
    $('#discount_summary').empty();
    // Clear customer details
    $('#clients_details').val('').change();
    $('#clients_details_name').text('');
    $('#client_tin_details').text('');
    $('#client_address_details').text('');
    $('#client_company_details').text('');
    $('#client_term_details').val('cod').change();
    $('#client_date_details').val(new Date().toISOString().split('T')[0]);
}

function save_delivery_receipt(type) {
    let prompt = type === "printed" ? "print" : "draft";
    showUniversalModal("Confirm Action", "Are you sure you want to " + prompt + " this item?", function () {
        var summaryData = {
            subTotal: $('#summary_sub_total').attr('data-sub-total'),
            totalAmount: $('#summary_total_amount').attr('data-total-amount'),
            freightCost: $('#item_freight_details').val(),
            dr_status: type
        };

        var customerDetail = {
            id: $('#clients_details').attr('data-client-id'),
            name: $('#clients_details option:selected').text(), // Get client name
            tin: $('#client_tin_details').text(),
            terms: $('#client_term_details').val(),
            address: $('#client_address_details').text(),
            business: $('#client_company_details').text(),
            date: $('#client_date_details').val()
        }

        var receiptData = {
            summary: summaryData,
            customer: customerDetail,
            items: item_table_data
        };

        // Validate data
        var missingFields = [];
        if (!customerDetail.id) missingFields.push('Customer Name');
        if (!customerDetail.terms) missingFields.push('Customer Terms');
        if (!customerDetail.date) missingFields.push('Customer Date');
        if (item_table_data.length === 0) missingFields.push('Items');

        // New validation for discount labels
        item_table_data.forEach(function (item) {
            item.item_discount.forEach(function (discount) {
                if (discount.discount && !discount.label) {
                    missingFields.push('Discount Label for discount value ' + discount.discount);
                }
            });
        });

        if (missingFields.length > 0) {
            alert('Invalid data. Please fill in the following fields: ' + missingFields.join(', '));
            return;
        }

        $.ajax({
            url: base_url + '/delivery_receipt/save_draft',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(receiptData),
            success: function (response) {
                var data = JSON.parse(response);
                if (data.delivery === "success") {
                    if (type === "draft") {
                        alert('Draft saved successfully');
                    }
                    else {
                        print_dr(data.receipt_id)
                    }
                }
                else {
                    alert('Failed to save draft');
                }
                clearTableAndSummary();
                get_products_clients_dr();
            },
            error: function (xhr) {
                if (xhr.status === 400) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.error);
                } else {
                    alert('Failed to save draft');
                }
            }
        });
    });
}

function delivery_receipt_table() {
    receipt_list_table = $('#receipt_list_table').DataTable({
        destroy: true,
        data: delivery_receipt,
        order: [0, 'desc'], // Change the order to use the first column (DR_ID)
        columns: [
            { data: 'dr_id' },
            { data: 'client_name' },
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
            { data: 'dr_status' },
            {
                data: 'dr_date', render: function (data) {
                    var date = new Date(data);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return date.toLocaleDateString('en-US', options);
                }
            },
            {
                data: function (data) {
                    var edit_button = '<button type="button" class="btn btn-warning mx-1 edit_dr_btn"><i class="fa fa-pencil"></i></button>';
                    var print_button = '<button type="button" class="btn btn-primary mx-1 print_dr_btn"><i class="fa fa-print"></i></button>';
                    return data.dr_status === 'printed' ? print_button : (edit_button + print_button);
                }
            }
        ],
        columnDefs: [
            { targets: '_all', className: 'content_center' },
            { targets: [5], className: 'text-center' }
        ],
        drawCallback: function () {
            initDeliveryReceiptButton();
        }
    });
}

function initDeliveryReceiptButton() {
    $('.edit_dr_btn').off('click');
    $('.edit_dr_btn').on('click', function () {
        var data = receipt_list_table.row($(this).parents('tr')).data();
        if (data.dr_status === 'printed') {
            alert('Cannot edit a printed receipt.');
            return;
        }
        showUniversalModal("Edit Confirmation", "Are you sure you want to edit this draft?", function () {
            $.ajax({
                url: base_url + '/delivery_receipt/get_delivery_receipt_by_id',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data.dr_id),
                success: function (response) {
                    var receiptData = JSON.parse(response);
                    clear_item_fields(); // Clear the items part
                    populateReceiptModule(receiptData);
                    $('#update_draft_btn').show(); // Show the update draft button
                    $('#cancel_update_draft_btn').show();
                    $('#draft_btn').hide(); // Hide the draft button
                    $('#print_btn').hide();
                    makeCustomerDetailsNonEditable(); // Make customer details non-editable
                },
                error: function (xhr) {
                    if (xhr.status === 500) {
                        var response = JSON.parse(xhr.responseText);
                        alert(response.error);
                    } else {
                        alert('Call a system admin');
                    }
                }
            });
        });
    });

    $('.print_dr_btn').off('click');
    $('.print_dr_btn').on('click', function () {
        var data = receipt_list_table.row($(this).parents('tr')).data();
        showUniversalModal("Print Confirmation", "Are you sure you want to print this delivery receipt?", function () {
            print_dr(data.dr_id);
        });
    });
}

function makeCustomerDetailsNonEditable() {
    $('#clients_details').prop('disabled', true);
}

function makeCustomerDetailsEditable() {
    $('#clients_details').prop('disabled', false);

}

function populateReceiptModule(data) {
    // Populate customer details
    $('.clients_details_container').hide();
    $('.clients_details_name_container').show();

    $('#clients_details_name').text(data.client_name);
    $('#client_tin_details').text(data.client_tin);
    $('#client_address_details').text(data.client_address);
    $('#client_company_details').text(data.client_business_name);
    $('#client_term_details').val(data.client_term_name).change();
    $('#client_date_details').val(data.dr_date);

    // Populate freight cost
    $('#item_freight_details').val(data.freight_cost);

    $('#dr_id').attr('data-dr-id', data.id);

    // Clear and repopulate item table data
    item_table_data = [];
    data.items.forEach(function (item) {
        item_table_data.push({
            unique_id: item.dr_unique_id,
            id: item.dr_item_id,
            product_id: item.product_id,
            item_code: item.dr_item_code,
            item_price: item.dr_item_price,
            item_qty: item.dr_item_qty,
            item_discount: item.discounts.length > 0 ? item.discounts : [{ label: '', discount: '' }] // Insert blank discount if no value
        });
    });
    item_list_table();
    compute_totals();
}

function update_delivery_receipt(type) {
    var summaryData = {
        subTotal: $('#summary_sub_total').attr('data-sub-total'),
        totalAmount: $('#summary_total_amount').attr('data-total-amount'),
        freightCost: $('#item_freight_details').val(),
        dr_status: type
    };

    var customerDetail = {
        terms: $('#client_term_details').val(),
        date: $('#client_date_details').val()
    }

    var dr_id = $('#dr_id').attr('data-dr-id');

    var receiptData = {
        summary: summaryData,
        customer: customerDetail,
        items: item_table_data,
        dr_id: dr_id,
        archive_items: to_archive_items
    };

    // Validate data
    var missingFields = [];
    if (!customerDetail.terms) missingFields.push('Customer Terms');
    if (item_table_data.length === 0) missingFields.push('Items');

    if (missingFields.length > 0) {
        alert('Invalid data. Please fill in the following fields: ' + missingFields.join(', '));
        return;
    }

    console.log(receiptData);

    $.ajax({
        url: base_url + '/delivery_receipt/update_draft',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(receiptData),
        success: function (response) {
            var data = JSON.parse(response);
            console.log(data);
            alert('Draft updated successfully');
            clearTableAndSummary();
            get_products_clients_dr();
            $('.clients_details_container').show();
            $('.clients_details_name_container').hide();
            $('#update_draft_btn').hide(); // Hide the update draft button
            $('#cancel_update_draft_btn').hide();
            $('#draft_btn').show(); // Show the draft button
            $('#print_btn').show();
            makeCustomerDetailsEditable(); // Make customer details editable again
        },
        error: function (xhr) {
            if (xhr.status === 400) {
                var response = JSON.parse(xhr.responseText);
                alert(response.error);
            } else {
                alert('Failed to update draft');
            }
        }
    });
}

function cancel_update_delivery_receipt() {
    clearTableAndSummary();
    get_products_clients_dr();
    $('.clients_details_container').show();
    $('.clients_details_name_container').hide();
    $('#update_draft_btn').hide(); // Hide the update draft button
    $('#cancel_update_draft_btn').hide();
    $('#draft_btn').show(); // Show the draft button
    $('#print_btn').show();
    makeCustomerDetailsEditable(); // Make customer details editable again
}

function print_dr(id) {
    $.ajax({
        url: base_url + '/delivery_receipt/print_dr',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(id),
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                window.open("/delivery_receipt_view/" + id, "_blank");
                get_products_clients_dr();
            }
            else {
                alert('Failed to print delivery receipt');
            }
        },
        error: function (xhr) {
            if (xhr.status === 400) {
                var response = JSON.parse(xhr.responseText);
                alert(response.error);
            } else {
                alert('Failed to print delivery receipt');
            }
        }
    });

}