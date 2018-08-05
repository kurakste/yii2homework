<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\CalendarSearch;
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
    
    public function actionIndex()
    {
        if ($this->doLoginIfaGuest()) {
            $params = Yii::$app->request->queryParams; 
            $params['CalendarSearch']['uid'] = Yii::$app->user->identity->id;

            $searchModel = new CalendarSearch();
            $dataProvider = $searchModel->search($params);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        
        }

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
