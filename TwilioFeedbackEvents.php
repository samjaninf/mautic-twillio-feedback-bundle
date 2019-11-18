<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle;


final class TwilioFeedbackEvents
{
    const ON_REPLY = 'mautic.twilio.feedback.on_reply';
    const ON_CAMPAIGN_REPLY = 'mautic.twilio.feedback.on_campaign_reply';
}
