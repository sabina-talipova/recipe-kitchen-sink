<?php

namespace App\Extensions;

use App\DataObjects\Department;
use SilverStripe\ORM\DataExtension;

class EmployeeExtension extends DataExtension
{
  private static $has_one = ['Department' => Department::class];
}