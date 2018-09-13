<?php
use Phinx\Migration\AbstractMigration;

class MachinesCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('machines')
            ->addColumn('entity_id', 'integer')
            ->addColumn('name', 'string')
            ->addColumn('is_active', 'char', ['length' => 1])
            ->addColumn('type', 'string')
            
            ->addIndex(['entity_id'], ['unique' => true])
            ->create();
    }
}
