<?php

/**
 * Base class to handle some of the common data parsing funcionality
 */
class VarveeData {

  /**
   * Gets the rows of tabular data from the varvee site
   * Rows can be easily identified by 'odd' and 'even'
   * css classes
   * @param object $dom DOMDocument
   * @param int $limit Number of rows to return with a max of 10
   * @return array Array of DOM nodes
   */
  protected function getTabularNodes( $dom, $limit = null )
  {
    $iteration = 1;
    $nodes = $dom->getElementsByTagName( 'tr' );
    $returnNodes = array();
    foreach( $nodes as $node )
    {
      $class = $node->getAttribute( 'class' );
      if( $class == 'odd' || $class == 'even' )
      {
        $returnNodes[] = $node;
        $iteration++;
        if( $limit !== null && $iteration > $limit )
        {
          break;
        }
      }
    }
    return $returnNodes;
  }

  /**
   * Performs an HTTP GET of a given url and returns the content
   * @param string $url URL to fetch
   * @return string Contents of URL
   */
  protected function scrapeHtml( $url )
  {
    Debugbar::startMeasure('curl','Time for curl call');
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    $output = curl_exec( $curl );
    curl_close( $curl );
    Debugbar::stopMeasure('curl');
    return $output;
  }
}
