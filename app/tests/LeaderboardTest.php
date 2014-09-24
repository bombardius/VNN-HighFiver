<?php

class LeaderboardTest extends TestCase {

	public function testLeaderboardDatamodel()
  {
    $topPlayer = array(
      'name' => 'Devone, Daniels',
      'url' => URL::to('/') . '/player/27/71326'
    );

    $crawler = $this->client->request('GET', '/2014');
		$this->assertTrue($this->client->getResponse()->isOk());
    $this->assertCount(1, $crawler->filter('h1:contains("Top 5 Players")'), 'Page heading incorrect' );
    $this->assertCount(5, $crawler->filter('li'), 'Top 5 player count incorrect for 2014' );

    $this->assertEquals( $topPlayer['name'], $crawler->filter('li > a')->text(), 'Top player name incorrect for 2014' );

    $this->assertEquals( $topPlayer['url'], $crawler->filter('li > a')->attr( 'href' ), 'Top player url incorrect for 2014' );

	}

}
