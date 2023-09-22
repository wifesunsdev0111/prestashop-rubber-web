<?php

class ProductController extends ProductControllerCore
{
    /** @var array Array of id_attributes that need to be displayed as images on product page */
    const IMAGE_ATTRIBUTES = array(14);

    protected function assignAttributesGroups()
    {
        parent::assignAttributesGroups();

        $attribute_images = array();

        // Get existing smarty variable
        $combinations = $this->context->smarty->getVariable('combinations');

        // Assign image per attribute
        if ($combinations && $combinations->value) {
            foreach ($combinations->value as $combination) {
                foreach ($combination['attributes'] as $id_attribute) {
                    $attribute = new Attribute($id_attribute);
                    if (in_array($attribute->id_attribute_group, self::IMAGE_ATTRIBUTES)) {
                        $attribute_images[$attribute->id_attribute_group][$id_attribute] = $combination['id_image'];
                    }
                }
            }
        }

        $this->context->smarty->assign(array(
            'attribute_images' => $attribute_images,
        ));
    }
}
