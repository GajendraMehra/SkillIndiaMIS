<?php namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
* UploadForm is the model behind the upload form.
*/
class UploadForm extends Model
{
/**
 * @var UploadedFile|Null file attribute
 */
public $file;

/**
 * @return array the validation rules.
 */
public function rules()
{
    return [
        [['file'], 'file','skipOnEmpty' => false, 'extensions' => 'png, jpg,pdf,jpeg','maxSize'=>'5242880'],
    ];
}
}
?>