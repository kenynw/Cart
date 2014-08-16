<?php
// Text
$_['text_title']           = 'Credit or Debit Card (Processed securely by PayPal)';
$_['text_credit_card']     = 'Credit Card Details';
$_['text_start_date']      = '(if available)';
$_['text_issue']           = '(for Maestro and Solo cards only)';
$_['text_wait']            = 'Please wait!';

// Entry
$_['entry_cc_owner']       = 'Card Owner:';
$_['entry_cc_type']        = 'Card Type:';
$_['entry_cc_number']      = 'Card Number:';
$_['entry_cc_start_date']  = 'Card Valid From Date:';
$_['entry_cc_expire_date'] = 'Card Expiry Date:';
$_['entry_cc_cvv2']        = 'Card Security Code (CVV2):';
$_['entry_cc_issue']       = 'Card Issue Number:';

// Error
$_['error_required']       = 'Warning: All payment information fields are required.';
$_['error_general']        = 'Warning: A general problem has occurred with the transaction. Please try again.';
$_['error_config']         = 'Warning: Payment module configuration error. Please verify the login credentials.';
$_['error_address']        = 'Warning: A match of the Payment Address City, State, and Postal Code failed. Please try again.';
$_['error_declined']       = 'Warning: This transaction has been declined. Please try again.';
$_['error_invalid']        = 'Warning: The provided credit card information is invalid. Please try again.';
// Heading
$_['heading_title']      = 'PayPal Payments Pro Payflow Edition';

// Text 
$_['text_payment']       = 'Payment';
$_['text_pp_pro_pf']     = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal Payments Pro Payflow Edition" title="PayPal Payments Pro Payflow Edition" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Authorization';
$_['text_sale']          = 'Sale';

// Entry
$_['entry_vendor']       = 'Vendor:<br /><span class="help">Your merchant login ID that you created when you registered for the Website Payments Pro account.</span>';
$_['entry_user']         = 'User:<br /><span class="help">If you set up one or more additional users on the account, this value is the ID of the user authorised to process transactions. If, however, you have not set up additional users on the account, USER has the same value as VENDOR.</span>';
$_['entry_password']     = 'Password:<br /><span class="help">The 6 to 32 character password that you defined while registering for the account.</span>';
$_['entry_partner']      = 'Partner:<br /><span class="help">The ID provided to you by the authorised PayPal Reseller who registered you for the Payflow SDK. If you purchased your account directly from PayPal, use PayPalUK.</span>';
$_['entry_test']         = 'Test Mode:<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions?</span>';
$_['entry_transaction']  = 'Transaction Method:';
$_['entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';

// Error
$_['error_vendor']       = 'Vendor Required!'; 
$_['error_user']         = 'User Required!'; 
$_['error_password']     = 'Password Required!'; 
$_['error_partner']      = 'Partner Required!'; 