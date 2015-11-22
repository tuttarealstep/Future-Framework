<?php
/**
 * MyCMS(TProgram) - Project
 * Date: 11/09/2015 Time: 20:04
 */
class Mongo_Driver {

    public static $connected = false;
    private static $mongo;

    public function __construct ()
    {
        self::Connect();
    }

    private static function Connect ()
    {
        $connection_info = unserialize ( CONNECTION_SETTINGS );
        $mongo_parameters = "mongodb://".$connection_info['mongo_host'].":".$connection_info['mongo_port'];

        try {
            if ( !class_exists('Mongo')){
                throw new \Exception('MongoDB class not installed or enabled.');
            }
            if($connection_info['mongo_user_username'] != '' && $connection_info['mongo_user_password'] != ''){
                $mongo_connection = new \MongoClient($mongo_parameters, ['username'=>$connection_info['mongo_user_username'],'password'=>$connection_info['mongo_user_password']]);
            } else {
                $mongo_connection = new \MongoClient($mongo_parameters);
            }
            if(self::$mongo = $mongo_connection->selectDB($connection_info['mongo_database'])){
                self::$connected = true;
            } else {
                throw new \Exception('Can\'t connect to MongoDB.');
            }
        } catch ( \Exception $e){
            die($e);
        }

    }

    /**
     * Disconnect function
     */
    private static function Disconnect ()
    {
        self::$mongo = null;
    }

    /**
     * @param string $collection
     * @return \MongoCollection
     */
    public static function getCollection($collection){
        $collection = self::$mongo->$collection;
        return $collection;
    }

    /**
     * @param $collection
     * @param string $query
     * @param string $where
     * @param string $sort
     * @return \MongoCursor
     */
    public static function MongoFind($collection, $query = '', $where = '', $sort = '', $one = false){
        $collection = self::getCollection($collection);
        if(empty($query)){
            if(!empty($sort)){
                $return_query = $collection->find()->sort($sort);
            } else {
                    $return_query = $collection->find();
            }
        } else {
            if(!empty($sort)){
                if(!empty($where)) {
                    $return_query = $collection->find($where, $query)->sort($sort);
                } else {
                    $return_query = $collection->find($query)->sort($sort);
                }
            } else {
                if(!empty($where)) {
                    if($one){
                        $return_query = $collection->findOne($where, $query);
                    } else {
                        $return_query = $collection->find($where, $query);
                    }
                } else {
                    if($one){
                        $return_query = $collection->findOne($query);
                    } else {
                        $return_query = $collection->find($query);
                    }
                }
            }
        }
        return $return_query;
    }

    /**
     * @param $collection
     * @param $array
     * @return array|bool
     */
    public static function MongoInsert($collection, $array){
        $collection = self::getCollection($collection);
        return $collection->insert($array);
    }

    /**
     * @return mixed
     */
    public static function MongoQuery($collection = ''){
        if(!empty($collection)){
            $collection = self::getCollection($collection);
            return $collection;
        }
        return self::$mongo;
    }

    /**
     * @param $collection
     * @param string $query
     * @return int
     */
    public static function MongoCount($collection, $query = ''){
        $collection = self::getCollection($collection);
        if(empty($query)){
            $return_query = $collection->count();
        } else {
            $return_query = $collection->find($query)->count();
        }
        return $return_query;
    }

    /**
     * @param $collection
     * @param string $where
     * @param string $new
     * @return bool
     */
    public static function MongoUpdate($collection, $where = '', $new = ''){
        $collection = self::getCollection($collection);

        $return_query = $collection->update($where, $new);

        return $return_query;
    }

}