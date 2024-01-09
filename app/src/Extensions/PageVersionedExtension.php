<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\FrameworkTest\Model\Company;
use SilverStripe\ORM\DataExtension;

class PageVersionedExtension extends DataExtension
{
  private static $has_many = [
    'Companies' => Company::class,
  ];

  private static $owns = [
    'Companies',
  ];

  public function updateCMSFields(FieldList $fields)
  {
    $fields->addFieldToTab('Root.Companies', GridField::create(
        'Companies',
        'Companies',
        $this->owner->Companies(),
        GridFieldConfig_RecordEditor::create()
    ));
  }
}
