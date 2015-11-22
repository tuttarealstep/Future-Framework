<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 20/09/2015 Time: 11:53
 */

class MySQL_Driver {

    private static $pdo;
    private static $pdo_query;
    private static $pdo_connection = false;
    private static $parameters;

    public function __construct ()
    {
        self::Connect();
        self::$parameters = array();
    }

    private static function Connect ()
    {
        $con_info = unserialize ( CONNECTION_SETTINGS );
        $PDO_dsn = "mysql:host=".$con_info['mysql_host'].":".$con_info['mysql_port'].";dbname=".$con_info['mysql_database'].";";
        try
        {
            $PDO_user = $con_info['mysql_user_username'];
            $PDO_password = $con_info['mysql_user_password'];
            self::$pdo = new PDO($PDO_dsn, $PDO_user, $PDO_password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$pdo_connection = true;
        }
        catch (PDOException $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    public static function Disconnect ()
    {
        self::$pdo = NULL;
    }

    /**
     * @param $query
     * @param string $parameters
     * @throws Exception
     */
    private static function Init($query,$parameters = "")
    {

        if(!self::$pdo_connection) { self::Connect(); }
        try
        {
            self::$pdo_query = self::$pdo->prepare($query);
            self::pdo_bind_array($parameters);
            if(!empty(self::$parameters)) {
                foreach(self::$parameters as $param)
                {
                    $parameters = explode("\x7F",$param);
                    self::$pdo_query->bindParam($parameters[0],$parameters[1]);
                }
            }
            $succes = self::$pdo_query->execute();

        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        }
        self::$parameters = array();
    }

    /**
     * @param $parameters_add
     * @param $value
     */
    public static function bind($parameters_add, $value)
    {
        self::$parameters[sizeof(self::$parameters)] = ":" . $parameters_add . "\x7F" . $value;
    }

    /**
     * @param $parameters_array
     */
    public static function pdo_bind_array($parameters_array)
    {
        if(empty(self::$parameters) && is_array($parameters_array)) {
            $columns = array_keys($parameters_array);
            foreach($columns as $i => &$column)	{
                self::bind($column, $parameters_array[$column]);
            }
        }
    }

    /**
     * @param $query
     * @param null $params
     * @param int $fetch_mode
     * @return null
     * @throws Exception
     */
    public static function query($query, $params = null, $fetch_mode = PDO::FETCH_ASSOC)
    {
        $query = trim($query);
        self::Init($query,$params);
        $rawStatement = explode(" ", $query);

        $statement = strtolower($rawStatement[0]);
        if ($statement === 'select' || $statement === 'show') {
            return self::$pdo_query->fetchAll($fetch_mode);
        }
        elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return self::$pdo_query->rowCount();
        } else {
            return NULL;
        }
    }

    public static function lastInsertId()
    {
        return self::$pdo->lastInsertId();
    }

    /**
     * @param $query
     * @param null $params
     * @return mixed
     * @throws Exception
     */
    public static function rowCount($query,$params = null)
    {
        self::Init($query,$params);
        return self::$pdo_query->rowCount();
    }

    /**
     * @param $query
     * @param null $params
     * @return array|null
     * @throws Exception
     */
    public static function column($query,$params = null)
    {
        self::Init($query,$params);
        $Columns = self::$pdo_query->fetchAll(PDO::FETCH_NUM);
        $column = NULL;
        foreach($Columns as $cells) {
            $column[] = $cells[0];
        }
        return $column;
    }

    /**
     * @param $query
     * @param null $params
     * @param int $fetchmode
     * @return mixed
     * @throws Exception
     */
    public static function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
    {
        self::Init($query,$params);
        return self::$pdo_query->fetch($fetchmode);
    }

    /**
     * @param $query
     * @param null $params
     * @return mixed
     * @throws Exception
     */
    public static function single($query,$params = null)
    {
        self::Init($query,$params);
        return self::$pdo_query->fetchColumn();
    }

    /**
     * @param $query
     * @param null $params
     * @return bool
     */
    public static function iftrue($query,$params = null)
    {
        if(!empty($query)){
            if(!empty($params)){
                $controllo = self::single($query, $params);
                if($controllo >= 1){
                    return true;
                } else {
                    return false;
                }
            } else {
                die();
            }
        } else {
            die();
        }
    }
}