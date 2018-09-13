<?php


use Phinx\Migration\AbstractMigration;

class CapsulesCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('capsules')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('code', 'string')
            ->addColumn('reward_id', 'biginteger')
            ->addColumn('segment', 'string', ['length' => 8, 'default' => 'gold'])
            ->addColumn('created_at', 'datetime')
            
            ->addIndex(['customer_id'])
            ->addIndex(['created_at'])
            ->create();
    }
}
