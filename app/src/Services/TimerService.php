<?php

namespace App\Services;

/**
 * Update index.php to use this class:
 * 
 * // After use section at the begining of the code
 * use App\Services\TimerService;
 * $timer = new TimerService();
 * $timer->start();
 * 
 * 
 * // main code here
 * 
 * $timer->stop();
 * echo $timer->getElapsedTime();
 */
class TimerService
{
  private $startTime;
  private $endTime;

  public function start()
  {
    $this->startTime = microtime(true);
  }

  public function stop()
  {
    $this->endTime = microtime(true);
  }

  public function getElapsedTime()
  {
    return $this->endTime - $this->startTime;
  }
}
