<?php

final class appTest extends \PHPUnit\Framework\TestCase {
    public function test_benchmarking(){
        for ($i = 0; $i < 1000; $i++) {
          $this->assertEquals($i, $i);
        }
    }
}