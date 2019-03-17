<?php

namespace Sid\Phalcon\Cron\Job;

use Phalcon\DiInterface;
use Sid\Phalcon\Cron\Job;

class Phalcon extends Job
{
    /**
     * @var array|null
     */
    protected $body;



    /**
     * @param array|null $body
     *
     * @throws Exception
     */
    public function __construct(string $expression, $body = null)
    {
        $di = $this->getDI();
        if (!($di instanceof DiInterface)) {
            throw new Exception(
                "A dependency injection object is required to access internal services"
            );
        }



        parent::__construct($expression);



        $this->body = $body;
    }



    /**
     * @return array|null
     */
    public function getBody()
    {
        return $this->body;
    }



    public function runInForeground() : string
    {
        ob_start();

        $this->getDI()->get("console")->handle(
            $this->getBody()
        );

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }
}
