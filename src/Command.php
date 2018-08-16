<?php

namespace semsty\crontab;

use yii\console\Controller;

class Command extends Controller
{
    /**
     * @var $component Component
     */
    public $component;

    public function actionPull()
    {
        $this->component->pullSchedules(
            Schedule::find()->where(['is_active' => true])->orderBy(['id' => SORT_ASC])->all()
        );
        $this->stdout("apply newest schedules\r\n");
    }

    public function actionAdd($name, $time, $command)
    {
        $this->component->add($name, $time, $command);
    }

    public function actionList()
    {
        foreach ($this->component->getSchedules() as $schedule) {
            $this->stdout(
                str_pad($schedule->time, 15)
                . str_pad($schedule->command, 30)
                . '#' . str_pad($schedule->comment, 40)
                . ($schedule->is_active ? '[active]' : '[inactive]') . "\r\n"
            );
        }
    }
}