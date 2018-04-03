<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:10
 */

namespace CoreBundle\Tests\Handler;

use CoreBundle\Handler\Scenario;
use CoreBundle\Tests\Handler\Data\Director\SilentDirector;
use CoreBundle\Tests\Handler\Data\Director\TestDirector;
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

        $moves = [
            [
                'night' => [
                    'Mafia' => [
                        'Nick 2'
                    ],
                    'Reflectors' => [
                        'Some nick'
                    ],
                    'Observers' => [
                        'Mafia helper'
                    ]
                ],
                'day' => [
//                    'Some nick' => 'Another nick',
//                    'Another nick' => 'Mafia boss',
//                    'Mafia helper' => 'Nick 2',
//                    'Mafia boss' => 'Nick 2',
//                    'Dambldor' => 'Nick 2',
//                    'Sirius Black' => 'Nick 2'
                ],
            ],
            [
                'night' => [
                    'Mafia' => [
                        'Dambldor'
                    ],
                    'Reflectors' => [
                        'Some nick'
                    ],
                    'Observers' => [
                        'Mafia helper'
                    ]
                ],
                'day' => [
//                    'Some nick' => 'Nick 2',
//                    'Another nick' => 'Mafia boss',
//                    'Mafia helper' => 'Nick 2',
//                    'Mafia boss' => 'Nick 2',
//                    'Dambldor' => 'Nick 2',
//                    'Sirius Black' => 'Nick 2'
                ],
            ],
            [
                'night' => [
                    'Mafia' => [
                        'Sirius Black'
                    ],
                    'Reflectors' => [
                        'Some nick'
                    ],
                    'Observers' => [
                        'Mafia helper'
                    ]
                ],
                'day' => [
//                    'Some nick' => 'Nick 2',
//                    'Another nick' => 'Mafia boss',
//                    'Mafia helper' => 'Nick 2',
//                    'Mafia boss' => 'Nick 2',
//                    'Dambldor' => 'Nick 2',
//                    'Sirius Black' => 'Nick 2'
                ],
            ],
            [
                'night' => [
                    'Mafia' => [
                        'Another nick'
                    ],
                    'Reflectors' => [
                        'Some nick'
                    ],
                    'Observers' => [
                        'Mafia helper'
                    ]
                ],
                'day' => [
//                    'Some nick' => 'Nick 2',
//                    'Another nick' => 'Mafia boss',
//                    'Mafia helper' => 'Nick 2',
//                    'Mafia boss' => 'Nick 2',
//                    'Dambldor' => 'Nick 2',
//                    'Sirius Black' => 'Nick 2'
                ],
            ],
            [
                'night' => [
                    'Mafia' => [
                        'Some nick'
                    ],
                    'Reflectors' => [
                        'Some nick'
                    ],
                    'Observers' => [
                        'Mafia helper'
                    ]
                ],
                'day' => [
//                    'Some nick' => 'Nick 2',
//                    'Another nick' => 'Mafia boss',
//                    'Mafia helper' => 'Nick 2',
//                    'Mafia boss' => 'Nick 2',
//                    'Dambldor' => 'Nick 2',
//                    'Sirius Black' => 'Nick 2'
                ],
            ],
        ];

        $scenario->process(
            new SilentDirector(),
            new TestGame(),
            new TestGameAnalyzer(),
            $moves
        );
    }
}