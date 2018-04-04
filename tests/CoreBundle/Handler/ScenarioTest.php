<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:10
 */

namespace CoreBundle\Tests\Handler;

use CoreBundle\Handler\Scenario;
use CoreBundle\Handler\ScenarioGenerator;
use CoreBundle\Tests\Handler\Data\Director\SilentDirector;
use CoreBundle\Tests\Handler\Data\Game\TestGame;
use CoreBundle\Tests\Handler\Data\TestGameAnalyzer;

class ScenarioTest extends \PHPUnit_Framework_TestCase
{

    public function testScenario()
    {
        $scenario = new Scenario();

        /**
         * Users: Peaceful (Nick 2, Some nick, Another nick), Mafia (Mafia helper, Mafia boss), Observers (Dambldor), Reflectors (Sirius Black)
         */
        $moves = json_decode(file_get_contents(__DIR__ . '/_json/test1.json'), true);

        $scenario->process(
            new SilentDirector(),
            new TestGame(),
            new TestGameAnalyzer(),
            $moves
        );
    }

    public function testGenerator()
    {
        $scenarioGenerator = new ScenarioGenerator(new TestGame());

        $scenarioGenerator->generateScenario();
    }
}