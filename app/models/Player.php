<?php

/**
 * Handles the parsing of varvee data to create a Player object
 * with game performance history
 */
class Player extends VarveeData {

  // base url for scraping data
  const BASE_URL = 'http://www.varvee.com/team/player/';
  // css class for object containing the player's name
  const PLAYER_NAME_CLASS = 'profile-name';

  protected $data = array();

  /**
   * Constructs a player object including name and past games
   * @param int $team Team identifier
   * @param int $player Player identifier
   */
  public function __construct( $team, $player )
  {
    $url = self::BASE_URL . $team . '/' . $player;
    $dom = new DOMDocument();
    @$dom->loadHTML( $this->scrapeHtml( $url ) );

    $this->data['name'] = $this->getPlayerName( $dom );

    $nodes = $this->getTabularNodes( $dom );

    $game = 1;
    foreach( $nodes as $node )
    {
      $this->data['games'][] = array(
        'game' => (int)$game,
        'opponent' => $this->cleanupSchoolName( $node->childNodes->item(1)->nodeValue ),
        'gameWon' => $this->getWasGameWon( $node->childNodes->item(2)->nodeValue ),
        'teamPoints' => (int)$this->getPointsFor( $node->childNodes->item(2)->nodeValue ),
        'playerPoints' => (int)$node->childNodes->item(3)->nodeValue,
      );
      $game++;
    }
  }

  /**
   * Accessor function for player data
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   * Parses a result string to determine if player's team
   * won the game
   * @param string $resultString ex: W54-10
   * @return bool Was game won
   */
  protected function getWasGameWon( $resultString )
  {
    return ( stristr( $resultString, 'w' ) !== false );
  }

  /**
   * Parses a result string and determines the number of points
   * a player's team scored
   * @param string $resultString ex: W54-10
   * @return int Points scored
   */
  protected function getPointsFor( $resultString )
  {
    preg_match_all( '/[0-9]+/', $resultString, $matches );

    $returnIndex = $this->getWasGameWon( $resultString ) ? 0 : 1;
    return $matches[0][$returnIndex];
  }

  /**
   * Cleans up a team name removing home / away information and
   * record information
   * @param string $name School name to parse
   * @return string Parsed name
   */
  protected function cleanupSchoolName( $name )
  {
    $patterns = array(
      '/@/',
      '/\([\d]+-[\d]+\)/',
    );
    return trim( preg_replace( $patterns, '', $name ) );
  }

  /**
   * Gets the player's name from the record page using
   * the css class as an identifier
   * @param object $dom DOMDocument instance
   * @return string Player's name
   */
  protected function getPlayerName( $dom )
  {
    $xpath = new DOMXPath($dom);
    $results = $xpath->query("//*[@class='" . self::PLAYER_NAME_CLASS . "']");
    return trim( $results->item(0)->nodeValue );
  }
}
