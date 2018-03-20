<?php

namespace app\controllers;

use app\models\Access;
use Yii;
use app\models\Note;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Note models.
     * @return mixed
     */
    public function actionMy()
    {
        if (!app()->user->id) {
            return $this->redirect(['site/login']);
        };

        $dataProvider = new ActiveDataProvider([
            'query' => Note::find()->byCreator(app()->user->id),
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShared()
    {
        if (!app()->user->id) {
            return $this->redirect(['site/login']);
        };

        $dataProvider = new ActiveDataProvider([
            'query' => Note::find()->byCreator(app()->user->id)->innerJoinWith(Note::RELATION_ACCESSES),
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAccessed()
    {
        if (!app()->user->id) {
            return $this->redirect(['site/login']);
        };
        $query = Note::find()->innerJoinWith(Note::RELATION_ACCESSES) ->where(['user_id' => app()->user->id]);
        $filterModel = new Note();
        $filterModel -> load(app()->request->get());
        if($filterModel->creator_id){
            $query->andFilterWhere(['creator_id' => $filterModel->creator_id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $users =  User::find()->select('name')->exceptUser(app()->user->id)->indexBy('id')->column();
        return $this->render('accessed', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider,
            'users' => $users,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $note = Note::findOne($id);
        if($note->creator_id == app()->user->id)
        {
            $dataProvider = new ActiveDataProvider([
                'query' => Access::find()->where(['note_id' => $id]),
            ]);

            return $this->render('view', [
                'model' => $this->findModel($id),
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);



    }

    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!app()->user->id) {
            return $this->redirect(['site/login']);
        };

        $model = new Note();
        $model->creator_id = app()->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            app()->session->setFlash('success', 'The note has been created with the number '.$model->id);
            return $this->redirect(['my', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
