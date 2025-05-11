<?php

/**
 * Created by PhpStorm.
 * User: pandu
 * Date: 7/9/2018
 * Time: 9:33 AM
 */

namespace common\components;

class Sidebar
{
    public static function active($controller, $action = [], $params = [])
    {
        $active_controller = \Yii::$app->controller->id;
        $active_action = \Yii::$app->controller->action->id;

        if (isset($params['class'])) {
            $class = $params['class'];
        } else {
            $class = 'active';
        }

        if (is_callable($controller)) {
            if (call_user_func($controller, $active_controller, $active_action)) {
                return $class;
            }
        } else {
            if (gettype($action) == 'array' && count($action) > 0) {
                if (self::controllerCheck($controller, $active_controller) && self::actionCheck($action, $active_action)) {
                    return $class;
                }
            } else {
                if (self::controllerCheck($controller, $active_controller)) {
                    return $class;
                }
            }
        }
    }

    private static function controllerCheck($controller, $active_controller)
    {
        if (gettype($controller) == 'array') {
            return in_array($active_controller, $controller);
        } elseif (gettype($controller) == 'string') {
            return $active_controller == $controller;
        } else {
            return false;
        }
    }

    private static function actionCheck($action, $active_action)
    {
        if (gettype($action) == 'array') {
            return in_array($active_action, $action);
        } elseif (gettype($action) == 'string') {
            return $active_action == $action;
        } else {
            return false;
        }
    }

    /**
     * check menu visibility
     *
     * @param array $roles
     * @return void
     */
    public static function visible($roles)
    {
        return in_array(\Yii::$app->user->identity->role, $roles);
    }
}
