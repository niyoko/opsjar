<?php

namespace console\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class Command extends Component
{
    private const ROUTE_CONFIG_COMMON = __DIR__ . '/../../common';
    private const ROUTE_CONFIG_CONSOLE =  __DIR__ . '/../config';
    public static function execute($action, $params)
    {
        $oldApp = \Yii::$app;
        $newApp = static::getNewApp(static::getConfig());
        ob_start();
        $result = $newApp->runAction($action, $params);
        $out = ob_get_contents();
        ob_end_clean();
        \Yii::$app = $oldApp;
        return [$result, $out];
    }

    private static function getConfig()
    {
        $config = ArrayHelper::merge(
            require static::ROUTE_CONFIG_COMMON . '/config/main.php',
            require static::ROUTE_CONFIG_COMMON . '/config/main-local.php',
            require static::ROUTE_CONFIG_CONSOLE . '/main.php',
            require static::ROUTE_CONFIG_CONSOLE . '/main-local.php'
        );
        $config['components']['db'] = \Yii::$app->db;
        return $config;
    }

    private static function getNewApp($config)
    {
        return new \yii\console\Application($config);
    }
}
