<?php

namespace tests\schedule;

use semsty\crontab\Schedule;
use tests\TestCase;

class Test extends TestCase
{
    public function tearDown()
    {
        unlink('/tmp/test');
        Schedule::deleteAll(['comment' => 'test']);
    }

    public function testNewSchedule()
    {
        $model = new Schedule([
            'comment' => 'test',
            'time' => '* * * * *',
            'command' => 'echo 123 >> /tmp/test'
        ]);
        $model->activate();
        \Yii::$app->schedule->pull();
        sleep(61);
        $content = file_get_contents('/tmp/test');
        assertEquals($content, '123');
    }
}
