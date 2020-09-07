<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use BenSampo\Enum\Enum as BaseEnum;
use BenSampo\Enum\Contracts\LocalizedEnum;

abstract class Enum extends BaseEnum implements LocalizedEnum
{
    /**
     * All labels for the Enum.
     *
     * @return Collection
     */
    public static function labels(): Collection
    {
        return collect(__(self::getLocalizationKey()));
    }

    /**
     * Get all values with their labels.
     *
     * @return Collection
     */
    public static function all(): Collection
    {
        return collect(self::getValues())->transform(function ($enumValue) {
            return ['id' => $enumValue, 'label' => self::getDescription($enumValue)];
        });
    }

    /**
     * Render as JSON.
     *
     * @return string
     */
    public static function toJson(): string
    {
        return self::all()->toJson();
    }
}
