<?php

/**
 * @see https://github.com/dotkernel/frontend/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/frontend/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Classs\Entity;

use Frontend\App\Entity\AbstractEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Year
 * @package Frontend\Frontend\Classs\Entity
 *
 * @ORM\Entity(repositoryClass="Frontend\Classs\Repository\YearRepository")
 * @ORM\Table(name="year")
 * @ORM\HasLifecycleCallbacks
 * @package Frontend\Classs\Entity
 */
class Year extends AbstractEntity
{
    public const PLATFORM_WEBSITE = 'website';
    public const PLATFORM_ADMIN = 'admin';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    /**
     * @ORM\Column(name="year", type="string", length=4)
     * @var string
     */
    protected $year;

    /**
     * @ORM\Column(name="status", type="string", length=20, columnDefinition="ENUM('active', 'deleted')")
     * @var string
     */
    protected $status;

    /**
     * Year constructor.
     * @param string $status
     * @param string $year
     */
    public function __construct(
        string $status,
        string $year
    ) {
        parent::__construct();

        $this->status = $status;
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }


    /**
     * @return string
     */
    public function setYear(string $year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     */
    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'year' => $this->getYear(),
            'status' => $this->getStatus(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }
    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'status' => $this->getStatus(),
            'year' => $this->getYear(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }
}
