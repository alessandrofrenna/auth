<?php

namespace frenna\auth;

use yii\base\Module;

class Auth extends Module
{

    public $controllerNamespace = 'frenna\auth\controllers';

    public $defaultRoute = 'auth';

    public $viewPath = 'Views/auth';

    public function init()
    {
        parent::init();
    }
}