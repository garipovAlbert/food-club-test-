<?php

$config['components']['mailer'] = [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@app/mail',
    'useFileTransport' => false,
    /* example for $localParams[mailer] */
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'itiinitru@gmail.com',
        'password' => 'Kb1u3VyExw5l',
        'port' => '465',
        'encryption' => 'ssl',
        'plugins' => [
            [
                'class' => 'Swift_Plugins_LoggerPlugin',
                'constructArgs' => [new Swift_Plugins_Loggers_ArrayLogger()],
            ],
        ],
    ],
];
