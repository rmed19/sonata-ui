<?php

namespace Mojo\Sonata\UIBundle\Admin\SimpleData;

use Mojo\Sonata\UIBundle\Admin\SimpleData\SimpleDataFieldsInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of Address
 *
 * @author jmpantoja
 */
class Address implements SimpleDataFieldsInterface {

    public function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->with('Address')
                ->add('value', 'sonata_type_immutable_array', array(
                    'label' => false,
                    'keys' => array(
                        array('direccion', 'text', array('required' => true)),
                        array('cp', 'text', array('required' => false)),
                        array('ciudad', 'text', array('required' => false)),
                        array('provincia', 'text', array('required' => false)),
                        array('pais', 'text', array('required' => false)),
                    )
        ));
    }

}
