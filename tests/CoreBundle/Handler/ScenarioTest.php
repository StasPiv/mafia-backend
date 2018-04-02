<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:10
 */

namespace CoreBundle\Tests\Handler;

use CoreBundle\Handler\Scenario;
use CoreBundle\Tests\Handler\Data\Director\TestDirector;
use CoreBundle\Tests\Handler\Data\Game\TestGame;
use CoreBundle\Tests\Handler\Data\TestGameAnalyzer;

class ScenarioTest extends \PHPUnit_Framework_TestCase
{

    public function testScenario()
    {
        $scenario = new Scenario();

        $moves = [
            'night' => [
                [
                    [
                        'Nick 2'
                    ],
                    [
                        'Some nick'
                    ],
                    [
                        'Mafia helper'
                    ]
                ],
                [
                    [
                        'Some nick'
                    ],
                    [
                        'Some nick'
                    ],
                    [
                        'Mafia helper'
                    ]
                ],
                [
                    [
                        'Another nick'
                    ],
                    [
                        'Some nick'
                    ],
                    [
                        'Mafia helper'
                    ]
                ],
                [
                    [
                        'Dambldor'
                    ],
                    [
                        'Some nick'
                    ],
                    [
                        'Mafia helper'
                    ]
                ],
                [
                    [
                        'Sirius Black'
                    ],
                    [
                        'Some nick'
                    ],
                    [
                        'Mafia helper'
                    ]
                ]
            ],
            'day' => [
                [
                    'Some nick' => 'Mafia boss',
                    'Another nick' => 'Mafia helper'
                ],
                [
                    'Some nick' => 'Mafia boss',
                    'Another nick' => 'Mafia helper'
                ],
                [
                    'Some nick' => 'Mafia boss',
                    'Another nick' => 'Mafia helper'
                ],
                [
                    'Some nick' => 'Mafia boss',
                    'Another nick' => 'Mafia helper'
                ],
                [
                    'Some nick' => 'Mafia boss',
                    'Another nick' => 'Mafia helper'
                ]
            ]
        ];

        $scenario->process(
            new TestDirector(),
            new TestGame(),
            new TestGameAnalyzer(),
            $moves
        );
    }
}