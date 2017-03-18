<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%documents}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @property DocumentAttachment[] $documentAttachments
 */
class Documents extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%documents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['files'], 'file', 'maxFiles' => 10, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, doc, docx, pdf, zip'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'title' => 'Название',
            'description' => 'Описание',
            'files' => 'Файлы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentAttachments()
    {
        return $this->hasMany(DocumentAttachments::className(), ['document_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->upload();
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {

        $delete = parent::beforeDelete();
        if ($delete) {
            $this->deleteAttachedFiles();
        }
        return $delete;
    }

    /**
     * delete all attachments 
     * @param type $param
     */
    public function deleteAttachedFiles()
    {
        foreach ($this->documentAttachments as $file) {
            $file->delete();
        }
    }

    /**
     * delete attached file
     * @param type $filename
     * @return type
     */
    public function deleteAttachedFile($filename)
    {
        $file = $this->getDocumentAttachments()->where(['name' => $filename])->one();
        return ($file && $file->delete()) ? true : false;
    }

    /**
     * upload files
     * @return boolean
     */
    public function upload()
    {
        if ($this->files) {
            foreach ($this->files as $file) {
                /* @var $file \yii\web\UploadedFile */
                $fileName = md5(date('U') . $file->baseName) . '.' . $file->extension;
                if (!$file->saveAs(DocumentAttachments::FILES_PATH . $fileName)) {
                    continue;
                }
                $attachement = new DocumentAttachments();
                $attachement->document_id = $this->primaryKey;
                $attachement->title = $file->baseName . '.' . $file->extension;
                $attachement->name = $fileName;
                $attachement->size = $file->size;
                !$attachement->validate() ?: $attachement->save();
            }
        }
    }

}
