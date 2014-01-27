<?php
namespace LeagueWrap;

interface LimitInterface {

	public function setRate($hits, $seconds);

	public function hit($count = 1);

	public function remaining();
}
