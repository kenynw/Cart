<?php
// Heading
$_['heading_title']      = 'PayPal Payments Pro Payflow Edition';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified PayPal Direct (UK) account details!';
$_['text_pp_pro_pf']     = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal Payments Pro Payflow Edition" title="PayPal Payments Pro Payflow Edition" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Authorization';
$_['text_sale']          = 'Sale';
$_['text_title']           = '信用卡或借记卡(有 PayPal妥善处理)';
$_['text_credit_card']     = '信用卡资料';
$_['text_start_date']      = '(若可用)';
$_['text_issue']           = '(仅限 Maestro 和 Solo 卡)';
$_['text_wait']            = '请稍候!';

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
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';

$_['entry_cc_owner']       = '持卡人:';
$_['entry_cc_type']        = '开户行:';
$_['entry_cc_number']      = '卡号:';
$_['entry_cc_start_date']  = '卡有效期日:';
$_['entry_cc_expire_date'] = '卡到期日期:';
$_['entry_cc_cvv2']        = '信用卡安全码 (CVV2):';
$_['entry_cc_issue']       = '信用卡发行编号:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment PayPal Website Payment Pro (UK)!';
$_['error_vendor']       = 'Vendor Required!'; 
$_['error_user']         = 'User Required!'; 
$_['error_password']     = 'Password Required!'; 
$_['error_partner']      = 'Partner Required!'; 

$_['error_required']       = '错误: 需要完整提交所有付款信息.';
$_['error_general']        = '错误: 交易过程中出现一个常规问题. 请重试.';
$_['error_config']         = '错误: 支付模块配置错误. 请验证登录凭证.';
$_['error_address']        = '错误: 付款城市, 省份, 和邮编匹配错误. 请重试.';
$_['error_declined']       = '错误: 此次交易已被拒绝. 请重试.';
$_['error_invalid']        = '错误: 所提供的信用卡资料无效. 请重试.';
