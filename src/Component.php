<?php

namespace semsty\crontab;

use yii\base\BootstrapInterface;
use yii\base\Component as BaseComponent;
use yii\base\InvalidConfigException;
use yii\console\Application as ConsoleApp;
use yii\helpers\Inflector;
use yii2tech\crontab\CronTab;

class Component extends BaseComponent implements BootstrapInterface
{
    public $commandClass = Command::class;
    public $commandOptions = [];

    protected function getCommandId()
    {
        foreach (\Yii::$app->getComponents(false) as $id => $component) {
            if ($component === $this) {
                return Inflector::camel2id($id);
            }
        }
        throw new InvalidConfigException('Crontab must be an application component.');
    }

    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApp) {
            $app->controllerMap[$this->getCommandId()] = [
                    'class' => $this->commandClass,
                    'component' => $this,
                ] + $this->commandOptions;
        }
    }

    public function pull()
    {
        $this->pullSchedules($this->getSchedules(['is_active' => true]));
    }

    public function pullSchedules($schedules, $filepath = '/etc/crontab')
    {
        $jobs = [];
        foreach ($schedules as $schedule) {
            $jobs[] = ['line' => $schedule->time . ' ' . $schedule->command];
        }
        $crontab = new CronTab([
            'jobs' => $jobs,
            'headLines' => [
                'SHELL=/bin/sh',
                'PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin'
            ]
        ]);
        $crontab->saveToFile($filepath);
        exec("crontab $filepath");
    }

    public function add($name, $time, $command)
    {
        $model = Schedule::findOne(['comment' => $name]);
        if (!$model) {
            $model = new Schedule();
        }
        $model->setAttributes([
            'comment' => $name,
            'time' => $time,
            'command' => $command
        ]);
        $model->activate();
    }

    public function getSchedules($condition = [])
    {
        $query = Schedule::find();
        if ($condition) {
            $query->where($condition);
        }
        return $query->all();
    }
}