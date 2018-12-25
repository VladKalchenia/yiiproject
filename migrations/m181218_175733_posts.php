<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181218_175733_posts
 */
class m181218_175733_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=INNODB';
        }
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK, // id - autoincrement with primary key
            'username' => $this->string(32)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1), // 1 - not confirmed
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);

        $this->createTable('{{%posts}}', [
            'id' => Schema::TYPE_PK,
            'title' => $this->text()->notNull(), //Schema::TYPE_TEXT.' NOT NULL'
            'body' => $this->text()->notNull(),
            'image_id' => $this->integer(11),
            'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%posts}}');
//        echo "m181211_165857_posts cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181218_175733_posts cannot be reverted.\n";

        return false;
    }
    */
}
