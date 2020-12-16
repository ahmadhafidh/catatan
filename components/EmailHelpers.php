<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\Exception;

class EmailHelpers extends Component
{
    public static function masker($str, $first, $last)
    {
        $len = strlen($str);
        $toShow = $first + $last;
        return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat('*', $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
    }
    
    public static function mask($email)
    {
        $mail_parts = explode('@', $email);
        $domain_parts = explode('.', $mail_parts[1]);
    
        $mail_parts[0] = self::masker($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
        $domain_parts[0] = self::masker($domain_parts[0], 2, 1); // same here
        $mail_parts[1] = implode('.', $domain_parts);
    
        return implode('@', $mail_parts);
    }

    public static function sendForgotPassword($data = [])
    {
        try
        {
            $fromEmail = isset($data['senderEmail']) ? $data['senderEmail'] : Yii::$app->params['senderEmail'];
            $fromAlias = isset($data['senderAlias']) ? $data['senderAlias'] : Yii::$app->params['senderName'];
            $sender = [$fromEmail => $fromAlias];

            $email = Yii::$app->mailer
                ->compose([
                    'html' => 'passwordResetToken-html',
                    'text' => 'passwordResetToken-text'
                ], $data)
                ->setFrom($sender)
                ->setTo($data['email'])
                ->setSubject($data['subject'])
                ->send();

            $response = [
                'code' => 'success',
                'message' => 'Success, send code forgot password'
            ];

            return $email === true ?: false;
        }
        catch (Exception $e)
        {
            $response = [
                'code' => 'Error',
                'message' => 'Failed, '.$e->getMessage().'. Line Error : '.$e->getLine()
            ];

            return false;
        }
    }
}