<?php
declare(strict_types = 1);
namespace App\Lib;

class Status
{

    public const ACTIVE = 'active';
    public const DELETED = 'deleted';
    public const SUSPENDED = 'suspended';

    /**
     * Descriptions
     *
     * @var array
     */
    public static $descriptions = [];

    /**
     * Get descriptions for statuses
     *
     * @return array
     */
    public static function getDescriptions(): array
    {
        return [
            self::ACTIVE => __('status.active'),
            self::DELETED => __('status.deleted'),
            self::SUSPENDED => __('status.suspended')
        ];
    }

    /**
     * Get mapping of const to description
     *
     * @param string|array $states states to get mapped
     * @return array
     */
    public static function getMap($states = null): array
    {
        if (!is_array($states)) {
            $states = func_get_args();
        }
        $group = [];
        if ($states === null) {
            $states = array_keys(self::getDescriptions());
        }
        foreach ($states as $state) {
            $group[$state] = self::getDescription($state);
        }

        return $group;
    }

    /**
     * Get single description
     *
     * @param string $status status to get description of
     * @return string|null
     */
    public static function getDescription(string $status): ?string
    {
        if (!self::$descriptions) {
            self::$descriptions = self::getDescriptions();
        }

        if (isset(self::$descriptions[$status])) {
            return self::$descriptions[$status];
        }

        return null;
    }
}
