<?php
/**
 * Created by PhpStorm.
 * User: 804853
 * Date: 25.02.2018
 * Time: 18:22
 */

namespace app\components;

class TestService extends \yii\base\Component
{
    public $var = 'default';
    public function run(){
        return $this->var;
    }
}