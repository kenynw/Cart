<?php
// Heading
$_['heading_title']                     = 'PayPal Express Checkout';

// Text 
$_['text_payment']                      = '支払設定';
$_['text_success']                      = '成功: PayPal Express Checkoutを更新しました!';
$_['text_pp_express']                   = '<a href="https://www.paypal.com/uk/mrb/pal=W9TBB5DTD6QJW" taget="_blank"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']                = 'Authorization';
$_['text_sale']                         = 'Sale';
$_['text_clear']                        = '画像をクリア';
$_['text_browse']                       = 'ファイルを開く';
$_['text_image_manager']                = 'イメージマネージャー';
$_['text_ipn']                          = 'IPN url<span class="help">サブスクリプションで必須</span>';

$_['text_title']                    = 'PayPal Express Checkout';
$_['button_continue']               = '続ける';
$_['text_cart']                     = 'ショッピングカート';
$_['text_shipping_updated']         = '配送方法を更新する';
$_['text_trial']                    = '%sを %s %s毎に%s 回お支払い後、';
$_['text_recurring']                = '%sを %s %s';
$_['text_length']                   = '毎に %s 回のお支払い';

// Entry
$_['entry_username']                    = 'API ユーザー名:';
$_['entry_password']                    = 'API パスワード:';
$_['entry_signature']                   = 'API 署名:';
$_['entry_test']                        = 'テスト (Sandbox) モード:';
$_['entry_method']                      = '取引区分:';
$_['entry_geo_zone']                    = '適用する地域:';
$_['entry_status']                      = 'ステータス:';
$_['entry_sort_order']                  = '表示順:';
$_['entry_icon_sort_order']             = 'アイコン表示順:';
$_['entry_debug']                       = 'デバッグ ログを記録する:';
$_['entry_total']                       = '利用可能な合計金額:<br /><span class="help">この支払方法を利用するには、合計金額がこの額に達している必要があります。</span>';
$_['entry_currency']                    = '標準通貨<span class="help">取引の検索にも使用されます。</span>';
$_['entry_profile_cancellation']        = '顧客がプロファイルを取り消すことを許可する';


// Order Status
$_['entry_canceled_reversal_status']    = '取引ステータス(Canceled Reversal):<br /><span class="help">支払い取り消しがキャンセルされたとき。例えば、顧客との異議に勝ち、取り消された取引の金額が返還された場合です。</span>:';
$_['entry_completed_status']            = '取引ステータス(Completed):<br /><span class="help">支払いが正常に完了したとき</span>:';
$_['entry_denied_status']			    = '取引ステータス(Denied):<br /><span class="help">支払が拒否されたとき</span>:';
$_['entry_expired_status']			    = '取引ステータス(Expired):<br /><span class="help">承認が期限切れのため回収できないとき</span>:';
$_['entry_failed_status']			    = '取引ステータス(Failed):<br /><span class="help">支払いが失敗したとき</span>:';
$_['entry_pending_status']			    = '取引ステータス(Pending):<br /><span class="help">受取人が口座へクレジットカードを登録していないため、送金が完了していないとき</span>:';
$_['entry_processed_status']		    = '取引ステータス(Processed):<br /><span class="help">支払いが受諾されたとき</span>:';
$_['entry_refunded_status']			    = '取引ステータス(Refunded):<br /><span class="help">払い戻しのとき</span>:';
$_['entry_reversed_status']			    = '取引ステータス(Reversed):<br /><span class="help">これは、支払いがチャージバックまたは他のタイプでも返金されたこと意味します。金額は顧客に返されました。反転の理由は、reason_code変数によって与えられます。</span>:';
$_['entry_voided_status']		        = '取引ステータス(Voided):<br /><span class="help">承認が無効になったとき</span>:';

// Customise area
$_['entry_display_checkout']            = 'クイックチェックアウトアイコンを表示する:';
$_['entry_allow_notes']                 = '注記を許可する:';
$_['entry_logo']                        = 'ロゴ<span class="help">Max 750px(w) x 90px(h)<br />SSLがセットアップされている場合のみロゴを使用できます。</span>';
$_['entry_border_colour']               = 'ヘッダーボーダー色:<span class="help">HTMLカラーコード6文字</span>';
$_['entry_header_colour']               = 'ヘッダー背景色:<span class="help">HTMLカラーコード6文字</span>';
$_['entry_page_colour']                 = 'ページ背景色:<span class="help">HTMLカラーコード6文字</span>';

// Error
$_['error_permission']                  = '警告: PayPal Express Checkoutを更新する権限がありません!';
$_['error_username']                    = 'API ユーザー名は必須です!';
$_['error_password']                    = 'API パスワードは必須です!';
$_['error_signature']                   = 'API 署名は必須です!';
$_['error_data']                        = 'リクエストデータは失われました';
$_['error_timeout']                     = 'リクエストがタイムアウトしました';

$_['error_heading_title']           = 'エラーが発生しました';
$_['error_too_many_failures']       = 'お支払いに失敗しました';

// Tab headings
$_['tab_general']                       = '一般設定';
$_['tab_api_details']                   = 'API設定';
$_['tab_order_status']                  = '取引ステータス設定';
$_['tab_customise']                     = 'カスタマイズチェックアウト設定';


$_['express_text_title']            = '注文を確認する';
$_['express_button_coupon']         = '追加';
$_['express_button_confirm']        = '確認';
$_['express_button_login']          = 'PayPalに進む';
$_['express_button_shipping']       = '配送方法を更新';
$_['express_entry_coupon']          = 'クーポンコードを入力してください:';