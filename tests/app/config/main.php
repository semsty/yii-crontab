<?php
$config = [
    'id' => 'ws-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'schedule'
    ],
    'components' => [
        'schedule' => [
            'class' => \semsty\crontab\Component::class,
            'init' => [
                'test date' => [
                    '* * * * *',
                    'date >> /tmp/date'
                ]
            ]
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                getenv('POSTGRES_HOST') ?: 'db',
                getenv('POSTGRES_PORT') ?: 5432,
                getenv('POSTGRES_DB') ?: 'app_db'
            ),
            'username' => getenv('POSTGRES_USER') ?: 'app',
            'password' => getenv('POSTGRES_PASSWORD') ?: 'password',
            'charset' => 'utf8',
        ]
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'db' => 'db',
            'migrationNamespaces' => [
                'semsty\crontab\db\migrations',
            ],
        ]
    ],
];

return $config;
