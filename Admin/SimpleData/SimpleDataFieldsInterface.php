<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Admin\SimpleData;

use Sonata\AdminBundle\Form\FormMapper;

/**
 *
 * @author pato
 */
interface SimpleDataFieldsInterface {

    public function configureFormFields(FormMapper $formMapper);
}
