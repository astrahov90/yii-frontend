<?php
namespace frontend\models;

use common\models\User;
use yii\web\UploadedFile;

class ProfileForm extends User
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'checkExtensionByMimeType'=>false,],
        ];
    }

    public function upload()
    {
        if ($this->validate())
        {
            $file_path = '/uploads/' . uniqid(rand(), false) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(\Yii::getAlias('@webroot').$file_path);
            $this->iconPath = $file_path;
            return $this->save();
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Изменить аватар',
        ];
    }

    /**
     * @return int
     */
    public function getCreatedAtFormatted()
    {
        return date("d.m.Y", $this->created_at);
    }
}