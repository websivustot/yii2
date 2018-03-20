<?php

use yii\db\Migration;

/**
 * Class m180305_102018_test
 */
class m180305_102018_test extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->defaultValue('def')
                ->comment('name')->notNull(),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('test');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180305_102018_test cannot be reverted.\n";

        return false;
    }
    */
}
