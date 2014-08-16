<?php
// Heading
$_['heading_title']          = '国設定';

// Text
$_['text_success']           = '成功: 国設定を更新しました!';

// Column
$_['column_name']            = '国名';
$_['column_iso_code_2']      = 'ISO コード (2)';
$_['column_iso_code_3']      = 'ISO コード (3)';
$_['column_action']          = '処理';

// Entry
$_['entry_name']             = '国名:';
$_['entry_iso_code_2']       = 'ISO コード (2):';
$_['entry_iso_code_3']       = 'ISO コード (3):';
$_['entry_address_format']   = '住所の形式:<br /><span class="help">
氏名（姓） = {firstname}<br />
氏名（名） = {lastname}<br />
会社名 = {company}<br />
住所 1 = {address_1}<br />
住所 2 = {address_2}<br />
市区町村 = {city}<br />
郵便番号 = {postcode}<br />
都道府県 = {zone}<br />
都道府県コード = {zone_code}<br />
国名 = {country}</span>';
$_['entry_postcode_required'] = '郵便番号を必須項目にする:';
$_['entry_status']            = 'ステータス:';

// Error
$_['error_permission']       = '警告: 国設定を更新する権限がありません!';
$_['error_name']             = '国名は3文字以上128文字以下でなければなりません!';
$_['error_default']          = '警告: この国は、現在デフォルトのストアに割り振られているために削除できません!';
$_['error_store']            = '警告: この国は、現在 %s 個のストアに割り振られているために削除できません!';
$_['error_address']          = '警告: この国は、現在 %s 個のアドレス帳に割り振られているために削除できません!';
$_['error_zone']             = '警告: この国は、現在 %s 個の都道府県に割り振られているために削除できません!';
$_['error_zone_to_geo_zone'] = '警告: この国は、現在 %s 個のジオゾーンに割り振られているために削除できません!';
?>