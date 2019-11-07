# lib-creditcard

Adalah module yang membantu urusan dengan kartu kredit.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-creditcard
```

## Konfigurasi

Module ini tidak menyimpan informasi logo/icon kartu kredit. Tambahkan url ke icon/logo
kartu kredit di konfigurasi aplikasi seperti di bawah:

```php
return [
    'libCreditcard' => [
        'logos' => [
            'PROVIDER_NAME' => [
                'logo' => '...',
                'icon' => '...'
            ]
        ]
    ]
];
```

## Validator

Module ini menambah satu rule validator, yaitu:

### creditcard

```php
// ...
    'creditcard' => true,
    'creditcard' => 'AMERICAN_EXPRESS'
// ...
```

Struktur di atas memastikan nilai yang dimasukan user adalah valid nomor kartu
kredit.

Nilai provider kartu kredit yang dikenali adalah:

1. AMERICAN_EXPRESS
1. DINERS_CLUB
1. DISCOVER
1. JCB
1. LASER
1. MAESTRO
1. MASTERCARD
1. SOLO
1. UNIONPAY
1. VISA
1. INTER_PAYMENT
1. INSTA_PAYMENT
1. DANKORT

## Parser

Module ini juga menambahkan satu library dengan nama `LibCreditcard\Library\CreditCard`
yang memiliki method sebagai berikut:

### validate(string $number): bool

Fungsi untuk memvalidasi nomor kartu kredit.

### info(string $number): ?array

Fungsi untuk mengambil informasi provider, dan logo ( svg ) dari suatu nomor kartu
kredit.