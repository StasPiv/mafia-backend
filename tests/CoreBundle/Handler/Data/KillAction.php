<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:22
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightAction;
use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\NullResult;
use CoreBundle\Model\Result;
use CoreBundle\Model\SimpleResult;
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\Collection;

class KillAction implements NightAction
{
    /**
     * @param NightUserGroup $source
     * @param Collection|User[] $destination
     * @return Result
     */
    function execute(NightUserGroup $source, Collection $destination): Result
    {
        if ($destination->isEmpty()) {
            return new NullResult();
        }

        $source->addStatus(StatusEnum::SHOTTED);

        foreach ($source->getNightUsers() as $user) {
            $user->addStatus(StatusEnum::SHOTTED);
        }

        foreach ($destination as $user) {
            $user->addStatus(StatusEnum::KILLED);

            foreach ($source as $nightVisitor) {
                $user->addNightVisitor($nightVisitor);
                $user->addKiller($nightVisitor);
            }
        }

        return new SimpleResult(
            sprintf('%s have tried to kill %s',
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