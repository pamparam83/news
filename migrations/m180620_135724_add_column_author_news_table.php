<?php

use yii\db\Migration;

/**
 * Class m180620_135724_add_column_author_news_table
 */
class m180620_135724_add_column_author_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}','author',$this->integer());
        $this->createIndex('{{%idx-news-author}}','{{%news}}','author');
        $this->addForeignKey('{{%fk-news-author}}', '{{%news}}','author', '{{%users}}','id','SET NULL');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('{{%fk-news-author}}','{{%news}}');
       $this->dropColumn('{{%news}}','author');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_135724_add_column_author_news_table cannot be reverted.\n";

        return false;
    }
    */
}
