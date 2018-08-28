adminlte gii 模板
================
yii2 gii adminlte

安装
-------

```
composer require --prefer-dist kaykay012/gii 
```

or 在根目录的`composer.json`中添加

```
"kaykay012/gii": "*"

```

然后执行

```
composer update
```

配置
-----

配置修改

在文件 `@app\config\main-local.php` 修改如下

```php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UXw4ClCu4ddAb_t4gGEnnonz-VQUEbco',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'kaykay012\gii\model\GeneratorCommon',
                'templates' => [
                    'adminlte' => '../../vendor/kaykay012/gii/model/adminlte',
                ]
            ],
            'crud' => [
                'class' => 'kaykay012\gii\crud\Generator',
                'templates' => [
                    'adminlte' => '../../vendor/kaykay012/gii/crud/adminlte',
                ]
            ],
        ]
    ];
}

return $config;
```