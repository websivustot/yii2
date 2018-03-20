<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\query\NoteQuery;



/* @var $this yii\web\View */
/* @var $model app\models\Note */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text:ntext',
            'creator_id',
            'created_at',
        ],
    ]) ?>

    <h2>This note is shared to:</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'note_id',
            'user_id',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a(\yii\bootstrap\Html::icon('remove-circle'),
                                    ['access/delete', 'id' =>$model->id, 'data-method' => 'post' ]);
                            }

                    ]
            ],

        ],
    ]); ?>


</div>
