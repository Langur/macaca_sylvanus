<?php
/**
 * Sylvanusのクラス
 *
 * Sylvanusにおける処理のコアとなります。
 * Databaseの操作を行うためのクラスを定義します。
 * 
 * @copyright Copyright (c) 2017-2023 Akihisa ONODA
 * @license https://github.com/Langur/macaca_sylvanus/blob/main/LICENSE MIT
 * @link https://github.com/Langur/macaca_sylvanus#readme
 * @author Akihisa ONODA <akihisa.onoda@osarusystem.com>
 */

namespace Sylvanus;
use \PDO;

/**
 * Sylvanusクラス
 *
 * Databaseを操作するためのabstructクラス。
 * 
 * @category Sylvanus
 * @package  Sylvanus
 */
abstract class Sylvanus
{
    private $parameter;

    public function __construct()
    {
        $this->parameter = [];
    }
    
    // クラスを拡張するための処理
    public function __call($name, $args)
    {
        if (strncmp($name, 'get', 3) === 0) {
            return $this->get(substr($name, 3), reset($args));
        } 
        elseif (strncmp($name, 'set', 3) === 0) {
            return $this->set(substr($name, 3), reset($args));
        }
        elseif (strncmp($name, 'exec', 4) === 0) {
            return $this->exec(substr($name, 4), reset($args));
        }


        throw new \BadMethodCallException('Method "' . $name . '" does not exist.');
    }

    // クラスを拡張するための処理
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    // クラスを拡張するための処理
    public function get($key, $default=null)
    {
        if (array_key_exists($key, $this->parameter)) {
              return $this->parameter[$key];
        }

        return $default;
    }

    // クラスを拡張するための処理
    public function set($key, $value)
    {
        $this->parameter[$key] = $value;
    }

    // クラスを拡張するための処理
    public function exec($key, $func=null)
    {
        $func();
    }

    // Databaseに接続するための定義
    abstract public function connect();
}

/**
 * MySQLクラス
 *
 * MySQLを操作するためのクラス。
 * 
 * @category Sylvanus
 * @package  Sylvanus
 */
class MySQL extends Sylvanus
{
    private $pdo;

    /**
     * Databaseに接続するための処理。
     *
     * @return void
     */
    public function connect()
    {
        try {
            $this->pdo = new PDO($this->getTYPE() . ":" .
                                 "host="    . $this->getHOST() . ";" .
                                 "port="    . $this->getPORT() . ";" .
                                 "dbname="  . $this->getNAME() . ";" .
                                 "charset=" . $this->getCHARSET(),
                                 $this->getUSER(),
                                 $this->getPASSWORD());
        } catch (PDOException $e) {
            exit;
        }

        $this->setPDO($this->pdo);
    }

    /**
     * クエリを発行する。
     *
     * @param string $sql
     * @return PDOStatement object | false
     */
    public function execQuery($sql)
    {
        try {
            $result = $this->pdo->query($sql);
        } catch (PDOException $e) {
            exit;
        }

        return $result;
    }
}

/**
 * SQLiteクラス
 *
 * SQLite3を操作するためのクラス。
 * 
 * @category Sylvanus
 * @package  Sylvanus
 */
class SQLite extends Sylvanus
{
    private $pdo;

    /**
     * Databaseに接続するための処理。
     *
     * @return void
     */
    public function connect()
    {
        try {
            $this->pdo = new PDO($this->getTYPE() . ":" .
                                 $this->getFILE());
        } catch (PDOException $e) {
            exit;
        }

        $this->setPDO($this->pdo);
    }

    /**
     * クエリを発行する。
     *
     * @param string $sql
     * @return PDOStatement object | false
     */
    public function execQuery($sql)
    {
        try {
            $result = $this->pdo->query($sql);
        } catch (PDOException $e) {
            exit;
        }

	return $result;
    }
}
