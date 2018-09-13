<?php


use Phinx\Migration\AbstractMigration;

class MachinesReCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('machines')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('entity_id', 'biginteger')
            ->addColumn('segment', 'string', ['length' => 8, 'default' => 'gold'])
            ->addColumn('created_at', 'datetime')
            
            ->addIndex(['customer_id'])
            ->addIndex(['segment'])
            ->addIndex(['created_at'])
            ->create();
    }
}
