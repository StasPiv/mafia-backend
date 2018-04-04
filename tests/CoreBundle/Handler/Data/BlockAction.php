<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 04.04.18
 * Time: 19:26
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightAction;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\Result;
use CoreBundle\Model\SimpleResult;
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;
use CoreBundle\Model\UserCollectionInterface;

class BlockAction implements NightAction
{
    /**
     * @param NightUserGroup $source
     * @param User[]|UserCollectionInterface $destination
     * @return Result
     */
    function execute(NightUserGroup $source, UserCollectionInterface $destination): Result
    {
        foreach ($source->getNightUsers() as $user) {
            $user->addStatus(StatusEnum::TRIED_TO_BLOCK);
        }

        foreach ($destination as $user) {
            $user->addStatus(StatusEnum::BLOCKED);

            foreach ($source->getNightUsers() as $nightVisitor) {
                $user->addNightVisitor($nightVisitor);
            }
        }

        return new SimpleResult(
            sprintf('%s tried to block: %s',
                implode(
                    ', ',
                    array_map(
                        function (User $user) {
                            return $user->getName();
                        },
                        $source->getNightUsers()->getValues()
                    )
                ),
                implode(
                    ', ',
                    array_map(
                        function (User $user) {
                            return $user->getName();
                        },
                        $destination->getValues()
                    )
                )
            )
        );
    }

}