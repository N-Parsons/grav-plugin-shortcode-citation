<?php
namespace ShortcodeCitation;


class CitationManager
{
  private $citations = [];
  private $url = "";

  /**
   * Returns the number for the citation
   *
   * @return integer
   */
  public function getCitationNumber($citeId)
  {
    if ( isset($this->citations[$citeId]) ) {
      $citeNum = $this->citations[$citeId];
    } else {
      $citeNum = (count($this->citations) + 1);
      $this->citations[$citeId] = $citeNum;
    }

    return $citeNum;
  }

  /**
   * Returns the list of citations
   *
   * @return array
   */
  public function getCitations()
  {
    return array_keys($this->citations);
  }

  /**
   * Set URL to add to anchor links
   */
  public function setUrl($url)
  {
    $this->url = $url;
  }

  /**
   * Get URL to add to anchor links
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Reset method for use in blog listings
   */
  public function reset()
  {
    $this->citations = [];
    $this->url = "";
  }
}
