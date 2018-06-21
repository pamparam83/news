<?php

use yii\db\Migration;

class m170531_081128_create_news_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',
            'photo' => $this->string(),
            'status' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%news}}');
    }
}
