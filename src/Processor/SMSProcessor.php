<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 19/10/2018
 * Time: 18:17
 */

namespace App\Processor;

/**
 * Its dummy class
 * Class SMSProcessor
 *
 * @package App\Processor
 */
class SMSProcessor
{

    /**
     * @param array $results
     */
    public function SMSAboutSlowWebsite(array $results): void
    {
        if ($results['smsAlert']) {
            $this->sendAlertSMS($results['smsAlert']);
        }
    }

    /**
     * @param $number
     *
     * @return bool
     */
    public function sendAlertSMS($number)
    {
        return true;
    }

}