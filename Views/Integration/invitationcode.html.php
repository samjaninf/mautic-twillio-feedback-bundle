<?php
/*
 * @copyright   2019 MTCExtendee. All rights reserved

 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$containerType = (isset($type)) ? $type : 'text';
$defaultInputClass = (isset($inputClass)) ? $inputClass : 'input';
include __DIR__.'/../../../../app/bundles/FormBundle/Views/Field/field_helper.php';
$hide = isset($field['customParameters']['builderOptions']['hide']) ? $field['customParameters']['builderOptions']['hide'] : false;
$formName = !empty($formName) ? $formName : '';
$input = $view->render(
    'MauticFormBundle:Field:text.html.php',
    [
        'field'      => $field,
        'inForm'     => (isset($inForm)) ? $inForm : false,
        'type'       => 'text',
        'id'         => $id,
        'formId'     => (isset($formId)) ? $formId : 'preview',
        'formName'   => (isset($formName)) ? $formName : '',
        'inputClass' => 'input',
    ]
);
if ($hide) {
    echo '<div style="display:none">';
}

echo str_replace('value=""', 'value="'.$hide.'"', $input);
if ($hide) {
    echo '</div>';
}
$realFormName = ltrim($formName, '_');
$formDomId    = 'mauticform'.$formName;
$fieldDomId   = 'mauticform'.$formName.'_'.$field['alias'];

if(!$inBuilder && !$hide) {
    echo <<<HTML
<script async defer src="{$view['router']->generate(
        'mautic_twillio_feedback_validation',
        [
            'formName'   => $formName,
            'fieldAlias' => $field['alias']
        ],
        true
    )}"></script>
HTML;
}
if(!$hide):
?>
<style>
#<?php echo $formDomId ?> .mauticform-row { display:none }
#<?php echo $formDomId ?> #<?php echo $fieldDomId ?>, #<?php echo $formDomId ?>  .mauticform-button-wrapper { display:block;  }
</style>
<?php
endif;