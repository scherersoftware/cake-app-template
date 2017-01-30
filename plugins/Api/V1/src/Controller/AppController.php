<?php
declare(strict_types = 1);
namespace Api\V1\Controller;

use CakeApiBaselayer\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event): void
    {
        parent::beforeFilter($event);
        // only as long as this is not done in CakeApiBaselayer\ApiComponent:
        $this->Api->apiTokenAuthentication();
    }
}
