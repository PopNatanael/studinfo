<?php

declare(strict_types=1);
namespace Frontend\Classs\Entity;

use Frontend\Classs\Entity\Classs;

/**
 * Interface ClasssInterface
 * @package Frontend\User\Entity
 */
interface ClasssInterface
{
/**
     * @param Classs $class
     * @return ClasssInterface
     */
    public function addClass(Classs $class): ClasssInterface;
}
