<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cryptocurrency}}`.
 */
class m241010_065716_create_cryptocurrency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cryptocurrency', [
            'id' => $this->primaryKey(),
            'symbol' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'price_usd' => $this->string()->notNull(),
            'updated_at' => $this->timestamp()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('cryptocurrency');
    }
}