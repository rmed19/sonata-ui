<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Entity;

/**
 * Description of ConfigManager
 *
 * @author jmpantoja
 */
interface SimpleDataManagerInterface {

    public function findByKey($key);
}
