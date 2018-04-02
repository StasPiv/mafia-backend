<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:35
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightAction;
use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\Result;
use CoreBundle\Model\SimpleResult;
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\Collection;

class ReflectAction implements NightAction
{
    /**
     * @param Collection|NightUserGroup[] $source
     * @param Collection|NightUser[] $destination
     * @return Result
     */
    function execute(Collection $source, Collection $destination): Result
    {
        foreach ($source as $user) {
            $user->addStatus(StatusEnum::TRIED_TO_REFLECT);
        }

        foreach ($destination as $user) {
            $user->addStatus(StatusEnum::REFLECTED);

            foreach ($source as $nightVisitor) {
                $user->addNightVisitor($nightVisitor);
            }
        }

        return new SimpleResult(
            sprintf('You have tried to reflect: %s',
                implode(
                    ',',
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