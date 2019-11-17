<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwillioFeedbackBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class TwillioFeedbackIntegration.
 */
class TwillioFeedbackIntegration extends AbstractIntegration
{
    const INTEGRATION_NAME = 'TwillioFeedback';

    public function getName()
    {
        return self::INTEGRATION_NAME;
    }

    public function getDisplayName()
    {
        return 'Twillio Feedback';
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
        return 'plugins/MauticTwillioFeedbackBundle/Assets/img/icon.png';
    }
}
