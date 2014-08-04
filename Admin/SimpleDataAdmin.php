<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Description of ConfigAdmin
 *
 * @author jmpantoja
 */
class SimpleDataAdmin extends Admin {

    /**
     *
     * @var SimpleDataFieldsFactory
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('name')

        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('name')
        ;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection
                ->remove('create')
                ->remove('delete')
                ->remove('show')
                ->remove('list')
        ;
        //parent::configureRoutes($collection);
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $name = $formMapper->getAdmin()->getSubject()->getName();
        $this->getFactory()->get($name)->configureFormFields($formMapper);
    }

    public function getFactory() {
        return $this->factory;
    }

    public function setFactory(SimpleDataFieldsFactory $factory) {
        $this->factory = $factory;
        return $this;
    }

}
