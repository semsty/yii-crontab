<?php

namespace semsty\crontab;

use yii\db\ActiveRecord;

class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%schedule}}';
    }

    public function rules()
    {
        return [
            [['command', 'time'], 'required'],
            [['command', 'time', 'comment'], 'string'],
            [['is_active'], 'boolean']
        ];
    }

    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }
}