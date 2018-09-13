<?php


use Phinx\Migration\AbstractMigration;

class CustomersCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('customers')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('points_balance', 'integer')
            ->addColumn('segment', 'string', ['length' => 8, 'null' => true])
            ->addColumn('created_at', 'datetime')
            
            ->addIndex(['customer_id'])
            ->addIndex(['segment'])
            ->addIndex(['created_at'])
            ->create();
    }
}
