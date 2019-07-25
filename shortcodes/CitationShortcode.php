<?php
namespace Grav\Plugin\Shortcodes;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class CitationShortcode extends Shortcode
{
  public function init()
  {
    $this->shortcode->getHandlers()->add('cite', function(ShortcodeInterface $sc) {
      $citeId = $sc->getParameter('cite', $this->getBbCode($sc));
      if ($citeId) {
        $citeNum = $this->grav['citations']->getCitationNumber($citeId);
        return '<a class="citation" href="#cite-'.$citeId.'">['.$citeNum.']</a>';
      } else {
        // Get variables
        $vars = array(
          "page" => $this->grav["page"],
          "citations" => $this->grav['citations']->getCitations(),
          "heading" => $sc->getParameter('heading', $this->getBbCode($sc)),
        );

        // Process Twig template
        $refs = $this->grav["twig"]->processTemplate("partials/citations.html.twig", $vars);
 
        // Return (and insert) HTML
        return $refs;
      }
    });
  }
}
