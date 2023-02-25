<?php
use PHPUnit\Framework\TestCase;

final class ExportTest extends TestCase
{
    protected $db;

    public function setUp(): void
    {
        $this->db = new MySQL(true,"testdb","127.0.0.1","root","root");
    }
    
    public function testGetJson()
    {
        # 1
        $this->db->Query("SELECT * FROM test_table WHERE id=1");
        $expected = '[{"id":"1","name":"John","date":"2022-01-01","value":"Red"}]';

        $actual = $this->db->GetJSON();

        $this->assertJsonStringEqualsJsonString($expected, $actual);
        
        # 2
        $this->db->Release();
        $actual = $this->db->GetJSON();
        $this->assertStringContainsStringIgnoringCase("null", $actual);          
    }
    
    public function testGetXml()
    {
        # 1
        $this->db->Query("SELECT * FROM test_table WHERE id=1");
        $expected = '<?xml version="1.0"?><root rows="1" query="SELECT * FROM test_table WHERE id=1" error=""><row index="1"><id>1</id><name>John</name><date>2022-01-01</date><value>Red</value></row></root>';

        $actual = $this->db->GetXML();

        $this->assertXmlStringEqualsXmlString($expected, $actual);
        
        
        # 2
        $this->db->Release();
        $actual = $this->db->GetXML();
        $this->assertStringContainsStringIgnoringCase("No query has been executed.", $actual);
        
        
        # 3
        $this->db->Release();
        $this->db->Query("SELECT * FROM invalid_table WHERE id=1");
        $actual = $this->db->GetXML();
        $this->assertStringContainsStringIgnoringCase("Table 'testdb.invalid_table' doesn't exist", $actual);        
    }    
       
    public function testGetHtml()
    {
        # 1
        $this->db->Query("SELECT * FROM test_table WHERE id=1");

        $actual = $this->db->GetHTML();

        $this->assertStringContainsStringIgnoringCase("Record count:", $actual);
        $this->assertStringContainsStringIgnoringCase("<table", $actual);
        $this->assertStringContainsStringIgnoringCase("<tr", $actual);
        $this->assertStringContainsStringIgnoringCase("<td", $actual);
        
        
        # 2
        $actual = $this->db->GetHTML(false, "style1", "style2", "style3");

        $this->assertStringNotContainsStringIgnoringCase("Record count:", $actual);
        $this->assertStringContainsStringIgnoringCase("style=\"style1\"", $actual);
        $this->assertStringContainsStringIgnoringCase("style=\"style2\"", $actual);
        $this->assertStringContainsStringIgnoringCase("style=\"style3\"", $actual);    
        
        
        # 3
        $this->db->Query("SELECT * FROM `test_table` WHERE id=123");
        $actual = $this->db->GetHTML();        
        $this->assertStringContainsStringIgnoringCase("No records were returned.", $actual);
        
        
        # 4
        $this->db->Release();
        $actual = $this->db->GetHTML();        
        $this->assertFalse($actual);        
    }        
       
}
