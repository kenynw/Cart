<?php
// Heading
$_['heading_title']      = 'PayPal Express';

// Text 
$_['text_payment']       = '支付管理';
$_['text_pp_express']    = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = '授權';
$_['text_sale']          = '銷售';
$_['text_clear']                        = '清除';
$_['text_browse']                       = 'Browse';
$_['text_image_manager']                = 'Image manager';
$_['text_ipn']                          = 'IPN url<span class="help">Required for subscriptions</span>';

$_['text_title']                    = 'PayPal Express Checkout';
$_['button_continue']               = '繼續';
$_['text_cart']                     = '購物車';
$_['text_shipping_updated']         = '貨運服務更新';
$_['text_trial']                    = '%s every %s %s for %s payments then ';
$_['text_recurring']                = '%s every %s %s';
$_['text_length']                   = ' for %s payments';

// Entry
$_['entry_username']     = 'API 戶名︰';
$_['entry_password']     = 'API 密碼︰';
$_['entry_signature']    = 'API 簽名︰';
$_['entry_test']         = '測試模式︰';
$_['entry_method']       = '交易方法︰';
$_['entry_total']        = '訂單合計︰<br /><span class="help">當結帳時訂單合計必須大於此數置才可使用本支付方式。</span>';
$_['entry_order_status'] = '訂單狀態︰';
$_['entry_geo_zone']     = '區域群組︰';

$_['entry_icon_sort_order']             = 'Icon Sort Order:';
$_['entry_debug']                       = 'Debug logging:';
$_['entry_currency']                    = 'Default currency<span class="help">Used for transaction searches</span>';
$_['entry_profile_cancellation']        = 'Allow customers to cancel profiles';

// Order Status
$_['entry_canceled_reversal_status']    = 'Canceled Reversal Status:';
$_['entry_completed_status']            = 'Completed Status:';
$_['entry_denied_status']			    = 'Denied Status:';
$_['entry_expired_status']			    = 'Expired Status:';
$_['entry_failed_status']			    = 'Failed Status:';
$_['entry_pending_status']			    = 'Pending Status:';
$_['entry_processed_status']		    = 'Processed Status:';
$_['entry_refunded_status']			    = 'Refunded Status:';
$_['entry_reversed_status']			    = 'Reversed Status:';
$_['entry_voided_status']		        = 'Voided Status:';

// Customise area
$_['entry_display_checkout']            = 'Display quick checkout icon:';
$_['entry_allow_notes']                 = 'Allow notes:';
$_['entry_logo']                        = 'Logo<span class="help">Max 750px(w) x 90px(h)<br />You should only use a logo if you have SSL set up.</span>';
$_['entry_border_colour']               = 'Header border colour:<span class="help">6 character HTML colour code</span>';
$_['entry_header_colour']               = 'Header background colour:<span class="help">6 character HTML colour code</span>';
$_['entry_page_colour']                 = 'Page background colour:<span class="help">6 character HTML colour code</span>';

// Error
$_['error_username']     = 'API 戶名必填！'; 
$_['error_password']     = 'API 密碼必填！'; 
$_['error_signature']    = 'API 簽名必填！'; 
$_['error_data']                        = 'Data missing from request';
$_['error_timeout']                     = 'Request timed out';

$_['error_heading_title']           = '有一個錯誤';
$_['error_too_many_failures']       = '您的付款已失敗了太多次';

// Tab headings
$_['tab_general']                       = 'General';
$_['tab_api_details']                   = 'API details';
$_['tab_order_status']                  = 'Order status';
$_['tab_customise']                     = 'Customise checkout';

// Express confirm page
$_['express_text_title']            = '確認訂單';
$_['express_button_coupon']         = '添加';
$_['express_button_confirm']        = '確認';
$_['express_button_login']          = 'Continue to PayPal';
$_['express_button_shipping']       = '更新貨運';
$_['express_entry_coupon']          = '在這里輸入您的優惠券:';
?>