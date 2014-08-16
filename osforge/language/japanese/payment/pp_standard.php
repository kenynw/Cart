<?php
// Heading
$_['heading_title']					 = 'PayPal Payments Standard';

// Text
$_['text_payment']					 = '支払設定';
$_['text_success']					 = '成功: PayPalを更新しました!';
$_['text_pp_standard']				 = '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW\');"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']			 = 'Authorization';
$_['text_sale']						 = 'Sale';

$_['text_title']    = 'PayPal';
$_['text_reason'] 	= '理由';
$_['text_testmode']	= 'Warning: Sandbox Modeモードです。口座に金額は振り込まれません。';
$_['text_total']	= '送料, 手数料, 割引 & 税金';

// Entry
$_['entry_email']					 = 'メールアドレス:<br /><span class="help">ペイパルのアカウントで登録しているメールアドレスです。</span>';
$_['entry_test']					 = 'Sandbox モード（テストモード）:';
$_['entry_transaction']				 = 'トランザクション（承認と回収）:';
$_['entry_debug']					 = 'デバッグモード:<br/><span class="help">システムログに情報を記録します。</span>';
$_['entry_total']                    = '利用可能な合計金額:<br /><span class="help">この支払方法を利用するには、合計金額がこの額に達している必要があります。</span>';
$_['entry_canceled_reversal_status'] = '取引ステータス(Canceled Reversal):<br /><span class="help">支払い取り消しがキャンセルされたとき。例えば、顧客との異議に勝ち、取り消された取引の金額が返還された場合です。</span>';
$_['entry_completed_status']         = '取引ステータス(Completed):<br /><span class="help">支払いが正常に完了したとき</span>';
$_['entry_denied_status']			 = '取引ステータス(Denied):<br /><span class="help">支払が拒否されたとき</span>';
$_['entry_expired_status']			 = '取引ステータス(Expired):<br /><span class="help">承認が期限切れのため回収できないとき</span>';
$_['entry_failed_status']			 = '取引ステータス(Failed):<br /><span class="help">支払いが失敗したとき</span>';
$_['entry_pending_status']			 = '取引ステータス(Pending):<br /><span class="help">受取人が口座へクレジットカードを登録していないため、送金が完了していないとき</span>';
$_['entry_processed_status']		 = '取引ステータス(Processed):<br /><span class="help">支払いが受諾されたとき</span>';
$_['entry_refunded_status']			 = '取引ステータス(Refunded):<br /><span class="help">払い戻しのとき</span>';
$_['entry_reversed_status']			 = '取引ステータス(Reversed):<br /><span class="help">これは、支払いがチャージバックまたは他のタイプでも返金されたこと意味します。金額は顧客に返されました。反転の理由は、reason_code変数によって与えられます。</span>';
$_['entry_voided_status']		     = '取引ステータス(Voided):<br /><span class="help">承認が無効になったとき</span>';
$_['entry_geo_zone']				 = '適用する地域:';
$_['entry_status']					 = 'ステータス:';
$_['entry_sort_order']				 = '表示順:';

// Error
$_['error_permission']				 = '警告: PayPalを更新する権限がありません!';
$_['error_email']					 = 'メールアドレスは必須です!';
?>