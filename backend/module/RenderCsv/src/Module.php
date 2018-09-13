<?php
namespace RenderCsv;

/**
 * @package RenderCsv
 * @author Jaime G. Wong <j@jgwong.org>
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
