<?php
namespace App\Controller;

use CkTools\Lib\ApiReturnCode;

class HomeController extends AppController
{

    /**
     * Home
     *
     * @return void
     */
    public function index()
    {
        $this->FrontendBridge->setJson('demoText', 'I was passed from the Backend to the Frontend via FrontendBridge');
    }

    /**
     * Returns a JSON response
     *
     * @return Response
     */
    public function getJsonData()
    {
        $code = ApiReturnCode::SUCCESS;

        return $this->Api->response($code, [
            'foo' => 'bar',
            'baz' => 'buff'
        ]);
    }

    /**
     * jsonAction Demo Action.
     *
     * @return void
     */
    public function listUsers()
    {
        $this->loadModel('Users');
        $users = $this->Users->find('list')->toArray();
        $this->FrontendBridge->setJson('users', $users);
    }
}
