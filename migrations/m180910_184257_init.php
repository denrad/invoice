<?php

use yii\db\Migration;

/**
 * Class m180910_184257_init
 */
class m180910_184257_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('legal', [
            'id' => $this->primaryKey(),
            'type' => $this->string(32)->notNull(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'inn' => $this->string(12)->notNull(),
            'kpp' => $this->string(12)->null(),
            'checking_account' => $this->string(255)->notNull(),
            'correspondent_account' => $this->string(255)->notNull(),
            'bik' => $this->string(16)->notNull(),
            'bank_name' => $this->string(255)->notNull(),
        ]);

        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'buyer_id' => $this->integer()->notNull(),
            'seller_id' => $this->integer()->notNull(),
            'total_cost' => $this->money(2)->notNull(),
            'vat' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('invoice_position', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer()->notNull(),
            'name' => $this->string(255),
            'unit' => $this->string(16),
            'count' => $this->integer()->notNull(),
            'cost' => $this->money(2)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('invoice_position');
        $this->dropTable('invoice');
        $this->dropTable('legal');
    }
}
