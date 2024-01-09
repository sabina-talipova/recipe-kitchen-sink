<?php

namespace App\Extensions;

use App\DataObjects\Department;
use Page;
use SilverStripe\ORM\DataExtension;

class CompanyExtension extends DataExtension
{
  private static $has_one = ['Page' => Page::class];
  private static $has_many = ['Departments' => Department::class];
  private static $owns = ['Departments'];
}