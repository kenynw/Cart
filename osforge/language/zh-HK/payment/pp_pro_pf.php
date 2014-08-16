<?php
// Heading
$_['heading_title']      = 'PayPal Payments Pro Payflow Edition';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified PayPal Direct (UK) account details!';
$_['text_pp_pro_pf']     = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal Payments Pro Payflow Edition" title="PayPal Payments Pro Payflow Edition" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Authorization';
$_['text_sale']          = 'Sale';

$_['text_title']           = '信用卡或扣賬卡(有 PayPal妥善處理)';
$_['text_credit_card']     = '信用卡資料';
$_['text_start_date']      = '(若可用)';
$_['text_issue']           = '(僅限 Maestro 和 Solo 卡)';
$_['text_wait']            = '請稍候!';

// Entry
$_['entry_vendor']       = 'Vendor:<br /><span class="help">Your merchant login ID that you created when you registered for the Website Payments Pro account.</span>';
$_['entry_user']         = 'User:<br /><span class="help">If you set up one or more additional users on the account, this value is the ID of the user authorised to process transactions. If, however, you have not set up additional users on the account, USER has the same value as VENDOR.</span>';
$_['entry_password']     = 'Password:<br /><span class="help">The 6 to 32 character password that you defined while registering for the account.</span>';
$_['entry_partner']      = 'Partner:<br /><span class="help">The ID provided to you by the authorised PayPal Reseller who registered you for the Payflow SDK. If you purchased your account directly from PayPal, use PayPalUK.</span>';
$_['entry_test']         = '測試模式︰<br /><span class="help">Use the live or testing (sandbox) gateway server to process transactions?</span>';
$_['entry_transaction']  = '交易方法︰';
$_['entry_total']        = 'Total:<br /><span class="help">結帳前必須達到的訂單金額。</span>';
$_['entry_order_status'] = '訂單狀態:';
$_['entry_geo_zone']     = 'Geo Zone:';


$_['entry_cc_owner']       = '持卡人:';
$_['entry_cc_type']        = '開戶行:';
$_['entry_cc_number']      = '卡號:';
$_['entry_cc_start_date']  = '卡有效期日:';
$_['entry_cc_expire_date'] = '卡到期期日:';
$_['entry_cc_cvv2']        = '信用卡安全碼 (CVV2):';
$_['entry_cc_issue']       = '信用卡發行編號:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment PayPal Website Payment Pro (UK)!';
$_['error_vendor']       = 'Vendor Required!'; 
$_['error_user']         = 'User Required!'; 
$_['error_password']     = 'Password Required!'; 
$_['error_partner']      = 'Partner Required!'; 

$_['error_required']       = '錯誤: 需要完整提交所有付款信息.';
$_['error_general']        = '錯誤: 交易過程中出現一個常規問題. 請重試.';
$_['error_config']         = '錯誤: 支付模塊配置錯誤. 請驗證登錄憑證.';
$_['error_address']        = '錯誤: 付款城市, 省份, 和郵編匹配錯誤. 請重試.';
$_['error_declined']       = '錯誤: 此次交易已被拒絕. 請重試.';
$_['error_invalid']        = '錯誤: 所提供的信用卡資料無效. 請重試.';
?>