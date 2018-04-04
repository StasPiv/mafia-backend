<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 04.04.18
 * Time: 15:06
 */

namespace CoreBundle\Handler;


use CoreBundle\Model\Director;
use CoreBundle\Model\Game;
use CoreBundle\Model\GameAnalyzer;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use CoreBundle\Tests\Handler\Data\Director\SilentDirector;
use CoreBundle\Tests\Handler\Data\Game\TestGame;
use CoreBundle\Tests\Handler\Data\TestGameAnalyzer;

class ScenarioGenerator
{
    /** @var array */
    private $availableGroupNames;

    /** @var array */
    private $availableUserNames;

    /** @var Game */
    private $game;

    /**
     * ScenarioGenerator constructor.
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->initAvailableNames($game);
    }

    public function generateScenario()
    {
        $cityWonCounter = $mafiaWonCounter = 0;

        foreach (range(1,1000) as $testCounter) {
            $scenario = new Scenario();
            $director = new SilentDirector();
            $gameAnalyzer = new TestGameAnalyzer();
            $this->game = new TestGame();

            $roundCounter = 0;

            $moves = [];

            do {
                $roundMoves = $this->generateRoundMoves($scenario, $director, $this->game, $gameAnalyzer, $roundCounter);
                $moves[] = $roundMoves;
            } while (!$this->game->isFinished());

            if ($this->game->isCityWon()) {
                $result = 'citywon';
                $cityWonCounter++;
            } elseif ($this->game->isMafiaWon()) {
                $result = 'mafiawon';
                $mafiaWonCounter++;
            } else {
                $result = 'undefined';
            }

//            file_put_contents(__DIR__ . sprintf('/../../../tests/CoreBundle/Handler/_json/%s%d.json', $result, $testCounter), json_encode($moves));

            echo sprintf('CITY - MAFIA %d : %d' . PHP_EOL . PHP_EOL, $cityWonCounter, $mafiaWonCounter);
        }

    }

    /**
     * @param Game $game
     */
    private function initAvailableNames(Game $game)
    {
        $this->availableGroupNames = array_map(
            function (NightUserGroup $group) {
                return $group->getName();
            },
            $game->getNightUserGroups()->getValues()
        );

        $this->availableUserNames = array_map(
            function (User $user) {
                return $user->getName();
            },
            $game->getAliveUsers()->getValues()
        );
    }

    /**
     * @param array $availableUserNames
     * @return string
     */
    private function getRandomUserName($availableUserNames = []): string
    {
        if (empty($availableUserNames)) {
            $availableUserNames = $this->availableUserNames;
        }

        return $availableUserNames[mt_rand(0, count($availableUserNames) - 1)];
    }

    /**
     * @param array $availableGroupNames
     * @return string
     */
    private function getRandomUserGroupName($availableGroupNames = []): string
    {
        if (empty($availableGroupNames)) {
            $availableGroupNames = $this->availableGroupNames;
        }

        return $availableGroupNames[mt_rand(0, count($availableGroupNames) - 1)];
    }

    private function generateRoundMoves(Scenario $scenario, Director $director, Game $game, GameAnalyzer $gameAnalyzer, int $roundCounter = 0): array
    {
        // night
        $this->initAvailableNames($game);

        $availableGroupNames = $this->availableGroupNames;
        $availableUserNames = $this->availableUserNames;

        $nightMoves = $dayMoves = [];

        while (count($availableGroupNames) > 0) {
            $groupName = $this->getRandomUserGroupName($availableGroupNames);
            
            if (($key = array_search($groupName, $availableGroupNames)) !== false) {
                unset($availableGroupNames[$key]);
                sort($availableGroupNames);
            }
            
            $userName = $this->getRandomUserName($availableUserNames);
            
            // TODO: might be more than one victim
            $nightMoves[$groupName] = [ $userName ];
        }

        $scenario->performNightActionsForAllGroups($director, $game, $nightMoves, $roundCounter);
        $gameAnalyzer->analyzeNight($game);

        if ($game->isFinished()) {
            return [];
        }

        // day
        $this->initAvailableNames($game);
        
        $usersWhoVoteNames = $this->availableUserNames;

        while (count($usersWhoVoteNames) > 0) {
            $userWhoVoteName = $this->getRandomUserName($usersWhoVoteNames);

            if (($key = array_search($userWhoVoteName, $usersWhoVoteNames)) !== false) {
                unset($usersWhoVoteNames[$key]);
                sort($usersWhoVoteNames);
            }

            $userAgainstName = $this->getRandomUserName($this->availableUserNames);
            
            $dayMoves[$userWhoVoteName] = $userAgainstName;
        }

        $scenario->performVoteForAllUsers($director, $game, $dayMoves, $roundCounter);
        $gameAnalyzer->analyzeDay($game);

        return [
            'night' => $nightMoves,
            'day' => $dayMoves
        ];
    }
}