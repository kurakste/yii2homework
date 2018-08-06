<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\objects\CalendarHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Календарь на декабрь)))';
?>
<div class="user-index">

    <h4><?= Html::encode($this->title) ?></h4>

<?php echo CalendarHelper::rendercalendar('12', '2018', $eventsByDay); ?>
</div>

