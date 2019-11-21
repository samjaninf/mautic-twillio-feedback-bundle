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
use MauticPlugin\MauticTwilioFeedbackBundle\TwilioFeedbackEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ReplyHelper.
 */
class ReplyHelper
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ContactTracker
     */
    private $contactTracker;

    /**
     * @var TwilioCallback
     */
    private $twilioCallback;

    /**
     * @var RedirectCallbackHelper
     */
    private $redirectCallbackHelper;

    /**
     * ReplyHelper constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     * @param ContactTracker           $contactTracker
     * @param TwilioCallback           $twilioCallback
     * @param RedirectCallbackHelper   $redirectCallbackHelper
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger, ContactTracker $contactTracker, TwilioCallback $twilioCallback, RedirectCallbackHelper $redirectCallbackHelper)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger          = $logger;
        $this->contactTracker  = $contactTracker;
        $this->twilioCallback = $twilioCallback;
        $this->redirectCallbackHelper = $redirectCallbackHelper;
    }

    /**
     * @param string $pattern
     * @param string $replyBody
     *
     * @return bool
     */
    public static function matches($pattern, $replyBody)
    {
        return fnmatch($pattern, $replyBody, FNM_CASEFOLD);
    }

    /**
     * @param Request           $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function handleRequest(Request $request)
    {
        $response = new Response('ok');
        $this->redirectCallbackHelper->redirectCallbacks($request);
        try {
            $message  = $this->twilioCallback->getMessage($request);
            $contacts = $this->twilioCallback->getContacts($request);

            $this->logger->debug(sprintf('SMS REPLY: Processing message "%s"', $message));
            $this->logger->debug(sprintf('SMS REPLY: Found IDs %s', implode(',', $contacts->getKeys())));
            foreach ($contacts as $contact) {
                // Set the contact for campaign decisions
                $this->contactTracker->setSystemContact($contact);

                $eventResponse = $this->dispatchReplyEvent($contact, $message);

                if ($eventResponse instanceof Response) {
                    // Last one wins
                    $response = $eventResponse;
                }
            }
        } catch (BadRequestHttpException $exception) {
            return new Response('invalid request', 400);
        } catch (NotFoundHttpException $exception) {
            return new Response('', 404);
        } catch (NumberNotFoundException $exception) {
            $this->logger->debug(
                sprintf(
                    '%s: %s was not found. The message sent was "%s"',
                    'Twilio',
                    $exception->getNumber(),
                    isset($message) ? $message : 'unknown'
                )
            );
        }

        return $response;
    }

    /**
     * @param Lead   $contact
     * @param string $message
     *
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    private function dispatchReplyEvent(Lead $contact, $message)
    {
        $replyEvent = new ReplyEvent($contact, trim($message));

        $this->eventDispatcher->dispatch(TwilioFeedbackEvents::ON_REPLY, $replyEvent);

        return $replyEvent->getResponse();
    }
}
