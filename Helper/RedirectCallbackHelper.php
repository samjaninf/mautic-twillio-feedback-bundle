<?php

/*
 * @copyright   2019 Mautic Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://www.mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Helper;

use Mautic\LeadBundle\Entity\Lead;
use Mautic\LeadBundle\Tracker\ContactTracker;
use MauticPlugin\MauticTwilioFeedbackBundle\Callback\TwilioCallback;
use MauticPlugin\MauticTwilioFeedbackBundle\Event\ReplyEvent;
use MauticPlugin\MauticTwilioFeedbackBundle\Exception\NumberNotFoundException;
use MauticPlugin\MauticTwilioFeedbackBundle\Integration\TwilioFeedbackSettings;
use MauticPlugin\MauticTwilioFeedbackBundle\TwilioFeedbackEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectCallbackHelper
{

    /**
     * @var TwilioFeedbackSettings
     */
    private $twilioFeedbackSettings;

    /**
     * RedirectCallbackHelper constructor.
     *
     * @param TwilioFeedbackSettings $twilioFeedbackSettings
     */
    public function __construct(TwilioFeedbackSettings $twilioFeedbackSettings)
    {
        $this->twilioFeedbackSettings = $twilioFeedbackSettings;
    }

    /**
     * @param Request $request
     */
    public function redirectCallbacks(Request $request)
    {
        foreach ($this->twilioFeedbackSettings->getUrls() as $url) {
            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($request->request->all()));
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_exec($ch);
            curl_close($ch);
        }

      //  $this->red(
      //      $request,
    //        'https://webhook.frontapp.com/sms/75e91c9140edcb8d59771e8cab6a8357cc64ab60db45ad4b51da1266c6bcfda342af1b573269cad948bb495502dc64d1'
  //      $this->red($request, 'http://webhook.site/d4188b0b-e9dd-4f91-9f49-18e1f0faaccd');
    }
}
