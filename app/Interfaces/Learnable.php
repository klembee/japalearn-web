<?php


namespace App\Interfaces;


/**
 * Defines what a learnable class have to implement
 * Interface Learnable
 * @package App\Interfaces
 */
interface Learnable
{
    public function getNextReviewAttribute();
    public function getLastReviewDateAttribute();
    public function getLevelAttribute();
    public function getAnswersAttribute();

    public function getHumanLevelAttribute();

    public function getObjectIdAttribute();

//    public function getAnswersAttribute();
}
