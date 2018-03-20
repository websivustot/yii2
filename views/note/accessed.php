<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $users */

$this->title = 'Accessed Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            'text:ntext',
            [
                    'attribute' => 'creator_id',
                    'label' => 'Author',
                    'filter' => $users,
                    'value' => function(\app\models\Note $model) {
                        return $model->creator->name;
                    }
            ],
            'created_at:datetime',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
