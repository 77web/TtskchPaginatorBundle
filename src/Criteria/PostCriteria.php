<?php

declare(strict_types=1);

namespace App\Criteria;

use Ttskch\PaginatorBundle\Entity\Criteria;

class PostCriteria extends Criteria
{
    public $query;
    public $after;
    public $before;
}
