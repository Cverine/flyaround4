<?php

namespace App\Flyaround\FlyschemaSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use App\Flyaround\FlyschemaSchema\AutoStructure\Airport as AirportStructure;
use App\Flyaround\FlyschemaSchema\Airport;

/**
 * AirportModel
 *
 * Model class for table airport.
 *
 * @see Model
 */
class AirportModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->structure = new AirportStructure;
        $this->flexible_entity_class = 'App\Flyaround\FlyschemaSchema\Airport';
    }

    public function importCsv()
    {
        $sql = <<<SQL
                    COPY airport
                    FROM 'french-airports.csv' DELIMITER ';' CSV HEADER;
SQL;

        return $sql;

    }
}
