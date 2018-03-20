<?php

use Codeception\Actor;

class FunctionalTester extends Actor
{
    use _generated\FunctionalTesterActions;

    public function seeValidationError($message)
    {
        $this->see($message, '.help-block');
    }

    public function dontSeeValidationError($message)
    {
        $this->dontSee($message, '.help-block');
    }
}
