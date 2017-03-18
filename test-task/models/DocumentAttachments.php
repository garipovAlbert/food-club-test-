<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%document_attachment}}".
 *
 * @property integer $document_id
 * @property string $name
 * @property integer $title
 * @property integer $size
 *
 * @property Documents $document
 */
class DocumentAttachments extends \yii\db\ActiveRecord
{

    const FILES_PATH = 'uploads/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'title', 'name', 'title', 'size'], 'required'],
            [['document_id', 'size'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Documents::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => 'Документ',
            'name' => 'Название',
            'title' => 'Оригинальное название файла',
            'size' => 'Размер файла',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Documents::className(), ['id' => 'document_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if (!unlink(Yii::getAlias('@app/web/' . self::FILES_PATH . $this->name))) {
            throw new \Exception("Couldn't delete the file");
        }
    }

}
