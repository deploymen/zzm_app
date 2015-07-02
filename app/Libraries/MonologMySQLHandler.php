<?php namespace App\Libraries;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use PDO;
use PDOStatement;

/**
 * This class is a handler for Monolog, which can be used
 * to write records in a MySQL table
 *
 * Class MySQLHandler
 * @package wazaari\MysqlHandler
 */
class MonologMySQLHandler extends AbstractProcessingHandler {

    /**
     * @var bool defines whether the MySQL connection is been initialized
     */
    private $initialized = false;

    /**
     * @var PDO pdo object of database connection
     */
    private $pdo;

    /**
     * @var PDOStatement statement to insert a new record
     */
    private $statement;

    /**
     * @var string[] additional fields to be stored in the database
     *
     * For each field $field, an additional context field with the name $field
     * is expected along the message, and further the database needs to have these fields
     * as the values are stored in the column name $field.
     */
    private $additionalFields = array();

    /**
     * Constructor of this class, sets the PDO and calls parent constructor
     *
     * @param PDO $pdo                  PDO Connector for the database
     * @param bool $table               Table in the database to store the logs in
     * @param array $additionalFields   Additional Context Parameters to store in database
     * @param bool|int $level           Debug level which this handler should store
     * @param bool $bubble
     */
    public function __construct(PDO $pdo, $level = Logger::DEBUG, $bubble = true) {
        $this->pdo = $pdo;
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  $record[]
     * @return void
     */
    protected function write(array $record) {
        //var_export($record); die();
        $this->statement = $this->pdo->prepare("
            INSERT INTO `t9401_log_general` (
                `level_name` ,
                `message` ,
                `environment` ,
                `created_ip`
            )
            VALUES (:level_name, :message, :environment, :created_ip);
        ");

        $contentArray = array(
            'level_name' => $record['level_name'],
            'message' => $record['message'],
            'environment' => (isset($record['context']['environment']))?$record['context']['environment']:"",
            'created_ip' => $_SERVER['REMOTE_ADDR'],            
        );

        $this->statement->execute($contentArray);
    }
}