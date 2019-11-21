<?php

/*
 * @copyright   2019 Mautic Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://www.mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Controller;


use MauticPlugin\MauticTwilioFeedbackBundle\Helper\ReplyHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{

    /**
     * @var
     */
    private $replyHelper;

    /**
     * ReplyController constructor.
     *
     * @param ReplyHelper $replyHelper
     */
    public function __construct(ReplyHelper $replyHelper)
    {
        $this->replyHelper = $replyHelper;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function callbackAction(Request $request)
    {
        define('MAUTIC_NON_TRACKABLE_REQUEST', 1);
        return $this->replyHelper->handleRequest($request);
    }
}
