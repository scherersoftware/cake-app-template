<?php
namespace App\View\Helper;

use App\Lib\Status;
use App\Model\Entity\User;
use Cake\Utility\Hash;
use Cake\View\Helper;

class UtilsHelper extends Helper
{

    public $helpers = ['Form'];

    /**
     * Counter for the checkbox names in checkboxTree()
     *
     * @var integer
     */
    private $__checkboxTreeCounter = 0;

    /**
     * Renders a status label with the appropriate color
     *
     * @param int $status One of the Status constants
     * @return string
     */
    public function statusLabel($status)
    {
        $classes = ['label'];
        $caption = Status::getDescription($status);
        switch ($status) {
            case Status::ACTIVE:
                $classes[] = 'label-success';
                break;
            case Status::DELETED:
                $classes[] = 'label-danger';
                break;
            case Status::SUSPENDED:
                $classes[] = 'label-danger';
                break;
            default:
                $classes[] = 'label-primary';
        }

        return sprintf('<span class="%s">%s</span>', implode(' ', $classes), $caption);
    }

    /**
     * Renders a role label with the appropriate color
     *
     * @param string $role One of the Role constants
     * @return string
     */
    public function roleLabel($role)
    {
        $classes = ['label'];
        $caption = User::getTypeDescription($role);
        switch ($role) {
            case User::ROLE_ADMIN:
                $classes[] = 'label label-primary';
                break;
            case User::ROLE_USER:
                $classes[] = 'label label-warning';
                break;
            default:
                $classes[] = 'label-default';
        }

        return sprintf('<span class="%s">%s</span>', implode(' ', $classes), h($caption));
    }

    /**
     * Creates the contentHeader block
     *
     * @param string $headline Headline
     * @param array $options Options
     * @return void
     */
    public function contentHeader($headline = null, array $options = [])
    {
        $options = Hash::merge([
            'backToListButton' => true,
            'actions' => []
        ], $options);
        if ($headline === null) {
            $headline = $this->_View->fetch('title');
        }

        $actions = '';
        foreach ($options['actions'] as $action) {
            $actions .= $action;
        }
        if ($options['backToListButton']) {
            $actions .= ' ' . $this->ListFilter->backToListButton();
        }


        $markup = sprintf('<section class="content-header"><h1>%s<div class="actions pull-right">%s</div></h1></section>', $headline, $actions);
        $this->_View->assign('contentHeader', $markup);
    }
}
