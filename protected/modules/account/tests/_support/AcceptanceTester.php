<?php

namespace account\tests;

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
 * @method void dontSeeElement($string)
 * @method void amOnPage($string)
 * @method void seeLink($string)
 * @method void click($role)
 * @method void wait($i)
 * @method void see($string, $string1 = NULL)
 * @method void fillField($string, $string1)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */
}
