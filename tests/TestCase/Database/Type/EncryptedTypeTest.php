<?php
namespace BryanCrowe\Test\TestCase\Database\Type;

use Cake\Database\Type;
use Cake\TestSuite\TestCase;
use PDO;

/**
 * Test for the Encrypted type.
 */
class EncryptedTypeTest extends TestCase
{
    /**
     * Setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->type = Type::build('encrypted');
        $this->driver = $this->getMockBuilder('Cake\Database\Driver')->getMock();
    }

    /**
     * Test toPHP
     *
     * @return void
     */
    public function testToPHP()
    {
        $this->assertNull($this->type->toPHP(null, $this->driver));
        $encryptedText = $this->type->toDatabase('word', $this->driver);
        $this->assertSame('word', $this->type->toPHP($encryptedText, $this->driver));
        $encryptedText = $this->type->toDatabase(2.123, $this->driver);
        $this->assertSame('2.123', $this->type->toPHP($encryptedText, $this->driver));
    }

    /**
     * Test converting to database format
     *
     * @return void
     */
    public function testToDatabase()
    {
        $obj = $this->getMockBuilder('StdClass')
            ->setMethods(['__toString'])
            ->getMock();
        $obj->method('__toString')->will($this->returnValue('toString called'));
        $this->assertNull($this->type->toDatabase(null, $this->driver));
        $this->assertNotEquals('word', $this->type->toDatabase('word', $this->driver));
        $this->assertNotEquals('2.123', $this->type->toDatabase(2.123, $this->driver));
        $this->assertNotEquals('toString called', $this->type->toDatabase($obj, $this->driver));
    }

    /**
     * Tests that passing an invalid value will throw an exception
     *
     * @return void
     */
    public function testToDatabaseInvalidArray()
    {
        $this->expectException('InvalidArgumentException');
        $this->type->toDatabase([1, 2, 3], $this->driver);
    }

    /**
     * Test marshalling
     *
     * @return void
     */
    public function testMarshal()
    {
        $this->assertNull($this->type->marshal(null));
        $this->assertSame('word', $this->type->marshal('word'));
        $this->assertSame('2.123', $this->type->marshal(2.123));
        $this->assertSame('', $this->type->marshal([1, 2, 3]));
    }

    /**
     * Test that the PDO binding type is correct.
     *
     * @return void
     */
    public function testToStatement()
    {
        $this->assertEquals(PDO::PARAM_STR, $this->type->toStatement('', $this->driver));
        $this->assertEquals(PDO::PARAM_NULL, $this->type->toStatement(null, $this->driver));
    }

    /**
     * Test toPHP
     *
     * @return void
     */
    public function testRequiresToPhpCast()
    {
        $this->assertTrue($this->type->requiresToPhpCast());
    }
}
