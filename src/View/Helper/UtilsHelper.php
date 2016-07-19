<?php
namespace App\View\Helper;

use App\Lib\Status;
use Cake\View\Helper;

class UtilsHelper extends Helper
{

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
}
