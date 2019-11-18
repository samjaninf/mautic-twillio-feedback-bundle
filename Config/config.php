<?php

return [
    'name'        => 'MauticTwilioFeedbackBundle',
    'description' => 'Twilio reply processor for Mautic',
    'version'     => '1.0',
    'author'      => 'MTCExtendee',

    'routes' => [
        'public' => [
            'mautic_twilio_feedback_reply' => [
                'path'       => '/twilio/reply/callback',
                'controller' => 'MauticTwilioFeedbackBundle:Reply:callback',
            ],
        ],
    ],

    'services' => [
        'events' => [
            'mautic.twilio.feedback.subscriber.reply' => [
                'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\EventListener\ReplySubscriber::class,
                'arguments' => [
                    'translator',
                    'mautic.lead.repository.lead_event_log',
                ],
            ],
            'mautic.twillio.feedback.campaignbundle.subscriber.reply' => [
                'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\EventListener\CampaignReplySubscriber::class,
                'arguments' => [
                    'mautic.campaign.executioner.realtime',
                ],
            ],
        ],
        'forms' => [
        ],
        'models' => [

        ],
        'integrations' => [
            'mautic.integration.twiliofeedback' => [
                'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Integration\TwilioFeedbackIntegration::class,
                'arguments' => [
                ],
            ],
        ],
        'others'=>[
               'mautic.twilio.feddback.helper.phone_number' => [
                    'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Helper\PhoneNumberHelper::class,
                ],
                'mautic.twilio.feedback.helper.contact' => [
                    'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Helper\ContactHelper::class,
                    'arguments' => [
                        'mautic.lead.repository.lead',
                        'doctrine.dbal.default_connection',
                        'mautic.twilio.feddback.helper.phone_number',
                    ],
                ],
                'mautic.twilio.feedback.helper.reply' => [
                    'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Helper\ReplyHelper::class,
                    'arguments' => [
                        'event_dispatcher',
                        'monolog.logger.mautic',
                        'mautic.tracker.contact',
                        'mautic.twilio.feedback.callback'
                    ],
                ],

                'mautic.twilio.feedback.configuration' => [
                    'class'        => \MauticPlugin\MauticTwilioFeedbackBundle\Integration\Configuration::class,
                    'arguments'    => [
                        'mautic.helper.integration',
                    ],
                ],

                'mautic.twilio.feedback.callback' => [
                    'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Callback\TwilioCallback::class,
                    'arguments' => [
                        'mautic.twilio.feedback.helper.contact',
                        'mautic.twilio.feedback.configuration',
                    ],
                ],
        ],
        'controllers' => [
            'mautic.twilio.feedback.controller.reply' => [
                'class'     => \MauticPlugin\MauticTwilioFeedbackBundle\Controller\ReplyController::class,
                'arguments' => [
                    'mautic.twilio.feedback.helper.reply',
                ],
            ],
        ],
    ],
    'parameters' => [
    ],
];
