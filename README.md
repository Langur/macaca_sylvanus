# Sylvanus - The database module of macaca

## Overview
Macaca is a content management system that provides a simple MVC framework.
Sylvanus supports MySQL or SQLite3, and provides a connection to the database via PDO.

## Deploy
Sylvanus is deploied as a Git submodule.
Execute following command at deployed directory for macaca.

```
git submodule add https://github.com/Langur/macaca_sylvanus.git modules/sylvanus
```

## Configuration
Need to define following parameters at *config.php* .
### MySQL
#### Parameters
- DB_TYPE
    - Database type
- DB_NAME
    - Database name.
- DB_USER
    - User name to use when connecting to the database.
- DB_PASSWORD
    - Password to use when connecting to the database.
- DB_PREFIX
    - Prefix to be assigned to the Table name.
    - This parameter can be empty.
- DB_HOST
    - Database Host.
- DB_PORT
    - Database Port.
- DB_CHARASET
    - Database character encoding.
- DB_COLLATION
    - Database collation.
#### Example

```
define('DB_TYPE',      'mysql');
define('DB_NAME',      'sample');
define('DB_USER',      'user');
define('DB_PASSWORD',  'password');
define('DB_PREFIX',    'sylvanus_');
define('DB_HOST',      '127.0.0.1');          // DBのIPアドレス or FQDN
define('DB_PORT',      '3306');               // DBのポート番号
define('DB_CHARSET',   'utf8mb4');            // MySQLの場合はutf8mb4をデフォルトにすると良い
define('DB_COLLATION', 'utf8mb4_general_ci');
```

### SQLite
#### Parameters
- DB_TYPE
    - Database type
- DB_FILE
    - Database file.
- DB_PREFIX
    - Prefix to be assigned to the Table name.
    - This parameter can be empty.
#### Example

```
define('DB_TYPE',      'sqlite');
define('DB_FILE',      __ABSPATH__ . 'database/sylvanus.db');
define('DB_PREFIX',    'sylvanus_');
```

## Initializez
Modify *public/index.php* .
Add following code before *$kernel->execContriler();* .

```
// MySQL
$database = new Sylvanus\MySQL();
Sylvanus\init($database, DB_TYPE);
$database->connect();
$kernel->setDatabase($database);

// SQLite
$database = new Sylvanus\SQLite();
Sylvanus\init($database, DB_TYPE);
$database->connect();
$kernel->setDatabase($database);
```

## License
This software is distributed under the MIT License. Please read LICENSE for information on the software availability and distribution.
