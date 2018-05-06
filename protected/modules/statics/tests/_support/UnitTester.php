<?php

namespace statics\tests;

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
 * @method void seeEmailIsSent()
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
/** @noinspection PhpUndefinedClassInspection */

class UnitTester extends Actor
{
    use _generated\UnitTesterActions;

    /**
     * Define custom actions here
     */
}
