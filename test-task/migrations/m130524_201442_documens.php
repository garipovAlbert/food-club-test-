<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_documens extends Migration
{

    public $tableNameDoc = '{{%documents}}';
    public $tableNameAttachment = '{{%document_attachment}}';
    public $attacheFk = 'attachement_doc_fk';

    public function up()
    {
        $this->createTable($this->tableNameDoc, [
            'id' => $this->primaryKey()->comment('id'),
            'title' => $this->char(255)->comment('Название'),
            'description' => $this->text()->comment('Описание'),
        ]);

        $this->createTable($this->tableNameAttachment, [
            'document_id' => $this->integer()->notNull()->comment('Документ'),
            'name' => $this->char(50)->notNull()->comment('Название'),
            'title' => $this->char(255)->notNull()->comment('Оригинальное название файла'),
            'size' => $this->integer()->notNull()->comment('Размер файла'),
        ]);

        $this->addPrimaryKey('doc_attache_pk', $this->tableNameAttachment, ['document_id', 'name']);
        $this->addForeignKey($this->attacheFk, $this->tableNameAttachment, 'document_id', $this->tableNameDoc, 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey($this->attacheFk, $this->tableNameAttachment);
        $this->dropTable($this->tableNameAttachment);
        $this->dropTable($this->tableNameDoc);
    }

}
