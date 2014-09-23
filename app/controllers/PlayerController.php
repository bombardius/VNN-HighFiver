<?php

class PlayerController extends BaseController {

  const BASE_URL = 'http://www.varvee.com/team/player/';
  const PLAYER_NAME_CLASS = 'profile-name';

	public function showPlayer( $team, $player )
	{
    $url = self::BASE_URL . $team . '/' . $player;
    
    $dom = new DOMDocument();
    @$dom->loadHTML( $this->scrapeHtml( $url ) );

    $data = array();
    $xpath = new DOMXPath($dom);
    $results = $xpath->query("//*[@class='" . self::PLAYER_NAME_CLASS . "']");
    $data['name'] = trim( $results->item(0)->nodeValue );

    $nodes = $dom->getElementsByTagName( 'tr' );

    $game = 1;
    foreach( $nodes as $node )
    {
      $class = $node->getAttribute( 'class' );
      if( $class == 'odd' || $class == 'even' )
      {
        $data['games'][] = array(
          'game' => (int)$game,
          'opponent' => $this->cleanupName( $node->childNodes->item(1)->nodeValue ),
          'gameWon' => $this->getWasGameWon( $node->childNodes->item(2)->nodeValue ),
          'teamPoints' => (int)$this->getPointsFor( $node->childNodes->item(2)->nodeValue ),
          'playerPoints' => (int)$node->childNodes->item(3)->nodeValue,
        );
        $game++;
      }
    }
    return View::make( 'player', array( 'data' => $data ) );
  }

  protected function getWasGameWon( $resultString )
  {
    return ( stristr( $resultString, 'w' ) !== false );
  }

  protected function getPointsFor( $resultString )
  {
    preg_match_all( '/[0-9]+/', $resultString, $matches );

    $returnIndex = $this->getWasGameWon( $resultString ) ? 0 : 1;
    return $matches[0][$returnIndex];
  }

  protected function cleanupName( $name )
  {
    $patterns = array(
      '/@/',
      '/\([\d]+-[\d]+\)/',
    );
    return trim( preg_replace( $patterns, '', $name ) );
  }


}
