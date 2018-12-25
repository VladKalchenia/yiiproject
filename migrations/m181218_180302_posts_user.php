<?php

use yii\db\Migration;

/**
 * Class m181218_180302_posts_user
 */
class m181218_180302_posts_user extends Migration
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
        $this->createTable('{{%post_user}}', [
            'post_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(post_id, user_id)'

        ], $tableOptions);

        $this->createIndex('idx-post_user-post_id',
            '{{%post_user}}',
            'post_id');
        $this->addForeignKey('fk-post_user-post_id',
            '{{%post_user}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE'
        );


        $this->createIndex('idx-post_user-user_id',
            '{{%post_user}}',
            'user_id');
        $this->addForeignKey('fk-post_user-user_id',
            '{{%post_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
//        $this->insert('{{%user}}',[]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-post_user-post_id', '{{%post_user}}');
        $this->dropIndex('idx-post_user-post_id', '{{%post_user}}');
        $this->dropForeignKey('fk-post_user-user_id', '{{%post_user}}');
        $this->dropIndex('idx-post_user-user_id', '{{%post_user}}');
        $this->dropTable('{{%post_user}}');
        echo "m181211_185852_posts_user cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181218_180302_posts_user cannot be reverted.\n";

        return false;
    }
    */
}
