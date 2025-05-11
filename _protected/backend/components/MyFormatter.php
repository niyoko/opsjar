<?php

/**
 * Created by PhpStorm.
 * User: cethol
 * Date: 12/12/2017
 * Time: 9:18 PM
 */

namespace backend\components;

use common\models\OrderDetail;
use DateInterval;
use DateTime;
use yii\i18n\Formatter;

class MyFormatter extends Formatter
{
    public const DATETIME_STRING_FORMAT = 'Y-m-d H:i:s';
    public const DATE_STRING_FORMAT = 'Y-m-d';
    public const DATE_TIME_APPS_FORMAT = 'Y-m-d\TH:i:s\Z';
    public const DATE_NULL = '0000-00-00';

    public function asCurrency($value, $currency = null, $options = [], $textOptions = [])
    {
        $parent = parent::asCurrency($value, $currency, $options, $textOptions);
        $parent = str_replace("\xc2\xa0", ' ', $parent);
        if (strpos($parent, 'Rp') === 0) {
            return 'Rp' . trim(substr($parent, 2));
        }
        return $parent;
    }

    public static function normalizePhoneNumber($value)
    {
        $id_code = '+62';
        $phone = ltrim($value, "0");
        if (substr($phone, 0, 3) != $id_code) {
            $phone = $id_code . $phone;
        }
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        return $phone;
    }
    public function asElapseTime($value)
    {
        $original_date = \Yii::$app->formatter->asDateTime($value);
        return '<span data-toggle="tooltip" title="' . $original_date . '">' . $this->naturalTime($value) . '</span>';
    }

    public function asActualDate($value)
    {
        if ($value != null) {
            return date('d F Y', strtotime($value));
        } else {
            return '-';
        }
    }

    public function asActualDatetime($value)
    {
        if ($value != null) {
            return date('d F Y', strtotime($value)) . ' ' . date('H:i', strtotime($value));
        } else {
            return '-';
        }
    }

    public function asActualTime($value)
    {
        if ($value != null) {
            return date('H:i', strtotime($value));
        } else {
            return '-';
        }
    }

    public static function getTodayDate()
    {
        $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
        $today = new \DateTime('now', $timezone);
        $day = $today->format('d M Y');
        return $day;
    }

    public static function getTime()
    {
        $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
        $today = new \DateTime('now', $timezone);
        $day = $today->format('H:i');
        return $day;
    }

    public static function getDay()
    {
        $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
        $today = new \DateTime('now', $timezone);
        $day = $today->format('l');
        switch ($day) {
            case 'Sunday':
                return 'Minggu';
                break;

            case 'Monday':
                return 'Senin';
                break;

            case 'Tuesday':
                return 'Selasa';
                break;

            case 'Wednesday':
                return 'Rabu';
                break;

            case 'Thursday':
                return 'Kamis';
                break;

            case 'Friday':
                return 'Jumat';
                break;

            case 'Saturday':
                return 'Sabtu';
                break;
        }
    }

    public static function getDayByDate($day = null)
    {

        if ($day == null) {
            $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
            $today = new \DateTime('now', $timezone);
            $day = $today->format('l');
        } else {
            // $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
            $today = DateTime::createFromFormat('Y-m-d H:i:s', $day);
            $day = $today->format('l');
        }



        switch ($day) {
            case 'Sunday':
                return 'Minggu';
                break;

            case 'Monday':
                return 'Senin';
                break;

            case 'Tuesday':
                return 'Selasa';
                break;

            case 'Wednesday':
                return 'Rabu';
                break;

            case 'Thursday':
                return 'Kamis';
                break;

            case 'Friday':
                return 'Jumat';
                break;

            case 'Saturday':
                return 'Sabtu';
                break;
        }
    }

    /* public function asTime($value, $format = null)
    {
        if($format===null){
            $format = 'H:i';
        }
        if($value!=null){
            return date($format,strtotime($value));
        }else{
            return '-';
        }
    } */

    private function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed;
        $minutes    = round($time_elapsed / 60);
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400);
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640);
        $years      = round($time_elapsed / 31207680);

        if ($seconds <= 60) {
            return "just now";
        } elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } elseif ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        } elseif ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } elseif ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } elseif ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        } else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }

    private function naturalTime($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed;
        $minutes    = round($time_elapsed / 60);
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400);
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640);
        $years      = round($time_elapsed / 31207680);

        if ($seconds <= 60) {
            return "baru saja";
        } elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return "satu menit lalu";
            } else {
                return "$minutes menit lalu";
            }
        } elseif ($hours <= 24) {
            if ($hours == 1) {
                return "satu jam lalu";
            } else {
                return "$hours jam lalu";
            }
        } elseif ($days <= 7) {
            if ($days == 1) {
                return "kemarin";
            } else {
                return "$days hari lalu";
            }
        } elseif ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "seminggu lalu";
            } else {
                return "$weeks minggu lalu";
            }
        } elseif ($months <= 12) {
            if ($months == 1) {
                return "sebulan lalu";
            } else {
                return "$months bulan lalu";
            }
        } else {
            if ($years == 1) {
                return "setahun lalu";
            } else {
                return "$years tahun lalu";
            }
        }
    }

    public function asHideMobile($value)
    {
        return str_repeat('*', strlen($value) - 4) . substr($value, '-4');
    }
    public function asHideEmail($value)
    {
        return $this->hideMail($value);
    }

    public function asTerbilang($value)
    {
        $hasil = trim($this->penyebut($value)) . " Rupiah";
        return $hasil;
    }

    private function penyebut($value)
    {
        $value = abs($value);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($value < 12) {
            $temp = " " . $huruf[$value];
        } elseif ($value < 20) {
            $temp = $this->penyebut($value - 10) . " belas";
        } elseif ($value < 100) {
            $temp = $this->penyebut($value / 10) . " puluh" . $this->penyebut($value % 10);
        } elseif ($value < 200) {
            $temp = " seratus" . $this->penyebut($value - 100);
        } elseif ($value < 1000) {
            $temp = $this->penyebut($value / 100) . " ratus" . $this->penyebut($value % 100);
        } elseif ($value < 2000) {
            $temp = " seribu" . $this->penyebut($value - 1000);
        } elseif ($value < 1000000) {
            $temp = $this->penyebut($value / 1000) . " ribu" . $this->penyebut($value % 1000);
        } elseif ($value < 1000000000) {
            $temp = $this->penyebut($value / 1000000) . " juta" . $this->penyebut($value % 1000000);
        } elseif ($value < 1000000000000) {
            $temp = $this->penyebut($value / 1000000000) . " milyar" . $this->penyebut(fmod($value, 1000000000));
        } elseif ($value < 1000000000000000) {
            $temp = $this->penyebut($value / 1000000000000) . " trilyun" . $this->penyebut(fmod($value, 1000000000000));
        }
        return ucwords($temp);
    }

    private function hideMail($value)
    {
        $temp_email = explode('@', $value);
        $char_length = strlen($temp_email[0]);
        return str_repeat('*', $char_length - ($char_length / 2)) . substr($temp_email[0], ($char_length / 2 * -1)) . '@' . $temp_email[1];
        //return $temp_email[0];
    }

    public static function getRangeLabel($start, $end)
    {
        $now = new DateTime();
        $yesterday = clone $now;
        $yesterday->sub(self::getInterval(1));
        $last7 = clone $now;
        $last30 = clone $now;
        $thisMonth = clone $now;
        $lastMonth = clone $now;
        $predefinedRange = [
            'Hari ini' => [$now->format('Y-m-d'), $now->format('Y-m-d')],
            'Kemarin' => [$yesterday->format('Y-m-d'), $yesterday->format('Y-m-d')],
            '7 hari terakhir' => [$last7->sub(self::getInterval(6))->format('Y-m-d'), $now->format('Y-m-d')],
            '30 hari terakhir' => [$last30->sub(self::getInterval(29))->format('Y-m-d'), $now->format('Y-m-d')],
            'Bulan ini' => [$thisMonth->format('Y-m-01'), $now->format('Y-m-t')],
            'Bulan kemarin' => [$lastMonth->sub(self::getInterval(1, 'M'))->format('Y-m-01'), $now->sub(self::getInterval(1, 'M'))->format('Y-m-t')],
        ];
        foreach ($predefinedRange as $keyLabel => $range) {
            if ($range[0] == $start && $range[1] == $end) {
                return $keyLabel;
            }
        }

        return null;
    }
    private static function getInterval($value, $interval = 'D')
    {
        return new DateInterval("P{$value}{$interval}");
    }

    /**
     * replace multiple whitespaces with single space
     *
     * @param string $string
     * @return void
     */
    public static function normalizeString($string)
    {
        return preg_replace('!\s+!', ' ', $string);
    }
    /** Currency format with 3 decimal digits */
    public function asCurrencyWithDecimal($value)
    {
        if (!$value || !$value === '' || $value == 0) {
            return '';
        }
        return 'Rp. ' . number_format($value, 3, ",", ".");
    }
    /** Currency format with rate type param */
    public function asCurrencyRateType($value, $rate_type = OrderDetail::UNIT_FTL)
    {
        $allow_decimals  = [OrderDetail::UNIT_KG, OrderDetail::UNIT_CBM];
        if (!in_array($rate_type, $allow_decimals)) {
            return 'Rp. ' . number_format($value, 0, ",", ".");
        } else {
            if (fmod($value, 1) !== 0.00) {
                return 'Rp. ' . number_format($value, 3, ",", ".");
            } else {
                return 'Rp. ' . number_format($value, 0, ",", ".");
            }
        }
    }

    /**
     * convert any date format to number
     */
    public static function getDateNumber($string)
    {
        $string = str_replace('/', '-', $string);
        return date('Y-m-d', strtotime($string));
    }

    /**
     * format string for comparison
     *
     * @return string
     */
    public static function formatString($string)
    {
        $tags = [
            "\n",
            "\r",
            "-",
            " ",
            "<br />",
            "<p>",
            "</p>",
        ];
        $string = str_replace($tags, '', $string);
        $string = strtolower($string);
        return $string;
    }

    public function formatDateDriverApp($date, $trim = false)
    {
        return parent::asDate($date, $trim ? 'd MMM' : 'd MMMM');
    }

    /**
     * convert any date format
     */
    public static function convertDateFormat($date, $originFormat = 'Y-m-d', $resultFormat = 'd/m/Y')
    {
        $dateFormat = DateTime::createFromFormat($originFormat, $date);
        return $dateFormat ? $dateFormat->format($resultFormat) : "";
    }

    /**
     * convert m/d/Y or excel timestamp to Y-m-d
     */
    public static function formatDateFromExcel($cellValue, $format = 'Y-m-d')
    {
        if (!$cellValue) {
            return null;
        }

        if (is_int($cellValue) || is_float($cellValue)) {
            $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($cellValue);
            $timestamp = date($format, $timestamp);
            $dateFormat = DateTime::createFromFormat('Y-d-m', $timestamp);
            $timestamp = $dateFormat->format('Y-m-d');
        } else {
            $timestamp = trim($cellValue);
            $timestamp = str_replace('`', '', $timestamp);
            $timestamp = str_replace("'", '', $timestamp);
            $timestamp = str_replace('/', '-', $timestamp);
        }

        return date($format, strtotime($timestamp));
    }

    public static function getTimeFromSpreadsheet($cellValue, $format = 'H:i')
    {
        $cellValue = str_replace('`', '', $cellValue);
        $cellValue = str_replace("'", '', $cellValue);

        // HH:MM
        $matchDate = "/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/";
        if (preg_match($matchDate, $cellValue)) {
            return ($cellValue);
        }

        // buat handle input selain 0.36458333333333
        if (is_string($cellValue) && strlen($cellValue) < 10) {
            return false;
        }

        $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($cellValue);
        return gmdate($format, $value);
    }

    public static function compareString($string1, $string2)
    {
        return (bool) (static::formatString($string1) == static::formatString($string2));
    }

    /**
     * sample input 11.50
     * sample output 11,5%
     */
    public static function asPercentage($input)
    {
        $output = ($input + 0) . '%';
        $output = str_replace('.', ',', $output);
        return $output;
    }

    /**
     * ubah angka jadi huruf, dimulai index 0
     * misal 0 => A, 1 => B dst
     */
    public static function getLetter(int $key, $limit = 30)
    {
        $letter = 'A';
        for ($i = 0; $i <= $limit; ++$i) {
            if ($key === $i) {
                return $letter;
            }
            ++$letter;
        }

        return false;
    }

    public static function removeFormatNumber($str){
        return str_replace(",",".",str_replace(".","",$str));
    }

    public static function applyNumberFormat($value){
        return number_format($value,0 , ",", ".");
    }

    public static function hasDecimal($val){
        return is_numeric( $val ) && floor( $val ) != $val;
    }
}
