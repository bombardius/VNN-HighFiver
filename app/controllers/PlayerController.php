<?php

/**
 * Controller for requests for a particular player and team
 * scoring history
 */
class PlayerController extends BaseController {

  /**
   * Handles request for player scoring page
   * @param int $team Team identifier
   * @param int $player Player identifier
   * @return View
   */
	public function showPlayer( $team, $player )
	{
    $player = new Player( $team, $player );
    return View::make( 'player', array( 'data' => $player->getData() ) );
  }
}
