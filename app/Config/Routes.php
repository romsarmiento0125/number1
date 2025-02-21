<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/sales_invoice_view/(:num)', 'Home::si_receipt/$1');

$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->post('/login/logout', 'Login::logout');

$routes->get('/dashboard', 'DashboardController::index');

$routes->get('/sales_invoice', 'SalesInvoice::index');
$routes->post('/sales_invoice/get_products_clients_si', 'SalesInvoice::get_products_clients_si');
$routes->post('/sales_invoice/save_draft', 'SalesInvoice::save_draft');
$routes->post('/sales_invoice/get_sales_invoice_by_id', 'SalesInvoice::get_sales_invoice_by_id');
$routes->post('/sales_invoice/update_draft', 'SalesInvoice::update_draft');
$routes->post('/sales_invoice/print_si', 'SalesInvoice::print_si');

$routes->get('/delivery_receipt', 'DeliveryReceiptController::index');
$routes->post('/delivery_receipt/get_products_clients_dr', 'DeliveryReceiptController::get_products_clients_dr');
$routes->post('/delivery_receipt/save_draft', 'DeliveryReceiptController::save_draft');
$routes->post('/delivery_receipt/get_delivery_receipt_by_id', 'DeliveryReceiptController::get_delivery_receipt_by_id');
$routes->post('/delivery_receipt/update_draft', 'DeliveryReceiptController::update_draft');
$routes->post('/delivery_receipt/print_dr', 'DeliveryReceiptController::print_dr');

$routes->get('/products', 'Products::index');
$routes->post('/products/save_product', 'Products::save_product');
$routes->post('/products/get_table_products', 'Products::get_table_products');
$routes->post('/products/edit_product', 'Products::edit_product');

$routes->get('/clients', 'Clients::index');
$routes->post('/clients/save_client', 'Clients::save_client');
$routes->post('/clients/get_table_clients', 'Clients::get_table_clients');
$routes->post('/clients/edit_client', 'Clients::edit_client');



