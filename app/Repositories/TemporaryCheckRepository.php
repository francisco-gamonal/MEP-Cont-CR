<?php
/**
 * Created by PhpStorm.
 * User: Amwar
 * Date: 05/04/2017
 * Time: 04:00 PM
 */

namespace Mep\Repositories;

use Mep\Entities\TemporaryCheck;

class TemporaryCheckRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new TemporaryCheck(); // TODO: Implement getModel() method.

    }
}