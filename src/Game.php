<?php

declare(strict_types=1);

namespace App;


class Game
{
    private array $battle = [];

    public function start(): array
    {
        $createPlayer = new \App\CreatePlayer();
        $playerOne = $createPlayer->create();
        $playerTwo = $createPlayer->create();

        $behavior = new Behavior();

        return $this->fight($playerOne, $playerTwo, $behavior);
    }

    private function fight(object $playerOne, object $playerTwo, object $behavior)
    {
        $playerOneHealth = $playerOne->getHealth();
        $playerTwoHealth = $playerTwo->getHealth();

        $i = 1;
        while (true) {
            $playerOneKick = $this->attackPower($playerOne->getStrength());
            $playerTwoKick = $this->attackPower($playerTwo->getStrength());

            $playerOneHealth -= $playerTwoKick;
            $playerTwoHealth -= $playerOneKick;

            if (($playerOneHealth <= 0) || ($playerTwoHealth <= 0)) {
                $name = '';
                $race = '';

                if ($playerOneHealth <= 0) {
                    $name = $playerOne->getName();
                    $race = $playerOne->getRace();
                }

                if ($playerTwoHealth <= 0) {
                    $name = $playerTwo->getName();
                    $race = $playerTwo->getRace();
                }

                $this->battle[$i]['end']['name'] = "В этом бою ОТВАЖНО ПОГИБ <b>{$race} {$name}</b>";
                break;
            }

            $behavior->getAction();
            $weaponOne = $behavior->getWeaponBehavior();
            $behavior->getAction();
            $weaponTwo = $behavior->getWeaponBehavior();

            $behaviorOne = $weaponOne;
            $behaviorTwo = $weaponTwo;

            $this->battleRecords(
                $i, 1, $playerOne->getRace(), $playerOne->getName(),
                $playerOneHealth, $behaviorOne, $playerTwo->getRace(), $playerTwoKick
            );

            $this->battleRecords(
                $i, 2, $playerTwo->getRace(), $playerTwo->getName(),
                $playerTwoHealth, $behaviorTwo, $playerOne->getRace(), $playerOneKick
            );

            $i++;
        }

        return $this->battle;
    }

    private function battleRecords(int $round, int $player, string $race, string $name, int $life, string $weapon, string $enemy, int $hit): void
    {
        $this->battle[$round][$player] = [
            'race' => $race,
            'name' => $name,
            'life' => $life,
            'weapon' => $weapon,
            'enemy' => $enemy,
            'hit' => $hit,
        ];
    }

    private function attackPower(int $strength): int
    {
        return \mt_rand(1, $strength);
    }
}
