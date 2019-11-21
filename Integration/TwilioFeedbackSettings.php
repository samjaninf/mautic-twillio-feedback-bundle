<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Integration;

use Mautic\CoreBundle\Helper\ArrayHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;

class TwilioFeedbackSettings
{
    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var bool|\Mautic\PluginBundle\Integration\AbstractIntegration
     */
    private $integration;

    /**
     * DolistSettings constructor.
     *
     * @param IntegrationHelper    $integrationHelper
     */
    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integration = $integrationHelper->getIntegrationObject('TwilioFeedback');
        if ($this->integration instanceof TwilioFeedbackIntegration && $this->integration->getIntegrationSettings()->getIsPublished()) {
            $this->settings = $this->integration->mergeConfigToFeatureSettings();
        }
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        $urls = ArrayHelper::getValue('redirectCallbacks', $this->settings);
        if (!$urls) {
            return [];
        }

        return array_map('trim', explode("\n", $urls));
    }
}
