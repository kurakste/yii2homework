<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\CalendarSearch;
use app\objects\CalendarHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * EventController implements the CRUD actions for Event model.
 */
class CalendarController extends Controller
{
    /* public $layout = 'adminlte'; */
    public $layout = 'main';
    public $events = [];
    
    public function actionIndex()
    {
        $eventsByDay = CalendarHelper::getEvents('12', '2018');
            return $this->render('index', 
                ['eventsByDay' => $eventsByDay]);
    }

    private function doLoginIfaGuest()
    {
        $identity = Yii::$app->user->identity;
        if (!$identity) {
            $breadcrumb = Yii::$app->request->url;
            $session = Yii::$app->session;
            $session->set('breadcrumb', $breadcrumb);
            $this->redirect('/site/login');
            return false;
        }
        return true;
    }


}
