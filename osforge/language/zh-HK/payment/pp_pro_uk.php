<?php
// Heading
$_['heading_title']      = 'PayPal 網站專業付款（英國）';

// Text 
$_['text_payment']       = '支付管理';
$_['text_pp_pro_uk']     = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal Website Payment Pro (UK)" title="PayPal Website Payment Pro (UK)" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = '授權';
$_['text_sale']          = '銷售';

$_['text_title']           = '信用卡或扣賬卡(有 PayPal妥善處理)';
$_['text_credit_card']     = '信用卡資料';
$_['text_start_date']      = '(若可用)';
$_['text_issue']           = '(僅限 Maestro 和 Solo 卡)';
$_['text_wait']            = '請稍候!';


// Entry
$_['entry_username']     = 'API Username:';
$_['entry_password']     = 'API Password:';
$_['entry_signature']    = 'API Signature:';
$_['entry_vendor']       = '供應商︰<br /><span class="help">登入您的商家ID，您註冊時創建的網站付款專業版帳戶。</span>';
$_['entry_user']         = 'User︰<br /><span class="help">如果您設置了一個或多個其他用戶的帳戶，這個值是處理交易授權用戶ID。但是，如果你還沒有設立帳戶的其他用戶，用戶有相同的值作為賣方。</span>';
$_['entry_password']     = '密碼︰<br /><span class="help">您註冊帳戶時，定義的6至32個字符密碼。</span>';
$_['entry_partner']      = '合作伙伴︰<br /><span class="help">這ID提供給您的授權PayPal名經銷商誰註冊的Payflow SDK的你。如果您購買您的帳戶，直接從PayPal，使用PayPalUK。</span>';
$_['entry_test']         = '測試模式︰<br /><span class="help">使用Live或(sandbox)測試網關服務器處理交易？</span>';
$_['entry_transaction']  = '交易方法︰';
$_['entry_total']        = '訂單合計︰<br /><span class="help">當結帳時訂單合計必須大於此數置才可使用本支付方式。</span>';
$_['entry_order_status'] = '訂單狀態︰';
$_['entry_geo_zone']     = '區域群組︰';

$_['entry_cc_owner']       = '持卡人:';
$_['entry_cc_type']        = '開戶行:';
$_['entry_cc_number']      = '卡號:';
$_['entry_cc_start_date']  = '卡有效期日:';
$_['entry_cc_expire_date'] = '卡到期期日:';
$_['entry_cc_cvv2']        = '信用卡安全碼 (CVV2):';
$_['entry_cc_issue']       = '信用卡發行編號:';

// Error
$_['error_vendor']       = '供應商必填！'; 
$_['error_username']     = '用戶必填！'; 
$_['error_password']     = '密碼必填！'; 
$_['error_partner']      = '伙伴必填！'; 
$_['error_signature']    = 'API Signature Required!'; 

$_['error_required']       = '錯誤: 需要完整提交所有付款信息.';
$_['error_general']        = '錯誤: 交易過程中出現一個常規問題. 請重試.';
$_['error_config']         = '錯誤: 支付模塊配置錯誤. 請驗證登錄憑證.';
$_['error_address']        = '錯誤: 付款城市, 省份, 和郵編匹配錯誤. 請重試.';
$_['error_declined']       = '錯誤: 此次交易已被拒絕. 請重試.';
$_['error_invalid']        = '錯誤: 所提供的信用卡資料無效. 請重試.';
?>