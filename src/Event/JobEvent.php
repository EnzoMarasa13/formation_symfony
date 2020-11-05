<?php
namespace App\Event;

use App\Entity\Job;
use Symfony\Contracts\EventDispatcher\Event;

class JobEvent extends Event
{
    public const NAME = 'job.created';

    protected $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function getJob()
    {
        return $this->job;
    }
}