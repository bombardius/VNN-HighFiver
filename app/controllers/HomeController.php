<?php

/**
 * Controller for requests to the base URL
 * Only handles GET at the moment for initial
 * leaderboard display
 */
class HomeController extends BaseController {

  // Indiana Mens Basketball identifier from product spec
  const LEAGUE_IDENTIFIER = '54/27';

  /**
   * Handles request for welcome page
   * @param int $year Year to display, defaults to 2013-2014 season
   * @return View
   */
	public function showWelcome( $year = 2014 )
	{
    $leaderboard = new Leaderboard( self::LEAGUE_IDENTIFIER, $year );
    return View::make( 'welcome', array( 'players' => $leaderboard->getPlayers() ) );
  }

}
