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
     * @param Collection|NightUserGroup[] $source
     * @param Collection|NightUser[] $destination
     * @return Result
     */
    function execute(Collection $source, Collection $destination): Result
    {
        if (empty($destination)) {
            return new NullResult();
        }

        foreach ($source as $user) {
            $user->addStatus(StatusEnum::TRIED_TO_KILL);
        }

        foreach ($destination as $user) {
            $user->addStatus(StatusEnum::KILLED);

            foreach ($source as $nightVisitor) {
                $user->addNightVisitor($nightVisitor);
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
                        $source->getValues()
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