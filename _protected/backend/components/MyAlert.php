<?php

/**
 * Created by PhpStorm.
 * User: cethol
 * Date: 06/07/17
 * Time: 9:34
 */

namespace backend\components;

use yii\base\Component;

class MyAlert extends Component
{
    public static function success($message, $dismiss = false)
    {
        if (!$dismiss) {
            $message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
        }
        return '<div class="alert alert-success b-l b-l-2x b-l-success rounded">' . $message . '</div>';
    }

    public static function danger($message, $dismiss = false)
    {
        if (!$dismiss) {
            $message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
        }
        return '<div class="alert alert-danger b-l b-l-2x b-l-danger rounded">' . $message . '</div>';
    }

    public static function error($message, $dismiss = false)
    {
        if (!$dismiss) {
            $message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
        }
        return '<div class="alert alert-danger b-l b-l-2x b-l-danger rounded">' . $message . '</div>';
    }

    public static function warning($message, $dismiss = false)
    {
        if (!$dismiss) {
            $message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
        }
        return '<div class="alert alert-warning b-l b-l-2x b-l-warning rounded">' . $message . '</div>';
    }

    public static function info($message, $dismiss = false)
    {
        if (!$dismiss) {
            $message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
        }
        return '<div class="alert alert-info b-l b-l-2x b-l-info rounded">' . $message . '</div>';
    }

    public static function warningLogisly($message)
    {
        return '<div class="alert logisly-warning rounded p-3 d-flex"><div><i class="fas fa-exclamation-circle m-r-10" style="vertical-align: top"></i></div><div>' . $message . '</div></div>';
    }

    public static function dangerLogisly($message)
    {
        return '<div class="alert logisly-danger rounded p-3 d-flex"><div><i class="fas fa-exclamation-circle m-r-10" style="vertical-align: top"></i></div><div>' . $message . '</div></div>';
    }
}
