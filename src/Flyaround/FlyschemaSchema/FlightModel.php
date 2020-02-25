<?php

namespace App\Flyaround\FlyschemaSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use App\Flyaround\FlyschemaSchema\AutoStructure\Flight as FlightStructure;
use App\Flyaround\FlyschemaSchema\Flight;

/**
 * FlightModel
 *
 * Model class for table flight.
 *
 * @see Model
 */
class FlightModel extends Model
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
        $this->structure = new FlightStructure;
        $this->flexible_entity_class = 'App\Flyaround\FlyschemaSchema\Flight';
    }
}
