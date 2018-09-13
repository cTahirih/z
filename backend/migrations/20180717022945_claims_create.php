<?php


use Phinx\Migration\AbstractMigration;

class ClaimsCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('claims')
            ->addColumn('order_id', 'biginteger')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('created_at', 'datetime')
             
            ->addIndex(['customer_id'])
            ->addIndex(['created_at'])
            ->create();

    }
}
