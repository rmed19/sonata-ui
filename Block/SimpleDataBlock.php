<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Block;

use Mojo\Sonata\UIBundle\Entity\SimpleDataManagerInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of CarouselBlock
 *
 * @author jmpantoja
 */
class SimpleDataBlock extends BaseBlockService {

    const DEFAULT_TEMPLATE = 'MojoSonataUIBundle:SimpleData:admin.html.twig';

    /**
     *
     * @var SimpleDataManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param string               $name        A block name
     * @param EngineInterface      $templating  Twig engine service
     * @param SimpleDataManagerInterface    $manager 
     */
    public function __construct($name, EngineInterface $templating, SimpleDataManagerInterface $manager) {
        parent::__construct($name, $templating);
        $this->setManager($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {

        $settings = $blockContext->getSettings();
        $list = $this->getManager()->findAll();


        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings,
                    'list' => $list
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        //'template' => 'MojoSonataUIBundle:Block:carousel.html.twig',
        $resolver->setDefaults(array(
            'template' => self::DEFAULT_TEMPLATE,
            'post' => null,
            'title'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'SimpleData';
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block) {
        
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(SimpleDataManagerInterface $manager) {
        $this->manager = $manager;
    }

}
