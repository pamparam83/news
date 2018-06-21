<?php

use yii\db\Migration;

/**
 * Class m180621_091032_add_column_last_auth_table_users
 */
class m180621_091032_add_column_last_auth_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}','last_auth',$this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}','last_auth');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180621_091032_add_column_last_auth_table_users cannot be reverted.\n";

        return false;
    }
    */
}
