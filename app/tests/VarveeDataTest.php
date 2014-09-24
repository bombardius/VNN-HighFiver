<?php

class VarveeDataTest extends TestCase {

	public function testVarveeCurl()
  {
    $url = 'http://www.varvee.com/team/individual_leaderboard/54/27/school-year:2014/sort:PointsPerGame/direction:desc';

    // Ensure we're able to scrape data from varvee.com using the above url
    $dom = new DomDocument();
    $varveeData = new VarveeDataTestHarness();
    $scrapedPage = $varveeData->scrapeHtml( $url );

    $this->assertTrue( strlen( $scrapedPage ) > 0, 'Failed to get page content from varvee.com' );

    // Test that the page is returning some tabular data...tests further up
    // will confirm whether or not the data is valid

    libxml_use_internal_errors(true);
    $dom->loadHTML( $scrapedPage );

    $tabularNodes = $varveeData->getTabularNodes( $dom );

    $this->assertGreaterThan( 0, count( $tabularNodes ), 'Failed to get tabular data' );

  }
}
