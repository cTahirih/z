# Phinx migrations guide

These are our developer standards on Phinx usage.

## Coding Style
As usual, [PSR-2 coding conventions](https://www.php-fig.org/psr/psr-2/) should be followed for all PHP code.

## Migration files naming
The naming of the migration files is as follows:

1. First, the Table name (in CamelCase).
2. Second, the operation. Examples: "Create", "Drop", "Insert", "Update", "Add", "Remove", etc.
3. Any other relevant details.

### Examples:

Creating the `order_details` table:

    phinx create OrderDetailsCreate

Dropping the `students` table:

    phinx create StudentsDrop

Adding a new column `email` to the `persons` table:

    phinx create PersonsAddEmail

Add several new columns to `persons` table:

    phinx create PersonsAddSocialLoginFields

**Note:** Phinx doesn't allow two migrations to have the same name. In these cases, append a suffix or name the operation differently.

## Migrations content

Use Phinx's methods [as documented](http://docs.phinx.org/en/latest/migrations.html) instead of raw SQL queries, unless needed because of database-specific features.

[The `change()` method](http://docs.phinx.org/en/latest/migrations.html#the-change-method) should be used instead of `up()` and `down()` unless needed (e.g. removing columns).


## Bootstrap data
For bootstrapping data needed by the application, use migrations with inserts (e.g. `UbigeoInsertDepartments`) instead of [Seeds](http://docs.phinx.org/en/latest/seeding.html). See the [Inserting Data](http://docs.phinx.org/en/latest/migrations.html#inserting-data) section of Phinx's documentation.

It's recommended to use separate migration files for table creation and inserting bootstrap data. Example:

    phinx create UserTypesCreate
    phinx create UserTypesInsertDefaults

Seeds will be used for loading development or test data.