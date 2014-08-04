<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\MediaBundle\Model\GalleryManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of CarouselBlock
 *
 * @author jmpantoja
 */
class CarouselBlock extends BaseBlockService {

    const DEFAULT_TEMPLATE = 'MojoSonataUIBundle:Carousel:simple.html.twig';
    
    /**
     *
     * @var GalleryManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param string               $name        A block name
     * @param EngineInterface      $templating  Twig engine service
     * @param GalleryManagerInterface    $manager  
     */
    public function __construct($name, EngineInterface $templating, GalleryManagerInterface $manager) {
        parent::__construct($name, $templating);
        $this->setManager($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {

        $settings = $blockContext->getSettings();
        $this->addIdToSettings($settings);

        $items = $this->getItems($settings['gallery']);
        
        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings,
                    'items' => $items,
                    'empty' => empty($items)
        ));
    }

    private function addIdToSettings(array &$settings) {

        if (empty($settings['id'])) {
            $settings['id'] = uniqid('carousel-');
        }
    }

    private function getItems($id) {
        $items = array();
        $manager = $this->getManager();

        $gallery = $manager->findOneBy(array('id' => $id));

        if (!is_null($gallery)) {
            $items = $gallery->getGalleryHasMedias()->toArray();
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        //'template' => 'MojoSonataUIBundle:Block:carousel.html.twig',
        $resolver->setDefaults(array(
            'template' => self::DEFAULT_TEMPLATE,
            'id' => null,
            'gallery' => null,
            'format' => null,
            'interval' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Carousel';
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block) {

        $templates = $this->getTemplates();
        $interval = $block->getSetting('interval', 2000);
        
        $galleries = $this->getGalleries();

        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('template', 'sonata_page_type_choice', array('choices' => $templates)),
                array('id', 'text', array('required' => false)),
                array('gallery', 'choice', array('choices' => $galleries)),
                array('format', 'text', array('required' => true)),
                array('interval', 'integer', array('required' => true, 'data'=>$interval)),
            )
        ));
    }
    
    private function getTemplates() {
        $templates = array();
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../Resources/views/Carousel');

        foreach ($finder as $file) {
            $name = $file->getFilename();
            $key = sprintf("MojoSonataUIBundle:Carousel:%s", $name);
            
            $templates[$key] = $name;
        }

        return $templates;
    }    

    private function getGalleries() {
        $galleries = array();
        $manager = $this->getManager();
        foreach ($manager->findAll() as $gallery) {
            $galleries[$gallery->getId()] = (string) $gallery;
        }

        return $galleries;
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {

        $errorElement
                ->with('settings[format]')
//                ->assertNotNull(array())
                ->assertNotBlank()
                ->end();
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(GalleryManagerInterface $manager) {
        $this->manager = $manager;
    }

}
