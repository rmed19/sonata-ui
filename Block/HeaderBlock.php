<?php

namespace Mojo\Sonata\UIBundle\Block;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
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
class HeaderBlock extends BaseBlockService {

    private $template;

    
    /**
     * Constructor
     * 
     * @param type $name
     * @param \Symfony\Component\Templating\EngineInterface $templating
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

        $settings = $blockContext->getSettings();

        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'template' => $this->getTemplate(),
            'menu_name' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Header';
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block) {
        $form->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('menu_name', 'text', array('required' => false, 'data' => 'asdad')),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        
    }

    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

}
