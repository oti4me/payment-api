<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Payments extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('payments');

        $table->addColumn('customer_id', 'integer')
            ->addColumn('transaction_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('reference', 'string')
            ->addColumn('amount', 'string')
            ->addColumn('payment_type', 'string')
            ->addColumn('currency', 'string')
            ->addColumn('product_ids', 'string')
            ->addForeignKey('user_id', 'users', 'id')
            ->addTimestamps()
            ->create();
    }
}
