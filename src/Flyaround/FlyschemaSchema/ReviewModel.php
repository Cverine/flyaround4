<?php

namespace App\Flyaround\FlyschemaSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use Flyaround\FlyschemaSchema\AutoStructure\Review as ReviewStructure;
use Flyaround\FlyschemaSchema\Review;

/**
 * ReviewModel
 *
 * Model class for table review.
 *
 * @see Model
 */
class ReviewModel extends Model
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
        $this->structure = new ReviewStructure;
        $this->flexible_entity_class = '\Flyaround\FlyschemaSchema\Review';
    }
}
