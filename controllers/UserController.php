<?php

namespace app\controllers;

use app\models\Access;
use Yii;
use app\models\User;
use app\models\Note;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 * @mixin TimestampBehavior
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTest()
    {

        //create model user

        //$model = new User();
        //$model->username = "IvanRax";
        //$model->name = "Ivan";
        //$model->surname = "Rax";
        //$model->password_hash = "3453453434";
        //$model->save();

        // create models note

        /*
        $models = [
            ['text' => 'Record5', 'creator_id' => 1],
            ['text' => 'Record6', 'creator_id' => 1],
            ['text' => 'Record7', 'creator_id' => 1]
        ];
        for ($i = 0; $i < 3; $i++)
        {
            $user = User::findOne(1);
            $model = new Note();
            $model->text = $models[$i]['text'];
            $model->creator_id = $models[$i]['creator_id'];
            $model->link(Note::RELATION_CREATOR, $user);
            //$model->save(); сохранение есть в link
        }
        */

        // чтение записей из таблицы user со связанными данными note
        //$model = User::find()->with('notes')->all(); // без JOIN
        //$model = User::find()->joinWith('notes')->all(); // JOIN

        //связывание User и Note через релейшен accesses
        //$model = User::findOne(1); //выбираем пользователя с id = 1
        // _end($model->getAccessednotes()->all()); //выбираем из таблицы access note_id заметок связанных с этим пользователем.

        //Добавление связи между записями в User и Note
        $user = User::findOne(3);
        $note = new Note();
        $note->text = "newRecord1";
        $note->creator_id = 2;
        $note->save();
        _log($user->link('accessedNotes',$note));
        //_end($user->getAccessednotes()->all());

        //Lesson6
        //
        //1. Подключить TimestampBehavior для классов User и Note
        //добавлены перекрывающие методы behaviors() в классы Note и User
        //$note = new Note();
        //$note -> text = 'Record10';
        //$user = User::findOne(3);
        //$note -> link(Note::RELATION_CREATOR, $user);

        //_end($note);
        //добавилось значение created_at в таблицу note

        //$user = new User();
        //$user->username = "JackRat";
        //$user->name = "Jack";
        //$user->surname = "Rat";
        //$user->password_hash = "6456456456";
        //$user->save();
        //добавилось значение created_at в таблицу user

        //изменение записи
        //$note = Note::findOne(4);
        //$note -> text = 'Record100';
        //$user = User::findOne($note->creator_id);
        //$note -> link(Note::RELATION_CREATOR, $user);
        //поле created_at не изменилось
        //_end($note);

        return $this->redirect(['index']);
    }
}
