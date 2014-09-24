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
    $iteration = 0;
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
    $curl_handler = curl_init($url);
    curl_setopt($curl_handler, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl_handler, CURLOPT_HEADER, false);
    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec( $curl_handler );
    curl_close( $curl_handler );
    return $output;
  }
}
