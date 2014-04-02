<?php

namespace li3_queue\tests\cases\storage;

use li3_queue\storage\Queue;

class QueueTest extends \lithium\test\Unit {

	protected $_configurations = null;

	protected $_testConfigs = array(
		'default' => array(
			'adapter' => 'li3_queue\tests\mocks\extensions\adapter\queue\MockQueue'
		)
	);

	public function setUp() {
		$this->_configurations = Queue::config();
		Queue::config($this->_testConfigs);
	}

	public function tearDown() {
		Queue::reset();
		Queue::config($this->_configurations);
	}

	public function testConfiguration() {
		$this->assertNull(Queue::config('no-config'));

		$expected = array(
			'adapter' => 'li3_queue\tests\mocks\extensions\adapter\queue\MockQueue',
			'filters' => array()
		);
		$result = Queue::config('default');
		$this->assertEqual($expected, $result);
	}

	public function testAdd() {
		$this->assertTrue(Queue::add('test'));
		$this->assertTrue(Queue::add('test', array('payload' => '{}')));
	}

	public function testRun() {
		$this->assertTrue(Queue::add('test'));

		$expected = 'Success';
		$result = Queue::run();
		$this->assertEqual($expected, $result);
		$this->assertFalse(Queue::run());
	}
}

?>