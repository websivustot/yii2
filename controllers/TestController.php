<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\Connection;
use yii\db\Query;


class TestController extends Controller
{


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$obj = new TestService(['var' => '777']);
        //return VarDumper::dumpAsString(\Yii::$app->test->run(), 5, true);
        $test = \Yii::$app->test->run();
        return $this->render('index', ['test' => $test]);
    }

    public function actionInsert()
    {
        //_log(\Yii::$app->db->createCommand()->
        //    insert('user', ['username' => 'MikhailOtt', 'name' => 'Mikhail', 'surname' => 'Ott', 'password_hash' => '345795'])->
        //    execute());
        $users = (new Query())->from('user')->column();
        //_end($users[0]);
        for ($i = 0; $i < 3;$i++) {
            $notes[] = ['Record'.$i, $users[$i]];
        }
        _log(\Yii::$app->db->createCommand()->
        batchInsert('note', ['text', 'creator_id'], $notes)->execute());

        return $this->render('index', ['test' => 'insert']);
    }

    public function actionSelect()
    {
        //_end((new Query())->from('user')->where(['id' => 1])->all()); //id=1
        //_end((new Query())->from('user')->where(['>', 'id', 1])->
        //    orderBy(['name' => 'SORT_DESC'])->all()); //id>1 sort by name
        //_end((new Query())->from('user')->count()); //count
        _end((new Query())->from('note')->
        innerJoin('user', 'user.id = creator_id')->all()); //inner join

        return $this->render('index', ['test' => 'insert']);
    }

    public function actionForeign()
    {
        \Yii::$app->db->createCommand()-> addForeignKey('fx_access_user', 'access', ['user_id'], 'user', ['id'])->execute();
        \Yii::$app->db->createCommand()-> addForeignKey('fx_access_note', 'access', ['note_id'], 'note', ['id'])->execute();
        \Yii::$app->db->createCommand()-> addForeignKey('fx_note_user', 'note', ['creator_id'], 'user', ['id'])->execute();

        return $this->render('index', ['test' => 'foreign keys']);
    }


}
