<?php

/**
 * Testing harness exposing basic parsing capabilities of
 * the VarveeData class
 */
class VarveeDataTestHarness extends VarveeData {

  public function getTabularNodes( $dom, $limit = null )
  {
    return parent::getTabularNodes( $dom, $limit );
  }

  public function scrapeHtml( $url )
  {
    return parent::scrapeHtml( $url );
  }
}
