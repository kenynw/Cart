<?php
//Payment page links
$_['text_amazon_checkout'] = '<a onclick="window.open(\'http://go.amazonservices.com/UKCBASPOpenCart.html\');"><img src="view/image/payment/amazon.png" alt="Amazon Payments" title="Amazon Payments" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_amazon_join'] = '<a href="http://go.amazonservices.com/UKCBASPOpenCart.html" title="Click here to join Amazon Payments">Click here to create your Amazon Payments account</a>';

//Headings

$_['text_home'] = 'Home';
$_['text_payment'] = 'Payment';

$_['heading_title'] = 'Amazon Payments';
$_['heading_address'] = 'Please choose a delivery address';
$_['heading_payment'] = 'Please select a payment method';
$_['heading_confirm'] = 'Order summary';

//Text
$_['text_cron_job_url'] = "Cron Job's URL:";
$_['help_cron_job_url'] = "Set a cron job to call this URL";
$_['text_cron_job_token'] = "Secret Token";
$_['help_cron_job_token'] = "Make this long and hard to guess";
$_['text_access_key'] = 'Access Key:';
$_['text_access_secret'] = 'Secret Key:';
$_['text_merchant_id'] = 'Merchant ID:';
$_['text_marketplace'] = 'Marketplace:';
$_['text_germany'] = 'Germany';
$_['text_uk'] = 'United Kingdom';
$_['text_checkout_mode'] = 'Checkout mode:';
$_['text_geo_zone'] = 'Geo Zone:';
$_['text_status'] = 'Status:';
$_['text_live'] = 'Live';
$_['text_sandbox'] = 'Sandbox';
$_['text_sort_order'] = 'Sort Order:';
$_['text_minimum_total'] = 'Minimum Order Total:';
$_['text_all_geo_zones'] = 'All Geo Zones';
$_['text_status_enabled'] = 'Enabled';
$_['text_status_disabled'] = 'Disabled';
$_['text_default_order_status'] = 'Pending:';
$_['text_ready_order_status'] = 'Ready to be Shipped status:';
$_['text_canceled_order_status'] = 'Canceled order status:';
$_['text_shipped_order_status'] = 'Shipped order status:';
$_['text_last_cron_job_run'] = "Last cron job's run time:";
$_['text_allowed_ips'] = "IPs allowed";
$_['text_add'] = "Add";
$_['text_upload_success'] = 'File was uploaded successfully';
$_['help_adjustment'] = 'Bold fields and at least one "-adj" field are required';
$_['help_allowed_ips'] = "Leave empty if you want everyone to see the checkout button";

$_['text_back'] = 'Back';
$_['text_cart'] = 'Cart';
$_['text_confirm'] = 'Confirm';
$_['text_continue'] = 'Continue';
$_['text_cba'] = 'Amazon Payments';
$_['text_enter_coupon'] = "Enter your coupon code here. If you don't have one, leave it empty.";
$_['text_coupon'] = "Coupon";
$_['text_tax_other'] = "Taxes / Other handling fees";
$_['text_payment_failed'] = 'Your payment has failed. Please contact the shop administrator for assistance or use a different payment option.';
$_['text_payment_success'] = "Your order was successfully placed. Order's details are below";

// Buttons
$_['button_cancel'] = 'Cancel';
$_['button_save'] = 'Save';

// Errors
$_['error_permissions'] = 'You do not have permissions to modify this module';
$_['error_empty_access_secret'] = 'Secret Key is required';
$_['error_empty_access_key'] = 'Access Key is required';
$_['error_empty_merchant_id'] = 'Merchant ID is required';
$_['error_curreny'] = 'Your shop must have %s currency installed and enabled';
$_['error_upload'] = 'Upload failed';

// Checkout button settings
$_['text_button_settings'] = 'Checkout button settings';
$_['text_colour'] = 'Colour:';
$_['text_orange'] = 'Orange';
$_['text_tan'] = 'Tan';
$_['text_white'] = 'White';
$_['text_light'] = 'Light';
$_['text_dark'] = 'Dark';
$_['text_size'] = 'Size:';
$_['text_medium'] = 'Medium';
$_['text_large'] = 'Large';
$_['text_x_large'] = 'Extra large';
$_['text_background'] = 'Background:';
$_['text_download'] = '<a href="%s">Download</a> template file';

// Messages
$_['text_success'] = 'Amazon Payments module has been updated';

// Order Info
$_['text_amazon_details'] = 'Amazon Details';
$_['text_amazon_order_id'] = 'Amazon Order ID:';
$_['text_upload'] = 'Upload';
$_['text_upload_template'] = 'Upload the filled in template by clicking on the button below. Make sure it is saved as a tab-delimited file.';
$_['tab_order_adjustment'] = 'Order Adjustment';

//Table columns
$_['column_submission_id'] = 'Submission ID';
$_['column_status'] = 'Status';
$_['column_text'] = 'Response';
$_['column_amazon_order_item_code'] = 'Amazon Order Product Code';


$_['error_payment_method'] = 'Please select a payment method';
$_['error_shipping'] = 'Please select a shipping method';
$_['error_shipping_address'] = 'Please select a delivery address';
$_['error_shipping_methods'] = 'There was an error retrieving your address from Amazon. Please contact the shop administrator for help';
$_['error_no_shipping_methods'] = 'There are no shipping options to the selected address. Please select a different shipping address';