<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\BulkLog;

class UploadDocForm extends Model
{
    public $file_data;

    public function rules()
     {
        return [
            [['file_data'],'required'],
            [
                'file_data', 
                'file',
                'extensions' => 'xlsx,xls',

                'mimeTypes'  => [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ],

                'wrongMimeType' => 'Only files with these extensions are allowed: xlsx,xls',

            ],

        ];
    }

    public function sanitize($filename)
    {
        return str_replace([' ', '"', '\'', '&', '/', '\\', '?', '#', '%', '.'], '-', $filename);
    }
}