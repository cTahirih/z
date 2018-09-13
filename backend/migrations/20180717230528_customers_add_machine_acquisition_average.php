<?php


use Phinx\Migration\AbstractMigration;

class CustomersAddMachineAcquisitionAverage extends AbstractMigration
{
    public function change()
    {
        $this->table('customers')
            ->addColumn('machine_acquisition_average', 'integer', ['default' => 0, 'null' => true])
            ->update();
    }
}
