<?php

use \Codeception\Actor;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void see($string, $string1 = NULL)
 * @method void dontSeeElement($string)
 * @method void dontSee($string, $string1)
 * @method void amOnPage($string)
 * @method void amOnRoute($string)
 * @method void amLoggedInAs($string)
 * @method void am($role)
 * @method void seeEmailIsSent()
 * @method void submitForm($string, $array)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends Actor
{
    use/** @noinspection PhpUndefinedNamespaceInspection */
        /** @noinspection PhpUndefinedClassInspection */
        _generated\FunctionalTesterActions;

}
