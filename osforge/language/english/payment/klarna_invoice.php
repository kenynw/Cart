<?php
// Heading
$_['heading_title']         = 'Klarna Invoice';

// Text
$_['text_title']          = 'Klarna Invoice';
$_['text_fee']            = 'Klarna Invoice - Pay within 14 days <span id="klarna_invoice_toc_link"></span> (+%s)<script text="javascript\">$.getScript(\'http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js\', function(){ var terms = new Klarna.Terms.Invoice({ el: \'klarna_invoice_toc_link\', eid: \'%s\', country: \'%s\', charge: %s});})</script>';
$_['text_no_fee']         = 'Klarna Invoice - Pay within 14 days <span id="klarna_invoice_toc_link"></span><script text="javascript">$.getScript(\'http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js\', function(){ var terms = new Klarna.Terms.Invoice({ el: \'klarna_invoice_toc_link\', eid: \'%s\', country: \'%s\'});})</script>';
$_['text_additional']     = 'Klarna Invoice requires some additional information before they can proccess your order.';
$_['text_wait']           = 'Please wait!';
$_['text_male']           = 'Male';
$_['text_female']         = 'Female';
$_['text_year']           = 'Year';
$_['text_month']          = 'Month';
$_['text_day']            = 'Day';
$_['text_comment']        = "Klarna's Invoice ID: %s\n%s/%s: %.4f";
$_['text_payment']          = 'Payment';
$_['text_klarna_invoice']   = '<a href="https://merchants.klarna.com/signup?locale=en&partner_id=d5c87110cebc383a826364769047042e777da5e8&utm_campaign=Platform&utm_medium=Partners&utm_source=Opencart" target="_blank"><img src="https://cdn.klarna.com/public/images/global/logos/v1/basic/global_basic_logo_std_blue-black.png?width=60&eid=opencart" alt="Klarna Invoice" title="Klarna Invoice" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_live']             = 'Live';
$_['text_beta']             = 'Beta';
$_['text_sweden']           = 'Sweden';
$_['text_norway']           = 'Norway';
$_['text_finland']          = 'Finland';
$_['text_denmark']          = 'Denmark';
$_['text_germany']          = 'Germany';
$_['text_netherlands']      = 'The Netherlands';
// Entry
$_['entry_gender']         = 'Gender:';
$_['entry_pno']            = 'Personal Number:<br /><span class="help">Please enter your Social Security number here.</span>';
$_['entry_dob']            = 'Date of Birth:';
$_['entry_phone_no']       = 'Phone number:<br /><span class="help">Please enter your phone number.</span>';
$_['entry_street']         = 'Street:<br /><span class="help">Please note that delivery can only take place to the registered address when paying with Klarna.</span>';
$_['entry_house_no']       = 'House No.:<br /><span class="help">Please enter your house number.</span>';
$_['entry_house_ext']      = 'House Ext.:<br /><span class="help">Please submit your house extension here. E.g. A, B, C, Red, Blue ect.</span>';
$_['entry_company']        = 'Company Registration Number:<br /><span class="help">Please enter your Company\'s registration number</span>';
$_['entry_merchant']        = 'Klarna Merchant ID:<br /><span class="help">(estore id) to use for the Klarna service (provided by Klarna).</span>';
$_['entry_secret']          = 'Klarna Secret:<br /><span class="help">Shared secret to use with the Klarna service (provided by Klarna).</span>';
$_['entry_server']          = 'Server:';
$_['entry_total']           = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_pending_status']  = 'Pending Status:';
$_['entry_accepted_status'] = 'Accepted Status:';
$_['entry_geo_zone']        = 'Geo Zone:';
// Error
$_['error_deu_terms']     = 'You must agree to Klarna\'s privacy policy (Datenschutz)';
$_['error_address_match'] = 'Billing and Shipping addresses must match if you want to use Klarna Invoice';
$_['error_network']       = 'Error occurred while connecting to Klarna. Please try again later.';
