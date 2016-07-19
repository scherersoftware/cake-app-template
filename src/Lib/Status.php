<?php
namespace App\Lib;

class Status
{

    const ACTIVE = 'active';
    const DELETED = 'deleted';
    const SUSPENDED = 'suspended';

    public static $descriptions = [];

    /**
     * Get descriptions for statuses
     *
     * @return array
     */
    public static function getDescriptions()
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
    public static function getMap($states = null)
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
    public static function getDescription($status)
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
