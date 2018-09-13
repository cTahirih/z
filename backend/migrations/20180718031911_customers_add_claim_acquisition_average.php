<?php


use Phinx\Migration\AbstractMigration;

class CustomersAddClaimAcquisitionAverage extends AbstractMigration
{
    public function change()
    {
        $this->table('customers')
            ->addColumn('claim_acquisition_average', 'integer', ['default' => 0, 'null' => true])
            ->update();
    }
}
