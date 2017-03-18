<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <hr/>
    <div class="panel panel-info">
        <div class="panel-heading">
            <b>
                <?= yii::t('app', 'Прикрепленные файлы') ?>
            </b>
        </div>
        <div class="panel-body">
            <br/>
            <?php
            echo Html::tag('div', yii::t('app', 'Нет прикрепленных файлов!'), ['class' => 'no-results-container '.(!$model->documentAttachments ? '' : 'hidden')]);
            $attached = $model->documentAttachments;
            foreach ($attached as $file) {
                $deleteLink = Html::a('', '#', [
                            'class' => 'glyphicon glyphicon-trash text-danger',
                            'onclick' => 'Documents.deleteFile($(this));return false;',
                            'data' => [
                                'confirm-message' => yii::t('app', 'Удалить файл ?'),
                                'f' => $file->name
                            ]
                ]);
                echo Html::tag('span', $file->title . ' ' . $deleteLink, ['class' => 'file-item alert alert-info']);
            }
            ?>
            <hr/>
            <?=
                    $form->field($model, 'files[]')->fileInput(['multiple' => true])
                    ->label(yii::t('app', (($model->isNewRecord || !$attached) ? 'Добавить файлы' : 'Добавить еще файлов')))
                    ->hint('Прикрепить файлы к данному документу');
            ?>
        </div>
    </div>
    <hr/>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
