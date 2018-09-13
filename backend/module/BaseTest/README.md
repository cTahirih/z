# BaseTest module

This module provides helpers and functions to aid Unit Testing.

**Important:** This module should only be loaded in Development environment.

## BaseTest\Helpers trait

**BaseTest\Helpers** is a trait which extends a test class with several helper methods. Here is a short summary of each method, but I recommend to read the source code.

### Application-wide methods

#### getServiceManager()
Alias for `Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase::getApplicationServiceLocator()` (what a mouthful!).

#### setConfig()
Allows overwriting the global application `Config` array using a Closure.

#### setShowBackendTemplate()
Allows forcing the global application `show_backend_template` flag.

### Database and Fixture methods

#### getDbAdapter()
Returns the application's `Zend\Db\Adapter\Adapter` instance.

#### truncateTable()
Truncates a table or tables from the test database.

#### truncateTables()
Alias for readability.

#### getTableGateway()
Returns a `TableGateway` instance for a given table.

#### loadFixture()
Loads a Fixture file. By convention, Fixtures are kept in a `Fixture` directory, relative to the current class file.

#### insertFixtureIntoTable()
Inserts a Fixture data into a Table. You can specify either a Fixture file name or an array. Note: the table is not truncated.

### JSON methods

#### isJsonResponse()
Returns true if the dispatch response's `content-type` is `application/json`.

#### getDecodedJsonResponse()
Decodes a JSON-encoded Response.

#### assertResponseIsJson()
Asserts a Response is of JSON content type and the content can be decoded without errors by `json_decode()`.

#### assertResponseIsNotJson()
Opposite of `assertResponseIsJson()`.


### Types assertion methods

The following methods require no explanation:

- `assertIsString()`
- `assertIsInteger()`
- `assertIsBool()`
- `assertIsArray()`
- `assertIsEmptyArray()`
- `assertIsNotEmptyArray()`


### Hamcrest

This trait will overload `runBase()` to add the count of [Hamcrest](https://github.com/hamcrest/hamcrest-php) assertions.


## BaseTest\FakeFileUpload trait

This trait uses a namespacing trick to monkey-patch `is_uploaded_file` and `move_uploaded_file` internal PHP functions. These two functions validate a file has really been uploaded and thus complicates Unit Testing.

Here we are replacing them with alternatives that still work.

Just "use" this trait on your class and you're done. Kinda hackish, but works. :)
