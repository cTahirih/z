<?php
namespace BaseTest;

use Hamcrest\MatcherAssert as HamcrestMatcherAssert;
use ReflectionClass;
use RuntimeException;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Helpers for common Unit Testing operations
 *
 * @package BaseTest
 * @author Jaime G. Wong <j@jgwong.org>
 */
trait Helpers
{
    /**
     * @var Adapter
     */
    protected $dbAdapter;
    
    
    /**
     * Returns the application's Service Manager.
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getApplicationServiceLocator();
    }
    
    
    /**
     * Overwrite a service in the Service Manager.
     *
     * @param string $name
     * @param mixed $service
     * @return void
     */
    public function setService($name, $service)
    {
        $serviceManager = $this->getServiceManager();
        $status = $serviceManager->getAllowOverride();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService($name, $service);
        $serviceManager->setAllowOverride($status);
    }
    
    
    /**
     * Allows modifying the global Config array via a closure.
     *
     * @param closure $closure
     * @return void
     */
    public function setConfig($closure) {
        $config    = $this->getServiceManager()->get('Config');
        $newconfig = $closure($config);
        $this->setService('Config', $newconfig);
    }
    
    
    /**
     * Sets the status for showing the Backend Template.
     *
     * @param bool $status
     * @return void
     */
    public function setShowBackendTemplate($status)
    {
        $this->setConfig(function ($config) use ($status) {
            $config['show_backend_template'] = $status;
            return $config;
        });
    }
    
    
    /**
     * Returns the application's Zend DB Adapter.
     *
     * @return Adapter
     */
    public function getDbAdapter()
    {
        if (is_null($this->dbAdapter)) {
            $this->dbAdapter = $this->getApplicationServiceLocator()->get('Zend\Db\Adapter\Adapter');
        }
        
        return $this->dbAdapter;
    }
    
    
    /**
     * Truncates a table from the test database. If array given, all the
     * tables are truncated in one query.
     *
     * @param string|array $table
     * @param bool $force Forces the TRUNCATE on tables with foreign keys
     *                    on MySQL.
     * @return void
     */
    public function truncateTable($table, $force = false)
    {
        $query = '';
        
        if (is_array($table)) {
            foreach ($table as $t) {
                $query .= "TRUNCATE $t; ";
            }
        } else {
            $query = "TRUNCATE $table;";
        }
        
        if ($force) {
            $query = 'SET FOREIGN_KEY_CHECKS = 0; ' . $query . ' SET FOREIGN_KEY_CHECKS = 1;';
        }
        
        $this->getDbAdapter()->query($query, Adapter::QUERY_MODE_EXECUTE);
    }
    
    
    /**
     * Alias of `truncateTable()`.
     *
     * @param string|array $table
     * @param bool $force
     * @return void
     */
    public function truncateTables($table, $force = false)
    {
        return $this->truncateTable($table, $force);
    }
    
    
    /**
     * Returns a new TableGateway instance for a given table.
     *
     * @param string $table
     * @return void
     */
    public function getTableGateway($table)
    {
        return new TableGateway($table, $this->getDbAdapter());
    }
    
    
    /**
     * Returns the contents of a Fixture file.
     *
     * @param string $name
     * @throws RuntimeException
     * @return mixed
     */
    public function loadFixture($name)
    {
        $reflection    = new ReflectionClass(__CLASS__);
        $classFileName = $reflection->getFileName();
        $filename      = dirname($classFileName) . "/Fixture/{$name}.php";
        
        if (!file_exists($filename)) {
            throw new RuntimeException("Fixture $name not found.");
        }
        
        return include $filename;
    }
    
    
    /**
     * Inserts a Fixture into a database table. The parameter can be either
     * a Fixture name or an array.
     *
     * @param string $tableName
     * @param string|array $fixtureDataOrName
     * @return void
     */
    public function insertFixtureIntoTable($tableName, $fixtureDataOrName)
    {
        $tableGateway = $this->getTableGateway($tableName);
        
        if (is_array($fixtureDataOrName)) {
            $fixture = $fixtureDataOrName;
        } else {
            $fixture = $this->loadFixture($fixtureDataOrName);
        }
        
        foreach ($fixture as $row) {
            $tableGateway->insert($row);
        }
    }
    
    
    /**
     * Assert number of rows in database.
     *
     * @param int $count
     * @param string $tableName
     * @return bool
     */
    public function assertTableCountIs($count, $tableName)
    {
        $tableGateway = $this->getTableGateway($tableName);
        $result       = $tableGateway->select();
        
        $this->assertEquals($count, $result->count(), sprintf('Number of rows in table %s does not match. Expected %s, but is %s.',
            $tableName,
            $count,
            $result->count()
        ));
    }
    
    
    /**
     * @return boolean
     */
    public function isJsonResponse()
    {
        $contentType = $this->getResponse()->getHeaders()->get('content-type');
        
        if ($contentType === false) {
            return false;
        }
        
        return $contentType->getMediaType() == 'application/json';
    }
    
    
    /**
     * @return array
     */
    public function getDecodedJsonResponse()
    {
        return json_decode($this->getResponse()->getBody(), true);
    }
    
    
    /**
     * Assert the Response is of Content-Type "application/json" and is a
     * valid, decodable JSON content.
     *
     * @return void
     */
    public function assertResponseIsJson()
    {
        $this->assertTrue($this->isJsonResponse(), 'Response is NOT of Content-Type "application/json"');
        
        // Check if JSON response can be parsed without errors.
        $this->getDecodedJsonResponse();
        $this->assertEquals(JSON_ERROR_NONE, json_last_error(), 'Response is invalid JSON content.');
    }
    
    
    /**
     * Assert the Response is NOT of Content-Type "application/json". It does
     * not check for JSON validity.
     *
     * @return void
     */
    public function assertResponseIsNotJson()
    {
        $this->assertFalse($this->isJsonResponse(), 'Failed asserting Response Content-Type is NOT "application/json"');
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsString($var)
    {
        $type = gettype($var);
        $this->assertTrue(is_string($var), "Expected string value, but got $type type.");
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsInteger($var)
    {
        $type = gettype($var);
        $this->assertTrue(is_integer($var), "Expected integer value, but got $type type.");
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsBool($var)
    {
        $type = gettype($var);
        $this->assertTrue(is_bool($var), "Expected boolean value, but got $type type.");
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsArray($var)
    {
        $type = gettype($var);
        $this->assertTrue(is_array($var), "Expected boolean value, but got $type type.");
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsEmptyArray($var)
    {
        $this->assertIsArray($var);
        $count = count($var);
        $this->assertEquals(0, $count, "Expected empty array, but array size is $count instead.");
    }
    
    
    /**
     * @param mixed $var
     * @return void
     */
    public function assertIsNotEmptyArray($var)
    {
        $this->assertIsArray($var);
        $count = count($var);
        $this->assertGreaterThan(0, $count, "Expected non-empty array, but array is empty instead.");
    }
    
    
    /**
     * Collects assertions performed by Hamcrest matchers during the test.  
     * Taken from: https://gist.github.com/dharkness/3965902
     *
     * @return void
     */
    public function runBare() {
        HamcrestMatcherAssert::resetCount();
        
        try {
            parent::runBare();
        }
        catch (Exception $exception) {
            // rethrown below
        }
        
        $this->addToAssertionCount(HamcrestMatcherAssert::getCount());
        
        if (isset($exception)) {
            throw $exception;
        }
    }
}
