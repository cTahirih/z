<?php


use Phinx\Migration\AbstractMigration;

class UsersMachinesDrop extends AbstractMigration
{
    public function up()
    {
        $this->table('users_machines')->drop();
    }
    
    
    public function down()
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
