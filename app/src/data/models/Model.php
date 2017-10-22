<?php

namespace bga\app\data {

    require_once __DIR__ . '/../Result.php';

    use bga\app\data\Result as Result;
    use PDO;


    abstract class Model
    {

        private static $db;

        protected $data;

        private $message;


        public function __construct($data)
        {
            $this->data = $data;
        }

        private static function init()
        {
            $host = '127.0.0.1';
            $db = 'boardgameaffionadoes';
            $user = 'root';
            $pass = 'root';
            $charset = 'utf8';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            self::$db = new PDO($dsn, $user, $pass, $opt);
        }

        protected static function db()
        {
            if (!isset(self::$db)) {
                self::init();
            }
            return self::$db;
        }

        public function getId()
        {
            return $this->data[static::idColumn()];
        }


        /**
         * Returns an associative array of column/val pairs from the input data.
         * If the column isn't in the input it is added as null.
         * @param $inputData
         * @return array
         */
        private function addNullValuesToUpdateData($inputData)
        {
            $updateData = array();
            foreach(static::columns() as $column) {
                $updateData[$column] = array_key_exists($column, $inputData)
                    ? $inputData[$column]
                    : null;
            }

            return $updateData;
        }


        public function updateAll($inputData)
        {
            $updateArr = $this->addNullValuesToUpdateData($inputData);

            // Create the update statement.
            $sql = static::updateSql($this->getId(), $updateArr);

            // Prepare update statement.
            try {
                $update = self::db()->prepare($sql);

                // Bind the values to the update statement.
                foreach ($updateArr as $column => $updatedValue) {
                    $update->bindValue(':' . $column, $updatedValue);
                }
            } catch (\PDOException $ex) {
                $this->message = $ex->getMessage();
                return false;
            }

            // Execute update statement.
            try {
                $update->execute();
            } catch (\PDOException $ex2) {
                $this->message = $ex2->getMessage();
                return false;
            }

            $this->data = $updateArr; // update OK apply data to instance.
            return true;
        }

        public function getMessage()
        {
            return $this->message;
        }


        public function insert()
        {
            // Create the insert statement.
            $insert = self::db()->prepare(static::insertSql());

            // Bind the values to the insert statement.
            foreach (static::columns() as $column) {
                if (isset($this->data[$column])) {
                    $insert->bindValue(':' . $column, $this->data[$column]);
                }
            }

            // Insert the row.
            return $this->execute($insert);
        }

        public static function findById($model_id)
        {
            $sql = sprintf('SELECT * FROM %s WHERE %s = %s',
                static::tableName(), static::idColumn(), $model_id);

            try {
                $record = self::db()->query($sql)->fetch();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getErrorMessage());
            }

            return empty($record)
                ? Result::createEmpty()
                : Result::createSuccess(new static($record));
        }




        protected static function fetchAll($sql)
        {
            // Get the records.
            try {
                $records = self::db()->query($sql)->fetchAll();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getMessage());
            }

            // Create the models.
            $models = array_map(function ($record) {
                return new static($record);
            }, $records);

            // Return the result.
            return empty($models)
                ? Result::createEmpty()
                : Result::createSuccess($models);
        }

        public static function findAll()
        {
            $sql = 'SELECT * FROM ' . static::tableName() . ';';

            // Get the records.
            try {
                $records = self::db()->query($sql)->fetchAll();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getMessage());
            }

            // Create the models.
            $models = array_map(function ($record) {
                return new static($record);
            }, $records);

            // Return the result.
            return empty($models)
                ? Result::createEmpty()
                : Result::createSuccess($models);
        }


        public static function findWhere($column, $value)
        {
            $sql ="SELECT * FROM " . static::tableName() .
                " WHERE {$column} = {$value};";

            // Get the records.
            try {
                $records = self::db()->query($sql)->fetchAll();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getMessage());
            }

            // Create the models.
            $models = array_map(function ($record) {
                return new static($record);
            }, $records);

            // Return the result.
            return empty($models)
                ? Result::createEmpty()
                : Result::createSuccess($models);
        }



        public function delete()
        {
            $id = $this->data[static::idColumn()];
            try {
                $deleteStatement = self::db()->prepare(static::deleteSql($id));
                $deleteStatement->execute();
            } catch (\PDOException $ex) {
                return Result::createError($ex->getMessage());
            }

            return $deleteStatement->rowCount() === 1
                ? Result::createSuccess()
                : Result::createError("Problem deleting model with id " . $id);
        }


        protected static function execute($statement)
        {
            try {
                $statement->execute();
            } catch (\PDOException $ex) {
                return self::setError($ex->getMessage());
            }

            return true;
        }

        private static function insertSql()
        {
            return sprintf("INSERT INTO %s (%s) VALUES (%s);",
                static::tableName(),
                self::columnsString(),
                self::insertPlaceholdersString());
        }

        private static function updateSql($modelId, $arr)
        {
            return sprintf("UPDATE %s SET %s WHERE %s = %d;",
                static::tableName(),
                static::updateAllPlaceholderString(),
                static::idColumn(),
                $modelId);
        }


        private static function deleteSql($id)
        {
            return sprintf("DELETE FROM %s WHERE %s = %s;",
                static::tableName(),
                static::idColumn(),
                $id);
        }


        private static function columnsString()
        {
            return join(", ", static::columns());
        }


//        private static function insertPlaceholdersString()
//        {
//            return join(",", array_map(function ($column) {
//                return ":" . $column;
//            }, static::columns()));
//        }

        private static function insertPlaceholdersString()
        {
            return self::makePlaceholderString(function ($column) {
                return ":" . $column;
            });
        }

        private static function updateAllPlaceholderString()
        {
            return self::makePlaceholderString(function ($column) {
                return $column . '=:' . $column;
            });
        }

        private static function makePlaceholderString($callback)
        {
            return join(', ', array_map($callback, static::columns()));
        }


        public function __get($name)
        {
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }

            return null;
        }

        //public static $inputId;

        public static function getRequestId(&$inputId)
        {

            $id = $_REQUEST[static::idColumn()];

            if (empty($id)) return false;

            if (!filter_var($id, FILTER_VALIDATE_INT))
                return false;

            $inputId = $id;
            return true;
        }

        /**
         * Checks the $_REQUEST for the model id and if it is valid looks up the
         * model and returns it.
         *
         * @param $model the requested model if id was valid and the model was found.
         * @return bool True if the id was valid and the model was found, otherwise false.
         */
        public static function findByRequestId(&$model)
        {

            if (static::getRequestId($inputId)) {
                $modelFound = static::findById($inputId);

                if ($modelFound->success()) {
                    $model = $modelFound->model();
                    return true;
                }
            }

            return false;
        }

        public function echoIdAttr()
        {
            echo static::tableName() . '-' . $this->getId();
        }


        /* Database information models must provide */

        public static abstract function idColumn();

        public static abstract function tableName();

        public static abstract function columns();


    }
}