<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;
use \RocketTheme\Toolbox\Event\Event;

class ShortcodeCitationPlugin extends Plugin
{
    protected $citations;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onGetPageBlueprints' => ['onGetPageBlueprints', 0],
            'onPageContent' => ['onPageContent', 0],
        ];
    }

    /**
     * Initialise citation manager
     */
    public function onPluginsInitialized()
    {
        $this->grav['citations'] = $this->citations = new CitationManager();
    }

    /**
     * Add templates to twig lookup paths
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__.'/templates';
    }

    /**
     * Add blueprints
     */
    public function onGetPageBlueprints(Event $event)
    {
        $event->types->scanBlueprints(__DIR__.'/blueprints');
    }

    /**
     * Initialize configuration
     */
    public function onShortcodeHandlers()
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }

    /**
     * Add the citations as a twig variable
     * (once citations have been collected)
     */
    public function onPageContent()
    {
        $this->grav["twig"]->twig_vars["citations"] = $this->citations->getCitations();
    }
}


class CitationManager
{
    private $citations;

    public function __construct()
    {
        $this->citations = [];
    }

    public function getCitationNumber($citeId)
    {
        
        if ( in_array($citeId, $this->citations) ) {
            $citeNum = array_search($citeId, $this->citations) + 1;
        } else {
            array_push($this->citations, $citeId);
            $citeNum = count($this->citations);
        }
        
        return $citeNum;
    }

    public function getCitations()
    {
        return $this->citations;
    }
}
