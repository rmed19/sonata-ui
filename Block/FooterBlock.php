<?php

namespace Mojo\Sonata\UIBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of HeaderBlockService
 *
 * @author pato
 */
class FooterBlock extends BaseBlockService {

    private $template;

    /**
     * Constructor
     * 
     * @param type $name
     * @param EngineInterface $templating
     * @param string $template
     */
    public function __construct($name, EngineInterface $templating, $template) {
        parent::__construct($name, $templating);
        $this->setTemplate($template);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        return $this->renderResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $blockContext->getSettings()
                        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('template', null, array()),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Footer';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'template' => $this->getTemplate()
        ));
    }

    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

}
