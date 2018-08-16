<?php

namespace semsty\crontab\db\migrations;

use semsty\crontab\Schedule;
use yii\db\Migration;

class m000000_000001_schedule extends Migration
{
    public function up()
    {
        $this->createTable('schedule', [
            'id' => $this->primaryKey(),
            'time' => $this->string(),
            'command' => $this->string(),
            'is_active' => $this->boolean(),
            'comment' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $model = new Schedule([
            'comment' => 'polling',
            'time' => '* * * * *',
            'command' => '/app/yii schedule/pull'
        ]);
        $model->activate();
    }

    public function down()
    {
        $this->dropTable('schedule');
    }
}
