<?php

declare(strict_types=1);

namespace Frontend\User\FormData;

use Frontend\Classs\Entity\Year;

/**
 * Class YearFormData
 * @package Frontend\User\FormData
 */
class YearFormData
{
    public ?string $year = null;
    public ?string $status = null;

    /**
     * @param Year|object $year
     */
    public function fromEntity(Year $year)
    {
        $this->year = $year->getYear();
        $this->status = $year->getStatus();
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'year' => $this->year,
            'status' => $this->status
        ];
    }
}
