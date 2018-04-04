<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:22
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightAction;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\NullResult;
use CoreBundle\Model\Result;
use CoreBundle\Model\SimpleResult;
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;
use CoreBundle\Model\UserCollectionInterface;

class KillAction implements NightAction
{
    /**
     * @param NightUserGroup $source
     * @param UserCollectionInterface|User[] $destination
     * @return Result
     */
    function execute(NightUserGroup $source, UserCollectionInterface $destination): Result
    {
        if ($destination->isEmpty()) {
            return new NullResult();
        }

        $source->addStatus(StatusEnum::SHOTTED);

        foreach ($source->getNightUsers() as $user) {
            $user->addStatus(StatusEnum::SHOTTED);
        }


        foreach ($destination as $user) {
            $user->addKiller($source);

            if (!$source->isUserExist($user)) {
                $user->addStatus(StatusEnum::KILLED);
            }

            foreach ($source as $nightVisitor) {
                $user->addNightVisitor($nightVisitor);
            }
        }

        return new SimpleResult(
            sprintf('%s have tried to kill %s',
                $source->getNightUsers(),
                $destination
            )
        );
    }

}