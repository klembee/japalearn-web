<?php


namespace App\Interfaces;


/**
 * Defines what a learnable class have to implement
 * Interface Learnable
 * @package App\Interfaces
 */
interface Learnable
{
    public function getLastReviewDateAttribute();
    public function getLevelAttribute();

    public function getHumanLevelAttribute();

    public function getObjectIdAttribute();

//    public function getAnswersAttribute();
}
