<?php

declare(strict_types=1);

namespace App;


use App\Behaviors\AxeBehavior;
use App\Behaviors\BowBehavior;
use App\Behaviors\KnifeBehavior;
use App\Behaviors\SwordBehavior;
use App\Behaviors\WeaponBehaviorInterface;

class Behavior
{
    protected object $weaponBehavior;

    public function getWeaponBehavior(): string
    {
        return $this->weaponBehavior->useWeapon();
    }

    public function getAction()
    {
        $action = $this->getBehavior();
        $this->setWeaponBehavior($action);
    }

    private function setWeaponBehavior(WeaponBehaviorInterface $weaponBehavior)
    {
        $this->weaponBehavior = $weaponBehavior;
    }

    private function getBehavior()
    {
        $behavior = [
            new AxeBehavior(),
            new SwordBehavior(),
            new KnifeBehavior(),
            new BowBehavior(),
        ];

        $key = array_rand($behavior);

        return $behavior[$key];
    }
}