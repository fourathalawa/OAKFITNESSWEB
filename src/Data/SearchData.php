<?php

namespace App\Data;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;
    /**
     * @var string
     */
    public $q='';
    /**
     * @var array
     */
    public $creators = [];
    /**
     * @var \DateTime|null
     */
    public $minDate;
    /**
     * @var \DateTime|null
     */
    public $maxDate;
    /**
     * @var boolean
     */
    public $online = false;

}