<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = yii::$app->name;
?>

<div class="text-center well well-lg">
    <?= Html::tag('h1', yii::$app->name); ?>
    <hr/>
    <b class="text-info text-uppercase">
        <?= yii::t('app', 'приложение для управления документами') ?>
    </b>
    <hr/>
    <?=
    Html::a(yii::t('app', 'продолжить'), Url::to(['/documents/index']), [
        'class' => 'btn btn-warning text-uppercase'
    ]);
    ?>
</div>