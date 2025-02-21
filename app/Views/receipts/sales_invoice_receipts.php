<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>
    .receipt_container {
        background-color: lightgrey;
        height: 1000px;
    }

    .receipt_margin {
        margin-top: 155px;
    }

    #sir_client_name {
        font-size: 16px;
        margin-left: 130px;
        margin-bottom: 0px;
    }

    #sir_date {
        font-size: 16px;
        margin-left: 60px;
    }

    #sir_tin {
        font-size: 16px;
        margin-left: 70px;
    }

    #sir_term {
        font-size: 16px;
        margin-left: 60px;
    }

    #sir_address {
        font-size: 16px;
        margin-left: 130px;
    }

    #sir_business_name {
        font-size: 16px;
        margin-left: 160px;
    }
</style>

<div class="row">
    <div class="col-10 receipt_container d-flex flex-column justify-content-between">
        <div class="receipt_margin">
            <div class="row">
                <div class="col-8">
                    <p id="sir_client_name"></p>
                </div>
                <div class="col-4">
                    <p id="sir_date"></p>
                </div>
                <div class="col-8">
                    <p id="sir_tin"></p>
                </div>
                <div class="col-4">
                    <p id="sir_term"></p>
                </div>
                <div class="col-12">
                    <p id="sir_address"></p>
                </div>
                <div class="col-8">
                    <p id="sir_business_name"></p>
                </div>
                <div class="col-4">

                </div>
            </div>
            <div class="" id="item_lists">
                
            </div>
        </div>


        <div class="">
            <div class="">
                <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-5 d-flex d-flex justify-content-end">
                        <p>Freight:&nbsp;</P>
                        <p id="freight_cost"></p>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-5 d-flex justify-content-end">
                        <p>DISCOUNT</p>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                        <p id="total_amount"></p>
                    </div>
                </div>
            </div>
            <div class="" id="item_discounts">
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-5">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-2">
                        <p id="vat_sales"></p>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-5">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-2">
                        <p id="vat_exempt"></p>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-5">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-2">
                        <p>0</p>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-5">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-2">
                        <p id="vat_amount"></p>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-1">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-5">
    
                    </div>
                    <div class="col-2">
    
                    </div>
                    <div class="col-2">
                        <p id="total_amount_due"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Get the JSON data from the hidden input field
    var data = <?= $result ?>;
    var total_amount = 0;

    $(document).ready(function() {
        console.log(data);
        $("#sir_client_name").text(data.client_name == "" ? "." : data.client_name);
        $("#sir_date").text(data.si_date == "" ? "." : formatDateYearMonthDayDashed(data.si_date));
        $("#sir_tin").text(data.client_tin == "" ? "." : data.client_tin);
        $("#sir_term").text(data.client_term == "" ? "." : ter_convertion(data.client_term));
        $("#sir_address").text(data.client_address == "" ? "." : data.client_address);
        $("#sir_business_name").text(data.client_business_name == "" ? "." : data.client_business_name);
        $("#freight_cost").text(data.freight_cost == "" ? "." : formatPrice(data.freight_cost));
        $("#vat_sales").text(data.vatable_sales == "" ? "." : formatPrice(data.vatable_sales));
        $("#vat_exempt").text(data.vat_exempt_sales == "" ? "." : formatPrice(data.vat_exempt_sales));
        $("#vat_amount").text(data.vat_amount == "" ? "." : formatPrice(data.vat_amount));
        $("#total_amount_due").text(data.total_amount_due == "" ? "." : formatPrice(data.total_amount_due));
        item_lists(data.items);
    });

    function item_lists(data) {
        data.forEach(function(item) {
            total_amount += parseFloat(item.amount);
            var item_row = '<div class="row"><div class="col-1"><p>' + item.si_item_qty + '</p></div>' +
                '<div class="col-2"><p>BAGS</p></div>' +
                '<div class="col-5"><p>' + item.product_name + ' </p></div>' +
                '<div class="col-2"><p>' + formatPrice(item.unit_price) + '</p></div>' +
                '<div class="col-2"><p>' + formatPrice(item.amount) + '</p></div></div>';
            $("#item_lists").append(item_row);
            item_discounts(item.discounts, item.si_item_qty);
        });
        $("#total_amount").text(total_amount == 0 ? "." : formatPrice(total_amount));
    }

    function item_discounts(discounts, qty) {
        discounts.forEach(function(discount) {
            var discount_row = '<div class="row"><div class="col-1"></div><div class="col-2"></div>' +
                '<div class="col-5 d-flex justify-content-end"><p>' + discount.discount + ' x ' + qty + '</p></div>' +
                '<div class="col-2"></div>' +
                '<div class="col-2"><p>' + formatPrice(discount.discount * qty) + '&nbsp;' + discount.label + '</p></div></div>';
            $("#item_discounts").append(discount_row);
        });
    }

    function ter_convertion(client_term) {
        switch (client_term) {
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

    function formatPrice(price) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'PHP'
        }).format(price);
    }

    function formatDateYearMonthDayDashed(dateString) {
        const date = new Date(dateString);
        if (isNaN(date)) {
            return "Invalid Date";
        }

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }
</script>
<?= $this->endSection() ?>