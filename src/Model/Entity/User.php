<?php
namespace App\Model\Entity;

use App\Lib\Status;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use CkTools\Utility\TypeAwareTrait;

/**
 * User Entity.
 */
class User extends Entity
{

    use TypeAwareTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'attachment_uploads' => true
    ];

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * Define type descriptions
     *
     * @return array
     */
    public static function typeDescriptions()
    {
        return [
            self::ROLE_USER => __('user.role.user'),
            self::ROLE_ADMIN => __('user.role.admin'),
        ];
    }

    /**
     * Returns a map of possible roles for a user with descriptions
     *
     * @return array
     */
    public static function getRoles()
    {
        return self::getTypeMap(self::ROLE_USER, self::ROLE_ADMIN);
    }

    /**
     * Returns a map of possible statuses for a user with descriptions
     *
     * @return array
     */
    public static function getStatuses()
    {
        return Status::getMap(Status::ACTIVE, Status::SUSPENDED);
    }

    /**
     * Setter for hashed password
     *
     * @param string $password not hashed password
     * @return string
     */
    protected function _setPassword($password)
    {
        if (!empty($password)) {
            $password = (new DefaultPasswordHasher)->hash($password);
        }

        return $password;
    }
}
