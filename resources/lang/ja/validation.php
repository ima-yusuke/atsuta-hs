<?php

return [
    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、バリデタークラスにより使用されるデフォルトのエラー
    | メッセージです。一部のルールには複数のバージョンがあり、例えば
    | サイズルールなどです。ここでこれらメッセージを自由に変更できます。
    |
    */

    'accepted' => ':attribute を承認してください。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date より後の日付でなければなりません。',
    'after_or_equal' => ':attribute は :date 以降の日付でなければなりません。',
    'alpha' => ':attribute はアルファベットのみ使用できます。',
    'alpha_dash' => ':attribute はアルファベット、数字、ハイフン、アンダースコアのみ使用できます。',
    'alpha_num' => ':attribute はアルファベットと数字のみ使用できます。',
    'array' => ':attribute は配列でなければなりません。',
    'before' => ':attribute は :date より前の日付でなければなりません。',
    'before_or_equal' => ':attribute は :date 以前の日付でなければなりません。',
    'between' => [
        'numeric' => ':attribute は :min から :max の間でなければなりません。',
        'file' => ':attribute は :min KBから :max KBの間でなければなりません。',
        'string' => ':attribute は :min 文字から :max 文字の間でなければなりません。',
        'array' => ':attribute は :min 個から :max 個の間でなければなりません。',
    ],
    'boolean' => ':attribute はtrueまたはfalseでなければなりません。',
    'confirmed' => ':attribute 確認が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date と同じ日付でなければなりません。',
    'date_format' => ':attribute は :format 形式と一致しません。',
    'different' => ':attribute と :other は異なる必要があります。',
    'digits' => ':attribute は :digits 桁でなければなりません。',
    'digits_between' => ':attribute は :min 桁から :max 桁の間でなければなりません。',
    'dimensions' => ':attribute の画像サイズが無効です。',
    'distinct' => ':attribute に重複した値があります。',
    'email' => ':attribute は有効なメールアドレスでなければなりません。',
    'ends_with' => ':attribute は次のいずれかで終了する必要があります: :values。',
    'exists' => '選択された :attribute は無効です。',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute フィールドは値が必要です。',
    'gt' => [
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'file' => ':attribute は :value KBより大きくなければなりません。',
        'string' => ':attribute は :value 文字より大きくなければなりません。',
        'array' => ':attribute には :value 個以上のアイテムが必要です。',
    ],
    'gte' => [
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'file' => ':attribute は :value KB以上でなければなりません。',
        'string' => ':attribute は :value 文字以上でなければなりません。',
        'array' => ':attribute には :value 個以上のアイテムが必要です。',
    ],
    'image' => ':attribute は画像でなければなりません。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute フィールドは :other に存在しません。',
    'integer' => ':attribute は整数でなければなりません。',
    'ip' => ':attribute は有効なIPアドレスでなければなりません。',
    'ipv4' => ':attribute は有効なIPv4アドレスでなければなりません。',
    'ipv6' => ':attribute は有効なIPv6アドレスでなければなりません。',
    'json' => ':attribute は有効なJSON文字列でなければなりません。',
    'lt' => [
        'numeric' => ':attribute は :value より小さくなければなりません。',
        'file' => ':attribute は :value KBより小さくなければなりません。',
        'string' => ':attribute は :value 文字より小さくなければなりません。',
        'array' => ':attribute には :value 個未満のアイテムが必要です。',
    ],
    'lte' => [
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'file' => ':attribute は :value KB以下でなければなりません。',
        'string' => ':attribute は :value 文字以下でなければなりません。',
        'array' => ':attribute には :value 個以下のアイテムしか含まれていません。',
    ],
    'max' => [
        'numeric' => ':attribute は :max 以下でなければなりません。',
        'file' => ':attribute は :max KB以下でなければなりません。',
        'string' => ':attribute は :max 文字以下でなければなりません。',
        'array' => ':attribute には :max 個以下のアイテムしか含まれていません。',
    ],
    'mimes' => ':attribute は :values タイプのファイルでなければなりません。',
    'mimetypes' => ':attribute は :values タイプのファイルでなければなりません。',
    'min' => [
        'numeric' => ':attribute は最低 :min でなければなりません。',
        'file' => ':attribute は最低 :min KBでなければなりません。',
        'string' => ':attribute は最低 :min 文字でなければなりません。',
        'array' => ':attribute には最低 :min 個のアイテムが必要です。',
    ],
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が無効です。',
    'numeric' => ':attribute は数値でなければなりません。',
    'password' => 'パスワードが正しくありません。',
    'present' => ':attribute フィールドが存在する必要があります。',
    'regex' => ':attribute の形式が無効です。',
    'required' => ':attribute は必須です。',
    'required_if' => ':attribute は :other が :value の場合に必須です。',
    'required_unless' => ':attribute は :other が :values にない場合に必須です。',
    'required_with' => ':attribute は :values が存在する場合に必須です。',
    'required_with_all' => ':attribute は :values がすべて存在する場合に必須です。',
    'required_without' => ':attribute は :values が存在しない場合に必須です。',
    'required_without_all' => ':attribute は :values のどれも存在しない場合に必須です。',
    'same' => ':attribute と :other は一致する必要があります。',
    'size' => [
        'numeric' => ':attribute は :size でなければなりません。',
        'file' => ':attribute は :size KBでなければなりません。',
        'string' => ':attribute は :size 文字でなければなりません。',
        'array' => ':attribute は :size 個のアイテムを含まなければなりません。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まる必要があります: :values。',
    'string' => ':attribute は文字列でなければなりません。',
    'timezone' => ':attribute は有効なタイムゾーンでなければなりません。',
    'unique' => ':attribute は既に使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'url' => ':attribute は有効なURLでなければなりません。',
    'uuid' => ':attribute は有効なUUIDでなければなりません。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性
    |--------------------------------------------------------------------------
    |
    | 以下の言語行を使用して、属性プレースホルダーをよりフレンドリーに
    | ユーザーに表示することができます。
    | 例えば、"email" を "メールアドレス" と表示したい場合に役立ちます。
    |
    */
];
