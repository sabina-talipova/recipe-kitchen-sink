<?php

namespace App\Tasks;

use App\DataObjects\Department;
use Page;
use SilverStripe\Dev\BuildTask;
use SilverStripe\FrameworkTest\Model\Company;
use SilverStripe\FrameworkTest\Model\Employee;
use SilverStripe\FrameworkTest\Versioned\Model\NonVersionedChildObject;
use SilverStripe\FrameworkTest\Versioned\Model\NonVersionedParentObject;
use SilverStripe\FrameworkTest\Versioned\Model\VersionedChildObject;
use SilverStripe\FrameworkTest\Versioned\Model\VersionedParentObject;

/**
 * Class PerformTestTask
 * 
 * Run task in browser `http://localhost/dev/tasks/PTTask?count=3&type=object`
 * 
 * - `count` param is quantity of records on each level, on last level count will be increased in 10 times.
 * By default `count = 5`.
 * E.g `count = 10`, you will get 10 Company records, 10 Department records for each Company record 
 * and 100 Employee records for each Department record.
 * 
 * - `type` param is type of Objects, `object`.
 * By default `type = page`.
 * E.g `type = object`, you will get VersionedParentObject records with NonVersionedChildObject records
 * and NonVersionedParentObject records with VersionedChildObject records. Test in Test Versioned Object section.
 * 
 */

class PerformTestTask extends BuildTask
{
  private static $segment = 'PTTask';
  protected $title = 'Perform Test Task';
  protected $description = 'This task performs a test';
  protected $enabled = true;

  public function run($request)
  {
    if ($request->getVars()['count'] && (int) $request->getVars()['count'] > 0) {
      $count = $request->getVars()['count'];
    } else {
      $count = 5;
    }

    if ($request->getVars()['type'] && $request->getVars()['type'] == 'object') {
      $this->createObjectSet($count);
    } else {
      $this->createPageSet($count);
    }
  }

  private function createPageSet($count): void
  {
    $employee_count = $count * 10;

    echo "Performing test...\n";
    echo $count . " instances of classes Company and Department will be created. \n";
    echo  $employee_count . " instances of Employee class will be created. \n"; 
    echo "*******************\n";

    $curr_time = round(microtime(true));

    $page = Page::create(['Title' => 'Test_Page_' . $curr_time]);
    $id = $page->write();

    for ($i = 0; $i < $count; $i++) {
      $company = Company::create(['Name' => 'Test_Company_' . $i]);
      $company->PageID = $id;
      $company->write();

      for ($j = 0; $j < $count; $j++) {
        $department = Department::create(['Name' => 'Test_Department_' . $i . $j]);
        $department->CompanyID = $company->ID;
        $department->write();

        for ($k = 0; $k < $employee_count; $k++) {
          $employee = Employee::create(['Name' => 'Test_Employee_' . $i . $j . $k]);
          $employee->DepartmentID = $department->ID;
          $employee->write();
        }
      }
    }

    echo $count*$count*$employee_count . " records were created \n";
    echo "Test completed.\n";
  }

  private function createObjectSet($count): void
  {
    $subobj_count = $count * 10;

    echo "Performing test...\n";
    echo $count . " instances of classes VersionedParentObject and NonVersionedParentObject will be created. \n";
    echo  $subobj_count . " instances of NonVersionedChildObject and VersionedChildObject class will be created. \n"; 
    echo "*******************\n";

    for ($i = 0; $i < $count; $i++) {
      $parent = VersionedParentObject::create(['Name' => 'Test_VersionedParentObject_' . $i]);
      $parent->write();

      for ($j = 0; $j < $subobj_count; $j++) {
        $child = NonVersionedChildObject::create(['Name' => 'Test_NonVersionedChildObject_' . $i . $j]);
        $child->VersionedParentObjectID = $parent->ID;
        $child->write();
      }
    }

    for ($i = 0; $i < $count; $i++) {
      $parent = NonVersionedParentObject::create(['Name' => 'Test_NonVersionedParentObject_' . $i]);
      $parent->write();

      for ($j = 0; $j < $subobj_count; $j++) {
        $child = VersionedChildObject::create(['Name' => 'Test_VersionedChildObject_' . $i . $j]);
        $child->NonVersionedParentObjectID = $parent->ID;
        $child->write();
      }
    }

    echo $count*$count*$subobj_count . " records were created \n";
    echo "Test completed.\n";
  }
}
