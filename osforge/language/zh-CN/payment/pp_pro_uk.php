<?php
// Heading
$_['heading_title']      = 'PayPal 网站专业付款（英国）';

// Text 
$_['text_payment']       = '支付管理';
$_['text_pp_pro_uk']        = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal Payments Pro (UK)" title="PayPal Payments Pro (UK)" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = '授权';
$_['text_sale']          = '销售';

$_['text_title']           = '信用卡或借记卡(有 PayPal妥善处理)';
$_['text_credit_card']     = '信用卡资料';
$_['text_start_date']      = '(若可用)';
$_['text_issue']           = '(仅限 Maestro 和 Solo 卡)';
$_['text_wait']            = '请稍候!';

// Entry
$_['entry_vendor']       = '供应商：<br /><span class="help">登入您的商家ID，您注册时创建的网站付款专业版帐户。</span>';
$_['entry_username']         = 'API用户名：<br /><span class="help">如果您设置了一个或多个其他用户的帐户，这个值是处理交易授权用户ID。但是，如果你还没有设立帐户的其他用户，用户有相同的值作为卖方。</span>';
$_['entry_password']     = 'API密码：<br /><span class="help">您注册帐户时，定义的6至32个字符密码。</span>';
$_['entry_signature']    = 'API签名：';
$_['entry_partner']      = '合作伙伴：<br /><span class="help">这ID提供给您的授权PayPal名经销商谁注册的Payflow SDK的你。如果您购买您的帐户，直接从PayPal，使用PayPalUK。</span>';
$_['entry_test']         = '测试模式：<br /><span class="help">使用Live或(sandbox)测试网关服务器处理交易？</span>';
$_['entry_transaction']  = '交易方法：';
$_['entry_total']        = '订单合计：<br /><span class="help">当结帐时订单合计必须大于此数置才可使用本支付方式。</span>';
$_['entry_order_status'] = '订单状态：';
$_['entry_geo_zone']     = '区域群组：';

$_['entry_cc_owner']       = '持卡人:';
$_['entry_cc_type']        = '开户行:';
$_['entry_cc_number']      = '卡号:';
$_['entry_cc_start_date']  = '卡有效期日:';
$_['entry_cc_expire_date'] = '卡到期期日:';
$_['entry_cc_cvv2']        = '信用卡安全码 (CVV2):';
$_['entry_cc_issue']       = '信用卡发行编号:';

// Error
$_['error_permission']   = '警告： 您没有权限修改支付宝网站专业付款（英国）！';
$_['error_username']       = 'API用户名必填！'; 
$_['error_user']         = 'API用户必填！'; 
$_['error_password']     = 'API密码必填！'; 
$_['error_signature']    = 'API签名必填！'; 
$_['error_partner']      = 'API伙伴必填！'; 

$_['error_required']       = '错误: 需要完整提交所有付款信息.';
$_['error_general']        = '错误: 交易过程中出现一个常规问题. 请重试.';
$_['error_config']         = '错误: 支付模块配置错误. 请验证登录凭证.';
$_['error_address']        = '错误: 付款城市, 省份, 和邮编匹配错误. 请重试.';
$_['error_declined']       = '错误: 此次交易已被拒绝. 请重试.';
$_['error_invalid']        = '错误: 所提供的信用卡资料无效. 请重试.';
?>