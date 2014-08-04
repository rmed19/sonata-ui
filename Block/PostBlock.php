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
use Sonata\NewsBundle\Model\PostManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of CarouselBlock
 *
 * @author jmpantoja
 */
class PostBlock extends BaseBlockService {

    const DEFAULT_TEMPLATE = 'MojoSonataUIBundle:Block:post_2columns.html.twig';

    /**
     *
     * @var PostManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param string               $name        A block name
     * @param EngineInterface      $templating  Twig engine service
     * @param PostManagerInterface    $manager 
     */
    public function __construct($name, EngineInterface $templating, PostManagerInterface $manager) {
        parent::__construct($name, $templating);
        $this->setManager($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {

        $settings = $blockContext->getSettings();
        $post = $this->getPost($settings['post']);

        
        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings,
                    'post' => $post
        ));
    }

    private function getPost($id) {
        $manager = $this->getManager();

        $post = $manager->findOneBy(array('id' => $id));

        return $post;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        //'template' => 'MojoSonataUIBundle:Block:carousel.html.twig',
        $resolver->setDefaults(array(
            'template' => self::DEFAULT_TEMPLATE,
            'post' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Noticia';
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block) {

//        $template = $block->getSetting('template', self::DEFAULT_TEMPLATE);

        $posts = $this->getPosts();
        $templates = $this->getTemplates();

        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
//                array('template', 'text', array('required' => true, 'data' => $template)),
                array('template', 'sonata_page_type_choice', array('choices' => $templates)),
                array('post', 'sonata_page_type_choice', array('choices' => $posts))
            )
        ));
    }

    private function getTemplates() {
        $templates = array();
        $finder = new Finder();
        $finder->name('post_*.html.twig')->files()->in(__DIR__.'/../Resources/views');

        foreach ($finder as $file) {
            $name = $file->getFilename();
            $key = sprintf("MojoSonataUIBundle:Block:%s", $name);
            
            $templates[$key] = $name;
        }

        return $templates;
    }

    private function getPosts() {
        $posts = array();
        $manager = $this->getManager();
        foreach ($manager->findAll() as $post) {
            $posts[$post->getId()] = (string) $post;
        }

        return $posts;
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

    public function setManager(PostManagerInterface $manager) {
        $this->manager = $manager;
    }

}
