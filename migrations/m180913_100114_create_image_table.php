<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m180913_100114_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('image', [
            'image_id' => $this->primaryKey(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'file_name' => $this->string(),
            'photo_text' => $this->string(),
            'photos' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('image');
    }
}
