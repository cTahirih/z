<?php
use Phinx\Migration\AbstractMigration;

class UsersMachinesCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('users_machines')
            ->addColumn('entity_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('machine_id', 'integer')
            ->addColumn('code', 'string')
            ->addColumn('how', 'char', ['length' => 10])
            ->addColumn('where', 'string', ['null' => true])
            ->addColumn('purchase_date', 'datetime')
            ->addColumn('creation_date', 'datetime')
            
            ->addIndex(['entity_id'], ['unique' => true])
            ->create();

    }
}
