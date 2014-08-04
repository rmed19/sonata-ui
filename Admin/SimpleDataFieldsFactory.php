<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Admin;

/**
 * Description of SimpleDataFieldsFactory
 *
 * @author jmpantoja
 */
class SimpleDataFieldsFactory {
    public function get($name){
        
        $className = sprintf("%s\SimpleData\%s", __NAMESPACE__, ucfirst($name));
        if(class_exists($className)){
            return new $className();
        }
        else{
             throw new \Exception("Unable to load $className.");
        }
    }
}
