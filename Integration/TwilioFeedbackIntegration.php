<?php

/*
 * @copyright   2019 MTCExtendee. All rights reserved
 * @author      MTCExtendee
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTwilioFeedbackBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;

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
     * @param \Mautic\PluginBundle\Integration\Form|FormBuilder $builder
     * @param array                                             $data
     * @param string                                            $formArea
     */
    public function appendToForm(&$builder, $data, $formArea)
    {
        if ($formArea == 'features') {

            $builder->add(
                'redirectCallbacks',
                TextareaType::class,
                [
                    'label'      => 'mautic.twillio.feedback.redirect.callback',
                    'label_attr' => ['class' => 'control-label'],
                    'attr'       => [
                        'class'        => 'form-control',
                        'tooltip'        => 'mautic.twillio.feedback.redirect.callback.tooltip',
                        'rows' => 5
                    ],
                    'required'=>false,
                ]
            );

        }
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
