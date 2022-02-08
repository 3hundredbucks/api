<?php

use Components\UserManager;
use Components\Mailer;

return [
    UserManager::class => function($container)
    {
        return new UserManager($container->get(Mailer::class));
    },
    Mailer::class => function($container)
    {
        return new Mailer();
    }
];
