<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;
use \RocketTheme\Toolbox\Event\Event;

use ShortcodeCitation\CitationManager;


class ShortcodeCitationPlugin extends Plugin
{
    protected $citations;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        require_once(__DIR__."/classes/CitationManager.php");

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
     * Register shortcodes
     */
    public function onShortcodeHandlers()
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }

    /**
     * Make the citation manager available via a twig variable
     */
    public function onPageContent()
    {
        $this->grav["twig"]->twig_vars["citations"] = $this->citations;
    }
}
