<?php

return [
    'name'        => 'Twillio Fedback',
    'description' => 'Twillio reply processor for Mautic',
    'version'     => '1.0',
    'author'      => 'MTCExtendee',

    'routes' => [
        'public' => [
            'mautic_twillio_feedback_reply' => [
                'path'       => '/twillio/Reply/callback',
                'controller' => 'MauticTwillioFeedbackBundle::callback',
            ],
        ],
    ],

    'services' => [
        'events' => [

        ],
        'forms' => [
        ],
        'models' => [

        ],
        'integrations' => [
            'mautic.integration.twilliofeedback' => [
                'class'     => \MauticPlugin\MauticTwillioFeedbackBundle\Integration\TwillioFeedbackIntegration::class,
                'arguments' => [
                ],
            ],
            'others'=>[
                'mautic.twillio.feddback.helper.phone_number' => [
                    'class'     => \MauticPlugin\MauticTwillioFeedbackBundle\Helper\PhoneNumberHelper::class,
                ],
                'mautic.twillio.feedback.helper.contact' => [
                    'class'     => \MauticPlugin\MauticTwillioFeedbackBundle\Helper\ContactHelper::class,
                    'arguments' => [
                        'mautic.lead.repository.lead',
                        'doctrine.dbal.default_connection',
                        'mautic.twillio.feddback.helper.phone_number',
                    ],
                ],
                'mautic.twillio.feedback.helper.reply' => [
                    'class'     => \MauticPlugin\MauticTwillioFeedbackBundle\Helper\ReplyHelper::class,
                    'arguments' => [
                        'event_dispatcher',
                        'monolog.logger.mautic',
                        'mautic.tracker.contact',
                    ],
                ],
            ]
        ],
        'controllers' => [
            'mautic.twillio.feedback.controller.reply' => [
                'class'     => \MauticPlugin\MauticTwillioFeedbackBundle\Controller\ReplyController::class,
                'arguments' => [
                    'mautic.twillio.feedback.helper.reply',
                ],
            ],
        ],
    ],
    'parameters' => [
    ],
];
