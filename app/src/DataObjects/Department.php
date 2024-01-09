<?php

namespace App\DataObjects;

use SilverStripe\Forms\TextField;
use SilverStripe\FrameworkTest\Model\Company;
use SilverStripe\FrameworkTest\Model\Employee;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Department extends DataObject
{
  private static $table_name = 'FrameworkTest_Department';

  private static $extensions = [Versioned::class];
  private static $versioned_gridfield_extensions = true;

  private static $db = [
    'Name' => 'Varchar(255)',
    'Location' => 'Varchar(255)',
  ];

  private static $has_one = ['Company' => Company::class];
  private static $has_many = ['Employees' => Employee::class];
  private static $owns = ['Employees'];

  public function getCMSFields()
  {
    $fields = parent::getCMSFields();

    $fields->addFieldsToTab('Root.Main', [TextField::create('Name'), TextField::create('Location')]);

    return $fields;
  }
}
