<?php

namespace semsty\crontab\db\migrations;

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
    }

    public function down()
    {
        $this->dropTable('schedule');
    }
}
