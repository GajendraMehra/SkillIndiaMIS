<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'yii\web\JqueryAsset' => [
                'sourcePath' => null,   // do not publish the bundle
                'js' => [
                   ''
                ]


        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ],
]
];
