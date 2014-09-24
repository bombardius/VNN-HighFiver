<?php

class PlayerTest extends TestCase {

	public function testPlayerDatamodel()
  {
    $testPlayer = array(
      'name' => 'TJ Henderson',
      'url' => URL::to('/') . '/player/27/80318',
    );

    $gameOneData = array(
      'opponent' => 'Indiana Math & Science Academy',
      'playerScore' => 30,
      'teamScore' => 69,
      'gameOutcome' => 'W',
    );

    $gameTwoData = array(
      'opponent' => 'East Central',
      'playerScore' => 0,
      'teamScore' => 42,
      'gameOutcome' => 'L',
    );

    $crawler = $this->client->request('GET', $testPlayer['url'] );
		$this->assertTrue($this->client->getResponse()->isOk());

    $this->assertCount(1, $crawler->filter('h1:contains("' . $testPlayer['name'] . '")'), 'Page heading incorrect' );
    $this->assertCount(6, $crawler->filter('tr'), 'Player game table size incorrect for 2014' );

    // Test data for game one (win)
    $this->assertEquals( $gameOneData['opponent'], $crawler->filter('td')->eq(1)->text(), 'Game one opponent incorrect' );
    $this->assertEquals( $gameOneData['playerScore'], $crawler->filter('td')->eq(2)->text(), 'Game one player score incorrect' );
    $this->assertEquals( $gameOneData['teamScore'], $crawler->filter('td')->eq(3)->text(), 'Game one team score incorrect' );
    $this->assertEquals( $gameOneData['gameOutcome'], $crawler->filter('td')->eq(4)->text(), 'Game one outcome incorrect' );

    // Test data for game two (loss)
    $this->assertEquals( $gameTwoData['opponent'], $crawler->filter('td')->eq(6)->text(), 'Game two opponent incorrect' );
    $this->assertEquals( $gameTwoData['playerScore'], $crawler->filter('td')->eq(7)->text(), 'Game two player score incorrect' );
    $this->assertEquals( $gameTwoData['teamScore'], $crawler->filter('td')->eq(8)->text(), 'Game two team score incorrect' );
    $this->assertEquals( $gameTwoData['gameOutcome'], $crawler->filter('td')->eq(9)->text(), 'Game two outcome incorrect' );

  }

}
