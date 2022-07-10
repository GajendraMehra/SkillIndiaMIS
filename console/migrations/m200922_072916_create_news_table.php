<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m200922_072916_create_news_table extends Migration
{
    protected $indexKeys = ['key', 'type'];


    public function init()
    {
       
        $this->tableName = 'tbl_config';
        $this->columns = [
            'id'                        => 'SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'key'                       => 'VARCHAR(100) NOT NULL',
            'value'                     => 'VARCHAR(255) NOT NULL',
            'type'                      => 'TINYINT(4) UNSIGNED NOT NULL DEFAULT '.$configurator::TYPE_BOOLEAN,
            self::COLUMN_CREATED        => 'DATETIME NOT NULL',
            self::COLUMN_UPDATED        => 'DATETIME DEFAULT NULL',
        ];
    }
}