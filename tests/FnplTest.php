<?php
use PHPUnit\Framework\TestCase;

class FnplTest extends TestCase
{
    public function testTextIsNotProvided()
    {
        $service = new OccurrenceService();
        $text = '';
        $this->assertFalse($service->checkOccurrence($text, ''));
    }
    
    public function testTextIsInvalid()
    {
        $service = new OccurrenceService();
        $text = '123';
        $this->assertFalse($service->checkOccurrence($text, ''));
    }
    
    public function testCheckCorrectFormatIsProvided()
    {
        $service = new OccurrenceService();
        $text = 'abc';
        $this->assertFalse($service->checkOccurrence($text, 'repeating'));
    }

    public function testAtLeastOneOptionIsProvided()
    {
        $service = new OccurrenceService();
        $text = 'abc';
        $this->assertFalse($service->checkOccurrence($text, 'non-repeating', false, false, false));
    }

    public function testNonRepeatingOccurrence()
    {
        $service = new OccurrenceService();
        $text = 'abc';
        $this->assertTrue($service->checkOccurrence($text, 'non-repeating', true, false, false));
    }

    public function testLeastRepeatingOccurrence()
    {
        $service = new OccurrenceService();
        $text = 'abc';
        $this->assertTrue($service->checkOccurrence($text, 'least-repeating', true, false, false));
    }

    public function testMostRepeatingOccurrence()
    {
        $service = new OccurrenceService();
        $text = 'abc';
        $this->assertTrue($service->checkOccurrence($text, 'most-repeating', true, false, false));
    }
}