<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property int $image_id
 * @property string $name
 * @property string $surname
 * @property string $file_name
 * @property string $photo_text
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $upload_foler ='uploads';
//    public $name;
//    public $nickname;

    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'file_name', 'photo_text'], 'string', 'max' => 255],
            [['photos'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'image ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'file_name' => 'File Name',
            'photo_text' => 'Photo Text',
            'photos' => 'รูปภาพ',
        ];
    }

    public function upload($model,$attribute){
    $photo  = UploadedFile::getInstance($model, $attribute);
      $path = $this->getUploadPath();
    if ($this->validate() && $photo !== null) {
        $fileName = md5($photo->baseName.time()) . '.' . $photo->extension;
        if($photo->saveAs($path.$fileName)){
          return $fileName;
        }
    }
    return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.$this->upload_foler.'/';
    }

    public function getUploadUrl(){
        return Yii::getAlias('@web').'/'.$this->upload_foler.'/';
    }

    public function getPhotoViewer(){
        return empty($this->photos) ? Yii::getAlias('@web').'/img/none.png' : $this->getUploadUrl().$this->photos;
    }

}
