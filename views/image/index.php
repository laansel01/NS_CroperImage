<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImageModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'options'=>['style'=>'width:150px;'],
            'format'=>'raw',
            'attribute'=>'photos',
            'value'=>function($model){
              return Html::tag('div','',[
                'style'=>'width:150px;height:150px;
                          border-top: 10px solid rgba(255, 255, 255, .46);
                          background-image:url('.$model->photoViewer.');
                          background-size: cover;
                          background-position:center center;
                          background-repeat:no-repeat;
                          ']);
            }
        ],
        //'id',
        'name',
        'surname',
        // 'photo',
        // 'photos:ntext',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>
