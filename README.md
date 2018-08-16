Yii2 crontab

add to components

```
...
    'schedule' => [
        'class' => \semsty\crontab\Component::class,
        'init' => [
            'example' => [
                '* * * * *',
                'echo Hello >> /tmp/world'
            ]
        ]
    ]
...
```

Usage

```
./yii schedule/add example '* * * * *' 'echo Hello >> /tmp/world'
```

```
Yii::$app->schedule->add('example', '* * * * *', 'echo Hello >> /tmp/world')
```

crontab will update once a minute