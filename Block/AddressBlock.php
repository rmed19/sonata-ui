<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Block;

use Mojo\Sonata\UIBundle\Entity\SimpleDataManagerInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of CarouselBlock
 *
 * @author jmpantoja
 */
class AddressBlock extends BaseBlockService {

    const DEFAULT_TEMPLATE = 'MojoSonataUIBundle:Block:address_simple.html.twig';

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
        $address = $this->getAddress();


        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings,
                    'address' => $address
        ));
    }

    private function getAddress() {
        $manager = $this->getManager();

        $data = $manager->findOneBy(array('name' => 'address'));
        return $data->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        //'template' => 'MojoSonataUIBundle:Block:carousel.html.twig',
        $resolver->setDefaults(array(
            'template' => self::DEFAULT_TEMPLATE,
            'address' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Address';
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block) {

//        $template = $block->getSetting('template', self::DEFAULT_TEMPLATE);

        $templates = $this->getTemplates();

        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('template', 'sonata_page_type_choice', array('choices' => $templates))
            )
        ));
    }

    private function getTemplates() {
        $templates = array();
        $finder = new Finder();
        $finder->name('address_*.html.twig')->files()->in(__DIR__ . '/../Resources/views');

        foreach ($finder as $file) {
            $name = $file->getFilename();
            $key = sprintf("MojoSonataUIBundle:Block:%s", $name);

            $templates[$key] = $name;
        }

        return $templates;
    }


    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {

        $errorElement
                ->with('settings[template]')
                ->assertNotBlank()
                ->end();
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(SimpleDataManagerInterface $manager) {
        $this->manager = $manager;
    }

}
