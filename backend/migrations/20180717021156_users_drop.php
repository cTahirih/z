<?php


use Phinx\Migration\AbstractMigration;

class UsersDrop extends AbstractMigration
{
    public function up()
    {
        $this->table('users')->drop();
    }
    
    
    public function down()
    {
        $this->table('users')
            ->addColumn('customer_id', 'biginteger')
            ->addColumn('prefix', 'string')
            ->addColumn('first_name', 'string')
            ->addColumn('middle_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('registered_date', 'datetime')
            ->addColumn('is_active', 'string')
            ->addColumn('newsletter_status', 'string')
            ->addColumn('points_balance', 'integer')
            ->addColumn('points_delta', 'integer', ['null' => true])
            ->addColumn('mobile', 'string')
            ->addColumn('telephone', 'string')
            ->addColumn('address', 'string')
            ->addColumn('zip_code', 'string')
            ->addColumn('city', 'string')
            ->addColumn('dob', 'date', ['null' => true])
            ->addColumn('region', 'string', ['null' => true])
            ->addColumn('country', 'string', ['null' => true])
            ->addColumn('segment', 'string')
            
            ->addIndex(['customer_id'], ['unique' => true])
            ->addIndex(['segment'])
            ->create();
    }
}
