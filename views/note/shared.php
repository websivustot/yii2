<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'text:ntext',
            'created_at:datetime',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{deleteAll} {view}',
                    'buttons' => [
                            'deleteAll' => function ($url, $model, $key) {
                                return Html::a(\yii\bootstrap\Html::icon('remove-circle'), ['access/delete-all', 'id' =>$model->id, 'method' => 'post' ]);
                            }
                    ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
