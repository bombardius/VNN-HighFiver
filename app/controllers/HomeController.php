<?php

class HomeController extends BaseController {

  const LEAGUE_IDENTIFIER = '54/27';

	public function showWelcome()
	{

    $year = '2014';

    $url = 'http://www.varvee.com/team/individual_leaderboard/' . self::LEAGUE_IDENTIFIER . '/school-year:' . $year . '/sort:PointsPerGame/direction:desc';

    $players = array();

    $dom = new DOMDocument();
    @$dom->loadHTML( $this->scrapeHtml( $url ) );

    $currentRank = 1;
    $nodes = $dom->getElementsByTagName( 'tr' );
    foreach( $nodes as $node )
    {
      $class = $node->getAttribute( 'class' );
      if( $class == 'odd' || $class == 'even' )
      {
        $players[] = array(
          //'rank' => $currentRank,
          'name' => $node->childNodes->item(3)->childNodes->item(0)->nodeValue,
          'link' => $this->cleanupLink( $node->childNodes->item(3)->childNodes->item(0)->getAttribute( 'href' ) ),
          //'pointAverage' => $node->childNodes->item(7)->nodeValue,
        );
        $currentRank++;
        if( $currentRank > 5 )
        {
          break;
        }

      }
    }

    return View::make( 'welcome', array( 'players' => $players ) );
  }

  protected function cleanupLink( $link )
  {
    preg_match( '|[\d]+/[\d]+|', $link, $matches );
    return URL::route( 'player', array( $matches[0] ) );
  }

}
