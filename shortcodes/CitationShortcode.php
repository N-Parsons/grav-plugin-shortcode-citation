<?php
namespace Grav\Plugin\Shortcodes;

use Grav\Common\Grav;
use Grav\Common\Plugin;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class CitationShortcode extends Shortcode
{
  public function init()
  {
    $this->shortcode->getHandlers()->add('cite', function(ShortcodeInterface $sc) {
      $citeId = $sc->getParameter('cite', $this->getBbCode($sc));
      if ($citeId) {
        // Get the citation manager
        $citations = $this->grav['citations'];

        // Get the URL and citation number
        $url = $citations->getUrl();
        $citeNum = $citations->getCitationNumber($citeId);

        // Return the citation link
        return '<a class="citation" href="'.$url.'#cite-'.$citeId.'">['.$citeNum.']</a>';
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
