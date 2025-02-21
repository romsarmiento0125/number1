<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .sales_invoice_box {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 15px; 
        background-color:#f0f0f0;
        border-top: 5px solid #80b380; 
    }

    .sales_invoice_title p{
        font-size: 1.3rem;
        font-weight: 600;
    }
    
    .sales_invoice_details_box {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 15px; 
        background-color: #f9f9f9;
    }

    .sales_invoice_details_title p{
        font-size: 1rem;
        font-weight: 500;
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
            <div class="sales_invoice_box">
                <div class="sales_invoice_title">
                    <p id="si_id">Sales Invoice</p>
                </div>
                <hr>
                <div class="">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 mb-4">
                                    <div class="sales_invoice_details_box">
                                        <div class="sales_invoice_details_title">
                                            <p>Customer Details</p>
                                        </div>
                                        <hr>
                                        <div class="clients_details_container">
                                            <div class="d-flex align-items-center mb-2">
                                                <p>Name:&nbsp;</p>
                                                <select class="select2" id="clients_details" style="width: 100%;">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clients_details_name_container" style="display: none;">
                                            <div class="d-flex align-items-center mb-2">
                                                <p>Name:&nbsp;</p>
                                                <p class="fw-bold" id="clients_details_name">&nbsp;</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p>TIN:&nbsp;</p>
                                            <p class="fw-bold" id="client_tin_details">&nbsp;</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p>Address:&nbsp;</p>
                                            <p class="fw-bold" id="client_address_details">&nbsp;</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p>Company:&nbsp;</p>
                                            <p class="fw-bold" id="client_company_details">&nbsp;</p>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <p>Terms:&nbsp;</p>
                                                    <select class="select2" id="client_term_details" style="width: 100%;">
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
                                            <div class="col-6 content_center">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <p>Date:&nbsp;</p>
                                                    <input type="date" class="form-control" id="client_date_details">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 mb-4">
                                    <div class="sales_invoice_details_box">
                                        <div class="sales_invoice_details_title">
                                            <p>Items</p>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center mb-2">
                                            <p>Product:&nbsp;</p>
                                            <select class="select2" id="products_details" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <p>Price:&nbsp;</p>
                                                    <input type="number" class="form-control" id="item_price_details">
                                                </div>
                                            </div>
                                            <div class="col-6 content_center">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <p>Qty:&nbsp;</p>
                                                    <input type="number" class="form-control" id="item_qty_details">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <p>Amount:&nbsp;</p>
                                                    <p class="fw-bold" id="item_amount_details">&nbsp;</p>
                                                </div>
                                            </div>
                                            <div class="col-6 content_center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="item_switch_details">
                                                        <label class="form-check-label" id="item_switch_label_detail">Not Vatable</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-7">
                                                <div class="d-flex align-items-center">
                                                    <p>Vatable&nbsp;Sales:&nbsp;</p>
                                                    <p class="fw-bold" id="item_vatsales_details">&nbsp;</p>
                                                </div>
                                            </div>
                                            <div class="col-5 content_center">
                                                <div class="d-flex align-items-center">
                                                    <p>Vat:&nbsp;</p>
                                                    <p class="fw-bold" id="item_vat_details">&nbsp;</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-10">
                                                <div class="row"  id="add_input_discount">

                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger" id="item_remove_discount" onclick="remove_discount_input()"><i class="fa fa-trash"></i></button>
                                                <button type="button" class="btn btn-success" id="item_add_discount" onclick="add_discount_input()"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p>Total Amount:&nbsp;</p>
                                            <p class="fw-bold" id="item_total_details">&nbsp;</p>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary" onclick="add_item_details()">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="sales_invoice_details_box">
                                <div class="sales_invoice_details_title">
                                    <p>Summary</p>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="item_list_table" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="d-none">ID</th>
                                                <th>Item&nbsp;Code</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                                <th>Discount</th>
                                                <th>Total&nbsp;Amount</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="offset-2 col-4">
                                         <div class="d-flex">
                                            <div class="">
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>Freight:&nbsp;</p>
                                                    <input type="number" class="form-control" id="item_freight_details" value='0'>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                         <div class="d-flex">
                                            <div class="">
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>Total&nbsp;amount:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_total_amount"></p>
                                                </div>
                                                <p>Discount:</p>
                                                <div class="" id="discount_summary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-1 col-5">
                                        <div class="d-flex">
                                            <div class="">
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>VATable&nbsp;Sales:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_vatable_sales"></p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>VAT-Exempt&nbsp;Sales:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_vat_exempt_sales"></p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>VAT-Zero&nbsp;Rated&nbsp;Sales:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_zero_rated"></p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>VAT&nbsp;Amount:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_vat_amount"></p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <p>TOTAL&nbsp;AMOUNT&nbsp;DUE:&nbsp;</p>
                                                    <p class="fw-bold" id="summary_total_amount_due"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-secondary me-2" id="update_draft_btn" style="display: none;" onclick="update_sales_invoice('draft')">Update Draft</button>
                                    <button class="btn btn-danger me-2" id="cancel_update_draft_btn" style="display: none;" onclick="cancel_update_sales_invoice()">Cancel</button>
                                    <button class="btn btn-secondary me-2" id="draft_btn" onclick="save_sales_invoice('draft')">Draft</button>
                                    <button class="btn btn-success" id="print_btn" onclick="save_sales_invoice('printed')">Print</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="sales_invoice_details_box">
                                <div class="sales_invoice_details_title">
                                    <p>Invoices</p>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="invoice_list_table" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SI_ID</th>
                                                <th>Name</th>
                                                <th>Terms</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var clients = [];
    var products = [];
    var sales_invoice = [];
    var vat_switch = false;
    var edit_item_id = 0;
    var unique_item_id = 0;
    var selected_product_id = 0;
    var selected_item_code = "";
    var item_table_data = [];
    var item_table_list;
    var input_counter = 0;
    var discount_list = [];
    var invoice_list_table = [];
    var to_archive_items = [];

    $(document).ready(function() {
        get_products_clients_si();
        add_discount_input();
        initialize_inputs();
        $('#item_remove_discount').hide();
        $('#client_date_details').val(new Date().toISOString().split('T')[0]);
    });

    $('#clients_details').change(function() {
        clientShowDetails($(this).val());
    });

    $('#products_details').change(function() {
        productShowDetails($(this).val());
    });
    
    $('#item_switch_details').change(function() {
        if ($(this).is(':checked')) {
            $('#item_switch_label_detail').text('Vatable');
            vat_switch = true;
            calculateVatableSales();
            calculateVat();
        } else {
            $('#item_switch_label_detail').text('Not Vatable');
            vat_switch = false;
            $('#item_vatsales_details').text('').attr('data-vatsales', '');
            $('#item_vat_details').text('').attr('data-vat', '');
        }
    });
    
    $('#item_qty_details').on('input', function() {
        calculateAmount();
        calculateVatableSales();
        calculateVat();
    });
    
    $('#item_price_details').on('input', function() {
        calculateAmount();
        calculateVatableSales();
        calculateVat();
    });

    function initialize_inputs() {
        $('.item_discounts_details').on('input', function() {
            get_all_discount_value();
            calculateTotalAmount();
            calculateVatableSales();
            calculateVat();
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

    function get_products_clients_si() {
        showLoader();
        $.ajax({
            url: '<?= base_url('sales_invoice/get_products_clients_si') ?>',
            type: 'POST',
            success: function(response) {
                $('#loader').hide();
                var data = JSON.parse(response); 
                products = data.products.map(function(product) {
                    return {
                        id: product.id,
                        product_name: product.product_name,
                        product_item: product.product_item,
                        product_weight: product.product_weight,
                        product_price: product.product_price,
                        product_name_item: product.product_name + ' ( ' + product.product_item + ' )'
                    };
                });
                clients = data.clients.map(function(client) {
                    return {
                        id: client.id,
                        client_name: client.client_name,
                        client_tin: client.client_tin,
                        client_business_name: client.client_business_name,
                        client_term: client.client_term,
                        client_address: client.client_address
                    };
                });

                sales_invoice = data.sales_invoice.map(function(si) {
                    return {
                        si_id: si.id,
                        client_name: si.client_name,
                        client_term: si.client_term,
                        si_status: si.si_status,
                        si_date: si.si_date
                    }
                });

                populateSelect('#clients_details', clients, 'client_name');
                populateSelect('#products_details', products, 'product_name_item');
                sales_invoice_table();
                
                hideLoader();
            },
            error: function(xhr) {
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
        items.forEach(function(item) {
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

    function vatableSalesToCalculate(total_amount) {
        return total_amount / 1.12;
    }
    
    function calculateVatableSales() {
        if(vat_switch) {
            var total_amount = $('#item_total_details').attr('data-total');
            $('#item_vatsales_details').text(formatPrice(vatableSalesToCalculate(total_amount))).attr('data-vatsales', vatableSalesToCalculate(total_amount));
        }
    }

    function vatToCalculate(total_amount) {
        return total_amount - ( total_amount / 1.12 );
    }

    function calculateVat() {
        if(vat_switch) {
            var total_amount = $('#item_total_details').attr('data-total');
            $('#item_vat_details').text(formatPrice(vatToCalculate(total_amount))).attr('data-vat', vatToCalculate(total_amount));
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
        $('#item_amount_details').text(formatPrice(amountToCalculate(price,qty))).attr('data-amount', amountToCalculate(price,qty));
        calculateTotalAmount();
    }

    function add_item_details() {
        var item_id = edit_item_id != 0 ? edit_item_id : 0;
        var unique_id = unique_item_id != 0 ? unique_item_id : new Date().getTime();
        var add_item_price = $('#item_price_details').val();
        var add_item_qty = $('#item_qty_details').val();
        var add_item_checkbox = $('#item_switch_details').is(":checked");
        var add_item_vatable_sales = $('#item_vatsales_details').attr('data-vatsales');
        var add_item_vat = $('#item_vat_details').attr('data-vat');

        if(selected_product_id === 0 || selected_item_code === "") {
            alert("Product is empty.");
            return;
        }

        if(add_item_price === "") {
            alert("Item price is empty.");
            return;
        }

        if(add_item_qty === "") {
            alert("Quantity is empty.");
            return;
        }

        add_item_vatable_sales = (add_item_vatable_sales === "" || add_item_vatable_sales === undefined) ? 0 : add_item_vatable_sales;
        add_item_vat = (add_item_vat === "" || add_item_vat === undefined) ? 0 : add_item_vat;

        get_all_discount_value(); // Ensure discount_list is updated before adding the item

        item_table_data.push(
            {
                id: item_id,
                unique_id: unique_id,
                product_id: selected_product_id,
                item_code: selected_item_code,
                item_price: add_item_price,
                item_qty: add_item_qty,
                item_discount: discount_list,
                item_vatable_sales: add_item_vatable_sales,
                item_vat: add_item_vat,
                item_vat_check: add_item_checkbox
            }
        );
        item_list_table();
        compute_vatables();
        clear_item_fields();
    }

    function clear_item_fields() {
        selected_product_id = 0;
        selected_item_code = "";
        $('#products_details').empty();
        populateSelect('#products_details', products, 'product_name_item');
        $('#item_price_details').val('');
        $('#item_qty_details').val('');
        $('#item_switch_details').prop('checked', false);
        vat_switch = false;
        $('#item_vatsales_details').text('').attr('data-vatsales', '');
        $('#item_vat_details').text('').attr('data-vat', '');
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
                { data: 'item_code'},
                { data: 'item_price'},
                { data: 'item_qty'},
                { 
                    data: function(data) {
                        return formatPrice(amountToCalculate(data.item_price, data.item_qty));
                    }
                },
                { 
                    data: function(data) {
                        var discount = table_total_discount(data.item_discount);
                        return formatPrice(discount * data.item_qty);
                    }
                },
                { 
                    data: function(data) {
                        var discount = table_total_discount(data.item_discount);
                        return formatPrice(totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), discount, data.item_qty));
                    }
                },
                { 
                    data: function(data) {
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
            drawCallback: function() {
                initSummaryButton();
            }
        });
    }

    function initSummaryButton() {
        $('.edit_summary_btn').off('click');
        $('.edit_summary_btn').on('click', function() {
            var data = item_table_list.row($(this).parents('tr')).data();
            populateSalesInvoiceDetails(data);
            removeItemFromTable(data.unique_id);
        });

        $('.remove_summary_btn').off('click');
        $('.remove_summary_btn').on('click', function() {
            var data = item_table_list.row($(this).parents('tr')).data();
            showUniversalModal("Delete Item","Are you sure you want to delete this item?",function() {
                if(data.id === 0) {
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

    function populateSalesInvoiceDetails(data) {
        edit_item_id = data.id;
        unique_item_id = data.unique_id;
        
        $('#products_details').val(data.product_id).trigger('change');
        $('#item_price_details').val(data.item_price);
        $('#item_qty_details').val(data.item_qty);
        $('#item_switch_details').prop('checked', data.item_vat_check);
        vat_switch = data.item_vat_check;
        $('#item_vatsales_details').text(formatPrice(data.item_vatable_sales)).attr('data-vatsales', data.item_vatable_sales);
        $('#item_vat_details').text(formatPrice(data.item_vat)).attr('data-vat', data.item_vat);
        $('#item_amount_details').text(formatPrice(amountToCalculate(data.item_price, data.item_qty))).attr('data-amount', amountToCalculate(data.item_price, data.item_qty));
        $('#item_total_details').text(formatPrice(totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), table_total_discount(data.item_discount), data.item_qty))).attr('data-total', totalAmountToCalculate(amountToCalculate(data.item_price, data.item_qty), table_total_discount(data.item_discount), data.item_qty));
        $('#add_input_discount').empty();
        input_counter = 0;
        data.item_discount.forEach(function(discount, index) {
            add_discount_input();
            $('#item_discount_value_' + (index + 1)).val(discount.discount);
            $('#item_discount_label_' + (index + 1)).val(discount.label);
        });
    }

    function removeItemFromTable(unique_id) {
        item_table_data = item_table_data.filter(function(item) {
            return item.unique_id !== unique_id;
        });
        item_list_table();
        compute_vatables();
    }

    function compute_vatables() {
        $('#discount_summary').empty();
        var sum_tot_amnt = 0;
        var sum_vat_sales = 0;
        var sum_vat = 0;
        var sum_disc = 0;
        var sum_exempt = 0;
        item_table_data.forEach(function(item) {
            sum_tot_amnt = sum_tot_amnt + (parseFloat(item.item_price) * parseInt(item.item_qty));
            sum_vat_sales = sum_vat_sales + parseFloat(item.item_vatable_sales);
            sum_vat = sum_vat + parseFloat(item.item_vat);
            sum_disc = sum_disc + (table_total_discount(item.item_discount) * parseInt(item.item_qty));
            if(!item.item_vat_check) {
                sum_exempt = sum_exempt + ((parseFloat(item.item_price) * parseInt(item.item_qty)) - (table_total_discount(item.item_discount) * parseInt(item.item_qty)));
            }
            show_discount_summary(item.item_discount, parseInt(item.item_qty));
        });
        $('#summary_total_amount').text(formatPrice(roundToTwoDecimals(sum_tot_amnt))).attr('data-total-amount', roundToTwoDecimals(sum_tot_amnt));
        $('#summary_vatable_sales').text(formatPrice(roundToTwoDecimals(sum_vat_sales))).attr('data-vatable-sales', roundToTwoDecimals(sum_vat_sales));
        $('#summary_vat_amount').text(formatPrice(roundToTwoDecimals(sum_vat))).attr('data-vat-amount', roundToTwoDecimals(sum_vat));
        $('#summary_total_amount_due').text(formatPrice(roundToTwoDecimals(sum_tot_amnt - sum_disc))).attr('data-total-amount-due', roundToTwoDecimals(sum_tot_amnt - sum_disc));
        $('#summary_vat_exempt_sales').text(formatPrice(roundToTwoDecimals(sum_exempt))).attr('data-vat-exempt-sales', roundToTwoDecimals(sum_exempt));
        $('#summary_zero_rated').text('0');
    }

    function add_discount_input() {
        input_counter++;
        if(input_counter > 1) {
            $('#item_remove_discount').show();
        }
        else {  
            $('#item_remove_discount').hide();
        }
        var dicount_input = '<div class="col-5 mb-2">'+
            '<div class="d-flex align-items-center">'+
            '<p>Discount:&nbsp;</p>'+
            '<input type="number" class="form-control item_discounts_details" id="item_discount_value_' + input_counter + '">'+
            '</div>'+
            '</div>';
        var discount_label = '<div class="col-7 mb-2">'+
            '<div class="d-flex align-items-center">'+
            '<p>Discount&nbsp;Label:&nbsp;</p>'+
            '<input type="text" class="form-control item_discounts_details" id="item_discount_label_' + input_counter + '">'+
            '</div>'+
            '</div>';
        $('#add_input_discount').append(dicount_input);
        $('#add_input_discount').append(discount_label);
        initialize_inputs();
    }

    function remove_discount_input() {
        const container = $("#add_input_discount");
        input_counter--;
        if(input_counter > 1) {
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
        for(var i = 1; i <= input_counter; i++){
            var dis_val = $('#item_discount_value_'+i).val();
            var dis_label = $('#item_discount_label_'+i).val();
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
        data.forEach(function(dis) {
            disc = disc + parseFloat(dis.discount) || 0;
        });
        return disc;
    }

    function show_discount_summary(dis_data, qty) {
        var disc_sum;
        dis_data.forEach(function(dis) {
            if(dis.discount == '') {
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
        $('#summary_total_amount').text('').attr('data-total-amount', '');
        $('#summary_vatable_sales').text('').attr('data-vatable-sales', '');
        $('#summary_vat_amount').text('').attr('data-vat-amount', '');
        $('#summary_total_amount_due').text('').attr('data-total-amount-due', '');
        $('#summary_vat_exempt_sales').text('').attr('data-vat-exempt-sales', '');
        $('#summary_zero_rated').text('0');
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

    function save_sales_invoice(type) {
        let prompt = type === "printed" ? "print" : "draft";
        showUniversalModal("Confirm Action","Are you sure you want to " + prompt + " this item?",function() {
            var summaryData = {
                totalAmount: $('#summary_total_amount').attr('data-total-amount'),
                vatableSales: $('#summary_vatable_sales').attr('data-vatable-sales'),
                vatAmount: $('#summary_vat_amount').attr('data-vat-amount'),
                totalAmountDue: $('#summary_total_amount_due').attr('data-total-amount-due'),
                vatExemptSales: $('#summary_vat_exempt_sales').attr('data-vat-exempt-sales'),
                zeroRated: '0',
                freightCost: $('#item_freight_details').val(),
                si_status: type
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

            var invoiceData = {
                summary: summaryData,
                customer: customerDetail,
                items: item_table_data
            };

            // Validate data
            var missingFields = [];
            if (!summaryData.totalAmount) missingFields.push('Total Amount');
            if (!summaryData.vatableSales) missingFields.push('VATable Sales');
            if (!summaryData.vatAmount) missingFields.push('VAT Amount');
            if (!summaryData.totalAmountDue) missingFields.push('Total Amount Due');
            if (!summaryData.vatExemptSales) missingFields.push('VAT Exempt Sales');
            if (!customerDetail.id) missingFields.push('Customer Name');
            if (!customerDetail.terms) missingFields.push('Customer Terms');
            if (item_table_data.length === 0) missingFields.push('Items');

            // New validation for discount labels
            item_table_data.forEach(function(item) {
                item.item_discount.forEach(function(discount) {
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
                url: '<?= base_url('sales_invoice/save_draft') ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(invoiceData),
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.invoice === "success") {
                        if(type === "draft") {
                            alert('Draft saved successfully');
                        }
                        else {
                            print_si(data.invoice_id)
                        }
                    }
                    else {
                        alert('Failed to save draft');
                    }
                    clearTableAndSummary();
                    get_products_clients_si();
                },
                error: function(xhr) {
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

    function sales_invoice_table() {
        invoice_list_table = $('#invoice_list_table').DataTable({
            destroy: true,
            data: sales_invoice,
            order: [0, 'desc'], // Change the order to use the first column (SI_ID)
            columns: [
                { data: 'si_id'},
                { data: 'client_name'},
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
                { data: 'si_status'},
                { data: 'si_date', render: function(data) {
                    var date = new Date(data);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return date.toLocaleDateString('en-US', options);
                }},
                { 
                    data: function(data) {
                        var edit_button = '<button type="button" class="btn btn-warning mx-1 edit_si_btn"><i class="fa fa-pencil"></i></button>';
                        var print_button = '<button type="button" class="btn btn-primary mx-1 print_si_btn"><i class="fa fa-print"></i></button>';
                        return data.si_status === 'printed' ? print_button : (edit_button + print_button);
                    }
                }
            ],
            columnDefs: [
                { targets: '_all', className: 'content_center' },
                { targets: [5], className: 'text-center' }
            ],
            drawCallback: function() {
                initSalesInvoiceButton();
            }
        });
    }

    function initSalesInvoiceButton() {
        $('.edit_si_btn').off('click');
        $('.edit_si_btn').on('click', function() {
            var data = invoice_list_table.row($(this).parents('tr')).data();
            if (data.si_status === 'printed') {
                alert('Cannot edit a printed invoice.');
                return;
            }
            showUniversalModal("Edit Confirmation", "Are you sure you want to edit this draft?",function() {
                $.ajax({
                    url: '<?= base_url('sales_invoice/get_sales_invoice_by_id') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data.si_id),
                    success: function(response) {
                        var invoiceData = JSON.parse(response);
                        clear_item_fields(); // Clear the items part
                        populateInvoiceModule(invoiceData);
                        $('#update_draft_btn').show(); // Show the update draft button
                        $('#cancel_update_draft_btn').show(); 
                        $('#draft_btn').hide(); // Hide the draft button
                        $('#print_btn').hide(); 
                        makeCustomerDetailsNonEditable(); // Make customer details non-editable
                    },
                    error: function(xhr) {
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

        $('.print_si_btn').off('click');
        $('.print_si_btn').on('click', function() {
            var data = invoice_list_table.row($(this).parents('tr')).data();
            showUniversalModal("Print Confirmation", "Are you sure you want to print this sales invoice?",function() {
                print_si(data.si_id);
            });
        });
    }

    function makeCustomerDetailsNonEditable() {
        $('#clients_details').prop('disabled', true);
    }

    function makeCustomerDetailsEditable() {
        $('#clients_details').prop('disabled', false);

    }

    function populateInvoiceModule(data) {
        // Populate customer details
        $('.clients_details_container').hide();
        $('.clients_details_name_container').show();

        $('#clients_details_name').text(data.client_name);
        $('#client_tin_details').text(data.client_tin);
        $('#client_address_details').text(data.client_address);
        $('#client_company_details').text(data.client_business_name);
        $('#client_term_details').val(data.client_term_name).change();
        $('#client_date_details').val(data.si_date);

        // Populate freight cost
        $('#item_freight_details').val(data.freight_cost);

        $('#si_id').attr('data-si-id', data.id);

        // Clear and repopulate item table data
        item_table_data = [];
        data.items.forEach(function(item) {
            item_table_data.push({
                unique_id: item.si_unique_id,
                id: item.si_item_id,
                product_id: item.product_id,
                item_code: item.si_item_code,
                item_price: item.si_item_price,
                item_qty: item.si_item_qty,
                item_discount: item.discounts.length > 0 ? item.discounts : [{ label: '', discount: '' }], // Insert blank discount if no value
                item_vatable_sales: item.si_item_vatable_sales,
                item_vat: item.si_item_vat,
                item_vat_check: item.si_item_vat_check === '1' // Convert to boolean
            });
        });
        item_list_table();
        compute_vatables();
    }

    function deepEqual(obj1, obj2) {
        if (obj1 === obj2) return true;

        if (typeof obj1 !== 'object' || obj1 === null || typeof obj2 !== 'object' || obj2 === null) {
            return false;
        }

        let keys1 = Object.keys(obj1);
        let keys2 = Object.keys(obj2);

        if (keys1.length !== keys2.length) return false;

        for (let key of keys1) {
            if (!keys2.includes(key) || !deepEqual(obj1[key], obj2[key])) {
                return false;
            }
        }

        return true;
    }

    function update_sales_invoice(type) {
        var summaryData = {
            totalAmount: $('#summary_total_amount').attr('data-total-amount'),
            vatableSales: $('#summary_vatable_sales').attr('data-vatable-sales'),
            vatAmount: $('#summary_vat_amount').attr('data-vat-amount'),
            totalAmountDue: $('#summary_total_amount_due').attr('data-total-amount-due'),
            vatExemptSales: $('#summary_vat_exempt_sales').attr('data-vat-exempt-sales'),
            zeroRated: '0',
            freightCost: $('#item_freight_details').val(),
            si_status: type
        };

        var customerDetail = {
            terms: $('#client_term_details').val(),
            date: $('#client_date_details').val()
        }

        var si_id = $('#si_id').attr('data-si-id');

        var invoiceData = {
            summary: summaryData,
            customer: customerDetail,
            items: item_table_data,
            si_id: si_id,
            archive_items: to_archive_items
        };

        // Validate data
        var missingFields = [];
        if (!summaryData.totalAmount) missingFields.push('Total Amount');
        if (!summaryData.vatableSales) missingFields.push('VATable Sales');
        if (!summaryData.vatAmount) missingFields.push('VAT Amount');
        if (!summaryData.totalAmountDue) missingFields.push('Total Amount Due');
        if (!summaryData.vatExemptSales) missingFields.push('VAT Exempt Sales');
        if (!customerDetail.terms) missingFields.push('Customer Terms');
        if (item_table_data.length === 0) missingFields.push('Items');

        // New validation for discount labels
        item_table_data.forEach(function(item) {
            item.item_discount.forEach(function(discount) {
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
            url: '<?= base_url('sales_invoice/update_draft') ?>',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(invoiceData),
            success: function(response) {
                alert('Draft updated successfully');
                clearTableAndSummary();
                get_products_clients_si();
                $('.clients_details_container').show();
                $('.clients_details_name_container').hide();
                $('#update_draft_btn').hide(); // Hide the update draft button
                $('#cancel_update_draft_btn').hide(); 
                $('#draft_btn').show(); // Show the draft button
                $('#print_btn').show(); 
                makeCustomerDetailsEditable(); // Make customer details editable again
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.error);
                } else {
                    alert('Failed to update draft');
                }
            }
        });
    }

    function cancel_update_sales_invoice() {
        clearTableAndSummary();
        get_products_clients_si();
        $('.clients_details_container').show();
        $('.clients_details_name_container').hide();
        $('#update_draft_btn').hide(); // Hide the update draft button
        $('#cancel_update_draft_btn').hide(); 
        $('#draft_btn').show(); // Show the draft button
        $('#print_btn').show(); 
        makeCustomerDetailsEditable(); // Make customer details editable again
    }

    function print_si(id) {
        $.ajax({
            url: '<?= base_url('sales_invoice/print_si') ?>',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(id),
            success: function(response) {
                var data = JSON.parse(response);
                if(data.status === 'success') {
                    window.open("/sales_invoice_view/"+id, "_blank");
                    get_products_clients_si();
                }
                else {
                    alert('Failed to print sales invoice');
                }
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.error);
                } else {
                    alert('Failed to print sales invoice');
                }
            }
        });
        
    }

</script>

<?= $this->endSection() ?>