<?php

namespace news\tests;

use Codeception\Actor;
use Codeception\Lib\Friend;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 * @method void see($string, $string1 = NULL)
 * @method void dontSeeElement($string)
 * @method void dontSee($string, $string1)
 * @method void amOnPage($string)
 * @method void amOnRoute($string)
 * @method void amLoggedInAs($string)
 * @method void seeEmailIsSent()
 * @method void submitForm($string, $array)
 *
 * @SuppressWarnings(PHPMD)
 */
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
