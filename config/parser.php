<?php

return [

    'citrus' => [
        'mainUrl' => 'https://citrus.ua',
        'categories' => [
            'https://www.citrus.ua/smartfony/brand-samsung/',
            'https://www.citrus.ua/smartfony/brand-meizu/',
            'https://www.citrus.ua/smartfony/brand-apple/'
        ],
        'countParse' => 5, //количество элементов для парсинга с категории
        'settings' => [
            'productCategoryClassHref' => '.product-card__name a',
            'productTitle' => '.product__title',
            'productCode' => '.code',
            'productPrice' => '.buy-block__base .normal .price',
        ]
    ],
];
