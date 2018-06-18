<?php

use yii\db\Migration;

/**
 * Class m180226_134214_add_user_admin
 */
class m180226_134214_add_user_admin extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->insert('users',[
            'username' => 'admin',
            'email' => 'admin@admin.ru',
            'password_hash' => '$2y$13$oheBApgxVQmOSfGzHCEeHe3q5jXH8IlyuqWPVj5BlmInagEAqW8Lu',
            'auth_key' => 'wQtZb9h54mFIeWh7gLytLVKPBujytlHC',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%users}}',['username' => ['admin']]);
    }


}
