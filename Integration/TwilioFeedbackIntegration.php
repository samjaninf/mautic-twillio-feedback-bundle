<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class TwilioFeedbackIntegration.
 */
class TwilioFeedbackIntegration extends AbstractIntegration
{
    const INTEGRATION_NAME = 'TwilioFeedback';

    public function getName()
    {
        return self::INTEGRATION_NAME;
    }

    public function getDisplayName()
    {
        return 'Twilio Feedback';
    }

    public function getAuthenticationType()
    {
        return 'none';
    }

    public function getRequiredKeyFields()
    {
        return [
        ];
    }

    public function getIcon()
    {
        return 'plugins/MauticTwilioFeedbackBundle/Assets/img/icon.png';
    }


    /**
     * {@inheritdoc}
     *
     * @param $section
     *
     * @return string
     */
    public function getFormNotes($section)
    {
        if ('custom' === $section) {
            return [
                'template'   => 'MauticTwilioFeedbackBundle:Integration:twiliofeedback.html.php',
                'parameters' => [
                ],
            ];
        }

        return parent::getFormNotes($section);
    }
}
