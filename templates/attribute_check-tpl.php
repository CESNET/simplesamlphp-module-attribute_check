<?php declare(strict_types=1);

use SimpleSAML\Module;
use SimpleSAML\Module\attribute_check\AttributeCheck;

/**
 * This is simple example of template where user has to accept usage policy
 *
 * Allow type hinting in IDE
 *
 * @var SimpleSAML\XHTML\Template $this
 */

$attributesGroupConfiguration = $this->data['attributes_group_config'];
$as = $this->data['as'];

$this->data['header'] = '';
$this->data['head'] = '<link rel="stylesheet" media="screen" type="text/css" href="' .
    Module::getModuleUrl('attribute_check/res/bootstrap/css/bootstrap.css') . '" />';
$this->data['head'] .= '<link rel="stylesheet" media="screen" type="text/css" href="' .
    Module::getModuleUrl('attribute_check/res/css/attribute_check.css') . '" />';
$this->data['head'] .= '<script src="' . Module::getModuleUrl(
    'attribute_check/res/bootstrap/js/bootstrap.js'
) . '" ></script>';

$this->includeAtTemplateBase('includes/header.php');

echo '<h1>' . $this->t('{attribute_check:attribute_check:header}') . '</h1>';

if (! $as->isAuthenticated()) {
    echo "<div class='mt-5'>";
    echo '<div>' . $this->t('{attribute_check:attribute_check:sign_in_text}') . '</div>';
    echo sprintf(
        "<a class='btn btn-primary text-light mt-5' href='%s'>%s</a>",
        $as->getLoginURL(),
        $this->t('{attribute_check:attribute_check:sign_in_btn}')
    );
    echo '</div>';
}

if ($as->isAuthenticated()) {
    $attributes = $as->getAttributes();

    foreach ($attributesGroupConfiguration as $group) {
        echo AttributeCheck::handleAttributesGroup($this, $group, $attributes);
    } ?>
        <div>
            <button aria-controls="all_attributes" aria-expanded="false" class="btn btn-primary btn-show-hide"
                    data-bs-target="#all_attributes" data-bs-toggle="collapse" type="button">
                <?php
                echo $this->t('{attribute_check:attribute_check:show_hide_btn}'); ?>
            </button>
        </div>
    <?php

    echo "<div class='collapse attributes_block' id='all_attributes'>";
    foreach ($attributes as $attributeName => $attributeValue) {
        echo "<div class='row attribute_row'>";
        echo "<div class='col-md-4 attribute_name'>";
        echo '<div>' . $attributeName . '</div>';
        echo '</div>';

        echo "<div class='col-md-8 attribute_value'>";
        if (count($attributeValue) > 1) {
            echo '<ul>';
            foreach ($attributeValue as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        } elseif (count($attributeValue) === 1) {
            echo '<div>' . $attributeValue[0] . '</div>';
        } else {
            echo '<div></div>';
        }

        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

if ($as->isAuthenticated()) {
    echo sprintf(
        "<a class='btn btn-light text-dark' href='%s'>%s</a>",
        $as->getLogoutURL(),
        $this->t('{attribute_check:attribute_check:log_out_btn}')
    );
}

$this->includeAtTemplateBase('includes/footer.php');
