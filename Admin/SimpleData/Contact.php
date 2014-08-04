<?php

namespace Mojo\Sonata\UIBundle\Admin\SimpleData;

use Mojo\Sonata\UIBundle\Admin\SimpleData\SimpleDataFieldsInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of Address
 *
 * @author jmpantoja
 */
class Contact implements SimpleDataFieldsInterface {

    public function configureFormFields(FormMapper $formMapper) {

        $formMapper
                ->with('Contact')
                ->add('value', 'sonata_type_immutable_array', array(
                    'label' => false,
                    'keys' => array(
                        array('telefono', 'text', array('required' => false, 'label'=> 'Teléfono')),
                        array('email', 'text', array('required' => false)),
                        array('facebook', 'text', array('required' => false)),
                        array('twitter', 'text', array('required' => false)),
                        array('google_plus', 'text', array('required' => false, 'label'=> 'Google +')),
                    )
        ));
    }

}
