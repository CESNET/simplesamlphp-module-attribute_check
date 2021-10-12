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
$attributes = $this->data['attributes'];
$attributesGroupConfiguration = $this->data['attributes_group_config'];


$this->data['header'] = '';
$this->data['head'] = '<link rel="stylesheet" media="screen" type="text/css" href="' .
    Module::getModuleUrl('attribute_check/res/bootstrap/css/bootstrap.css') . '" />';
$this->data['head'] .= '<link rel="stylesheet" media="screen" type="text/css" href="' .
    Module::getModuleUrl('attribute_check/res/css/attribute_check.css') . '" />';
$this->data['head'] .= '<script src="' . Module::getModuleUrl(
    'attribute_check/res/bootstrap/js/bootstrap.js'
) . '" ></script>';

$this->includeAtTemplateBase('includes/header.php');

foreach ($attributesGroupConfiguration as $group) {
    echo AttributeCheck::handleAttributesGroup($this, $group, $attributes);
}

?>
    <div>
        <button class="btn btn-primary btn-show-hide" type="button" data-bs-toggle="collapse" data-bs-target="#all_attributes" aria-expanded="false" aria-controls="all_attributes">
            <?php
            echo $this->t('{attribute_check:attribute_check:show_hide_btn}');
            ?>
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

$this->includeAtTemplateBase('includes/footer.php');
