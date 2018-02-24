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
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends Actor
{
    use/** @noinspection PhpUndefinedNamespaceInspection */
        /** @noinspection PhpUndefinedClassInspection */
        _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */
}
