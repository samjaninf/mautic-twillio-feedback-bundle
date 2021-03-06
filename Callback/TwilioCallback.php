<?php

/*
 * @copyright   2019 Mautic Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://www.mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Callback;

use MauticPlugin\MauticTwilioFeedbackBundle\Exception\ConfigurationException;
use MauticPlugin\MauticTwilioFeedbackBundle\Exception\NumberNotFoundException;
use MauticPlugin\MauticTwilioFeedbackBundle\Helper\ContactHelper;
use MauticPlugin\MauticTwilioFeedbackBundle\Integration\Configuration;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TwilioCallback
{
    /**
     * @var ContactHelper
     */
    private $contactHelper;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * TwilioCallback constructor.
     *
     * @param ContactHelper $contactHelper
     * @param Configuration $configuration
     */
    public function __construct(ContactHelper $contactHelper, Configuration $configuration)
    {
        $this->contactHelper = $contactHelper;
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function getTransportName()
    {
        return 'twilio';
    }

    /**
     * @param Request $request
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     *
     * @throws NumberNotFoundException
     */
    public function getContacts(Request $request)
    {
        $this->validateRequest($request);

        $number = $request->get('From');

        return $this->contactHelper->findContactsByNumber($number);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getMessage(Request $request)
    {
        $this->validateRequest($request);

        return trim($request->get('Body'));
    }

    /**
     * @param ParameterBag $request
     */
    private function validateRequest(Request $request)
    {
        try {
            $accountSid = $this->configuration->getAccountSid();
        } catch (ConfigurationException $exception) {
            // Not published or not configured
            throw new NotFoundHttpException();
        }
        // Validate this is a request from Twilio
        if ($accountSid !== $request->get('AccountSid')) {
            throw new BadRequestHttpException();
        }

        // Who is the message from?
        $number = $request->get('From');
        if (empty($number)) {
            throw new BadRequestHttpException();
        }

        // What did they say?
        $message = trim($request->get('Body'));
        if (empty($message)) {
            throw new BadRequestHttpException();
        }
    }
}
