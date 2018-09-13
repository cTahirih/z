<?php


use Phinx\Migration\AbstractMigration;

class ReportsCacheCreate extends AbstractMigration
{
    public function change()
    {
        $this->table('reports_cache')
            ->addColumn('report', 'string')
            ->addColumn('parameters', 'text')
            ->addColumn('content', 'text')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
