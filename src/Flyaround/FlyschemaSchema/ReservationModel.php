<?php

namespace App\Flyaround\FlyschemaSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use Flyaround\FlyschemaSchema\AutoStructure\Reservation as ReservationStructure;
use Flyaround\FlyschemaSchema\Reservation;

/**
 * ReservationModel
 *
 * Model class for table reservation.
 *
 * @see Model
 */
class ReservationModel extends Model
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
        $this->structure = new ReservationStructure;
        $this->flexible_entity_class = '\Flyaround\FlyschemaSchema\Reservation';
    }
}
