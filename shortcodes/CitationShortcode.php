<?php
namespace Grav\Plugin\Shortcodes;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class CitationShortcode extends Shortcode
{
  public function init()
  {
    $this->shortcode->getHandlers()->add('cite', function(ShortcodeInterface $sc) {
      $options = $this->getBbCode($sc);
      $citeId = $sc->getParameter('cite', $options);
      if (isset($citeId)) {
        $citeNum = $this->grav['citations']->getCitationNumber($citeId);
        return '<a class="citation" href="#cite-'.$citeId.'">['.$citeNum.']</a>';
      } else {
        // Determine the boolean value of 'reorder' if set
        $reorder = $sc->getParameter('reorder', $options);
        if (isset($reorder)) {
          // Consider most things to be truthy
          $reorder = !($reorder === "false" || $reorder === "0");
        }

        // Get variables
        $vars = array(
          "page" => $this->grav["page"],
          "citations" => $this->grav['citations']->getCitations(),
          "heading" => $sc->getParameter('heading', $options),
          "items" => $sc->getParameter('items', $options),
          "reorder" => $reorder,
        );

        // Process Twig template
        $refs = $this->grav["twig"]->processTemplate("partials/citations.html.twig", $vars);
 
        // Return (and insert) HTML
        return $refs;
      }
    });
  }
}
