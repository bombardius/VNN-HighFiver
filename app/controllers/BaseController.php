<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
      $this->layout = View::make($this->layout);
    }
  }

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
