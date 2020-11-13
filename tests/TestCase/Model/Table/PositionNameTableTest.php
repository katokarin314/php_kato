<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PositionNameTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PositionNameTable Test Case
 */
class PositionNameTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PositionNameTable
     */
    public $PositionName;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PositionName',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PositionName') ? [] : ['className' => PositionNameTable::class];
        $this->PositionName = TableRegistry::getTableLocator()->get('PositionName', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PositionName);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
