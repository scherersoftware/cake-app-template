<?php

namespace Api\V1\Controller;

use CakeApiBaselayer\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    /**
     * beforeFilter
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // only as long as this is not done in CakeApiBaselayer\ApiComponent:
        $this->Api->apiTokenAuthentication();
    }
}
