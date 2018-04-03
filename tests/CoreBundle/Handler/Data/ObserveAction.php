<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:33
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

class ObserveAction implements NightAction
{
    /**
     * @param NightUserGroup $source
     * @param Collection|User[] $destination
     * @return Result
     */
    function execute(NightUserGroup $source, Collection $destination): Result
    {
        foreach ($destination as $user) {
            $user->addStatus(StatusEnum::OBSERVED);
        }

        /** @var User $destinationUser */
        $destinationUser = $destination->first();

        return new SimpleResult(
            sprintf('The user %s has observed %s. The user %s has been visited by: %s',
                implode(
                    ',',
                    array_map(
                        function (User $user) {
                            return $user->getName();
                        },
                        $source->getNightUsers()->getValues()
                    )
                ),
                $destinationUser->getName(),
                $destinationUser->getName(),
                implode(
                    ',',
                    array_map(
                        function (User $user) {
                            return $user->getName();
                        },
                        $destinationUser->getNightVisitors()->getValues()
                    )
                )
            )
        );
    }

}