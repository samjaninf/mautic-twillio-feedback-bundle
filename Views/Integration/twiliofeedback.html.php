<?php
/*
 * @copyright   2019 MTCExtendee. All rights reserved

 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>

<div class="row mt-lg">
    <div class="col-xs-12">
        <strong>Twillio callback url</strong>:
        <pre><?php echo $view['router']->generate(
                'mautic_twilio_feedback_reply',
                [
                ],
                true
            ); ?>
        </pre>
    </div>
</div>