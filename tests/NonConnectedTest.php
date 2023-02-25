<?php
use PHPUnit\Framework\TestCase;

final class NonConnectedTest extends TestCase
{
    protected $db;

    public function setUp(): void
    {
        $this->db = new MySQL(false);
    }
    
    public function testDeleteRowsWithoutConnection()
    {
        # 1
        $actual = $this->db->DeleteRows("test_query", array("key"=>MySQL::SQLValue("abc")));

        $this->assertFalse($actual);
    }

    public function testErrorsWithoutConnection()
    {
        # 1
        $this->assertFalse($this->db->Error());
        
        # 2
        $actual = $this->db->ErrorNumber();

        $this->assertFalse($actual);        
    }    
    
    public function testRowCountWithoutConnection()
    {
        $actual = $this->db->RowCount();
        $this->assertFalse($actual);
    }
    
    public function testSelectRowsWithoutConnection()
    {
        $actual = $this->db->SelectRows("test_query");
        $this->assertFalse($actual);
    }  
    
    public function testTransactionBeginWithoutConnection()
    {
        $actual = $this->db->TransactionBegin();
        $this->assertFalse($actual);
    }  
    
    public function testTransactionEndWithoutConnection()
    {
        $actual = $this->db->TransactionEnd();
        $this->assertFalse($actual);
    }  
    
    public function testTransactionRollbackWithoutConnection()
    {
        $actual = $this->db->TransactionRollback();
        $this->assertFalse($actual);
    }  
    
    public function testTruncateTableWithoutConnection()
    {
        $actual = $this->db->TruncateTable("test_query");
        $this->assertFalse($actual);
    }  

    public function testUpdateRowsWithoutConnection()
    {
        $actual = $this->db->UpdateRows("test_query",array());
        $this->assertFalse($actual);
    }      
}
