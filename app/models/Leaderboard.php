<?php

/**
 * Handles the parsing of varvee data to create a leaderboard
 */
class Leaderboard extends VarveeData {

  // Number of players eligible for the leaderboard
  const PLAYER_LIMIT = 5;

  // player data array
  protected $players = array();

  /**
   * constructs a leaderboard object including a player array
   * @param string $league League identifier in a |[\d]+/[\d]| format
   * @param int $year Year of the leaderboard
   */
  public function __construct( $league, $year )
  {

    $url = 'http://www.varvee.com/team/individual_leaderboard/' . $league . '/school-year:' . $year . '/sort:PointsPerGame/direction:desc';

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML( $this->scrapeHtml( $url ) );

    $nodes = $this->getTabularNodes( $dom, self::PLAYER_LIMIT );

    foreach( $nodes as $node )
    {
      $this->players[] = array(
        'name' => $node->childNodes->item(3)->childNodes->item(0)->nodeValue,
        'link' => $this->cleanupLink( $node->childNodes->item(3)->childNodes->item(0)->getAttribute( 'href' ) ),
      );
    }
  }

  /**
   * Accessor function for player data
   * @return array Player name and link
   */
  public function getPlayers()
  {
    return $this->players;
  }

  /**
   * Grabs the league and player identifiers from the varvee player link
   * @param string $link Player link to parse
   * @return string Player link
   */ 
  protected function cleanupLink( $link )
  {
    preg_match( '|[\d]+/[\d]+|', $link, $matches );
    return URL::route( 'player', array( $matches[0] ) );
  }
}
