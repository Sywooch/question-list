<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_084147_questionlist extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%questionlist_answers}}',[
            'id' => $this->primaryKey(),
            'question_text' => $this->string(1000)->notNull(),
            'question_type' => $this->string(25)->notNull(),
            'question_id' => $this->integer(11)->notNull(),
            'profile_id' => $this->integer(25)->notNull(),
            'question_list_id' => $this->integer(11)->notNull(),
            'answer_date' => $this->date()->defaultValue(NULL),
            'answer' => $this->string(1000)->notNull(),
            'answer_list_id' => $this->integer(11)->notNull(),
            'answer_comment' => $this->string(1000),
            'scores' => $this->integer(11)->defaultValue(null),
        ]);

        $this->createTable('{{%questionlist_answers_variants}}',[
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(11)->notNull(),
            'answer' => $this->string(255)->notNull(),
            'scores' => $this->integer()->defaultValue(null),
        ]);

        $this->createTable('{{%questionlist_answer_list}}',[
            'id' => $this->primaryKey(),
            'question_list_id' => $this->integer(11)->notNull(),
            'date_from' => $this->date()->notNull(),
            'date_to' => $this->date()->notNull(),
            'date' => $this->date(),
            'status' => $this->string(10)->notNull(),
            'do_id' => $this->integer(11)->notNull(),
            'list_name' => $this->string(255)->notNull(),
            'scores' => $this->integer()->defaultValue(null),
            'comment' => $this->text(),
            'author' => $this->string(50)->defaultValue(null),
        ]);

        $this->createTable('{{%questionlist_office}}',[
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
        $this->insert('{{%questionlist_office}}',[
            'region_id' => 1,
            'name' => 'Офис 1',
        ]);
        $this->insert('{{%questionlist_office}}',[
            'region_id' => 1,
            'name' => 'Офис 2',
        ]);
        $this->insert('{{%questionlist_office}}',[
            'region_id' => 2,
            'name' => 'Офис 3',
        ]);

        $this->createTable('{{%questionlist_region}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
        ]);

        $this->insert('{{%questionlist_region}}',[
            'name' => 'Регион 1',
        ]);
        $this->insert('{{%questionlist_region}}',[
            'name' => 'Регион 2',
        ]);

        $this->createTable('{{%questionlist_question}}',[
            'id' => $this->primaryKey(),
            'type' => $this->string(10)->notNull(),
            'quest_text' => $this->string(1000)->notNull(),
            'answer' => $this->string(1000)->notNull(),
        ]);

        $this->createTable('{{%questionlist_questions_qlists}}',[
            'id' => $this->primaryKey(),
            'list_id' => $this->integer(11)->notNull(),
            'question_id' => $this->integer(11)->notNull(),
        ]);

        $this->createTable('{{%questionlist_question_list}}',[
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
        ]);

        $this->createTable('{{%questionlist_users_offices}}',[
            'id' => $this->primaryKey(),
            'profile_id' => $this->string(50)->notNull(),
            'office_id' => $this->integer(11),
            'region_id' => $this->integer(11)->notNull(),
            'profile_office_role' => $this->string(50)->notNull(),
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'empl',
            'office_id' => 1,
            'region_id' => 1,
            'profile_office_role' => 'employe',
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'ql_manager_1',
            'office_id' => 1,
            'region_id' => 1,
            'profile_office_role' => 'manager',
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'ql_manager_2',
            'office_id' => 3,
            'region_id' => 2,
            'profile_office_role' => 'manager',
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'comdir1',
            'profile_office_role' => 'commercial_director',
            'region_id' => 1,
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'comdir2',
            'profile_office_role' => 'commercial_director',
            'region_id' => 2,
        ]);

        $this->insert('{{%questionlist_users_offices}}',[
            'profile_id' => 'admin',
            'region_id' => 0,
            'profile_office_role' => 'admin',
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%questionlist_answers}}');
        $this->dropTable('{{%questionlist_answers_variants}}');
        $this->dropTable('{{%questionlist_answer_list}}');
        $this->dropTable('{{%questionlist_question}}');
        $this->dropTable('{{%questionlist_questions_qlists}}');
        $this->dropTable('{{%questionlist_question_list}}');
        $this->dropTable('{{%questionlist_users_offices}}');
        $this->dropTable('{{%questionlist_region}}');
        $this->dropTable('{{%questionlist_office}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
