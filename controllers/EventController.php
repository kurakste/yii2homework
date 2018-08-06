<?php

namespace app\controllers;

use Yii;
use app\models\forms\EventForm;
use app\models\Event;
use app\models\Access;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\objects\ViewModels\EventCreateView;
use app\objects\ViewModels\EventView;
use yii\web\ForbiddenHttpException;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    /* public $layout = 'adminlte'; */
    public $layout = 'main';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' =>true,
                        'roles' =>['@'],
                    ],
                ],
            
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $event = $this->findModel($id);
        $viewModel = new EventView();

        if (!$this->checkAccess($event)) {
            throw new ForbiddenHttpException('У вас нет доступа к текущему событию.');
        }
        return $this->render('view', [
            'model' => $event,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EventForm();
        /* $model->load(Yii::$app->request->post()); */
        /* var_dump($model->save()); */
        /* die; */
        /* $model->uid =10; */
        /* if (Yii::$app->request->post()) { */
        /*     var_dump(Yii::$app->request->post()); */
        /*     die; */
        
        /* } */
        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->validate()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $viewModel = new EventCreateView();
        return $this->render('create', [
            'model' => $model,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if (!$this->checkWriteAccess($model)) {
            throw new ForbiddenHttpException('У вас нет прав редактировать это событие.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        if (!$this->checkTimeAccess($model)) {
        
            throw new ForbiddenHttpException('Нельзя редактировать завершенные события.');
        };
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $viewModel = new EventCreateView();
        return $this->render('update', [
            'model' => $model,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $event = $this->findModel($id);
        if (!$this->checkWriteAccess($event)) {
            throw new ForbiddenHttpException('У вас нет прав редактировать это событие.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function checkAccess(Event $event): bool
    {
        $curentUid = \Yii::$app->user->getId();
        if ($event->uid == $curentUid) {
            return true;
        } elseif (Access::find()->andWhere([
            'eventid' => $event->id,
            'userid' => $curentUid
        ])->count()) {
            return true;
        }
        return false;
    }

    protected function checkWriteAccess(Event $event)
    {
        return $event->uid == \Yii::$app->getUser()->getId();
    }

    protected function checkTimeAccess(EventForm $event) 
    {
        $timeevent = strtotime($event->end_at);
        $today = strtotime(date("Y-m-d H:i:s"));
        $out = $timeevent > $today;

        return $out;
    
    }
}
