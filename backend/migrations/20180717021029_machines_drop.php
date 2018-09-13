<?php


use Phinx\Migration\AbstractMigration;

class MachinesDrop extends AbstractMigration
{
    public function up()
    {
        $this->table('machines')->drop();
    }
    
    
    public function down()
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
