<?php namespace Aprillins\LiteGrabber\Classes;

use DOMNodeList;

class ResultProcessor
{
    /**
     * Storing result of DOMNodeList object in this $result variable
     *
     * @var object DOMNodeList
     */
    private $result;

    /**
     * Storing number of result from DOMNodeList object
     *
     * @var int
     */
    private $length = 0;

    /**
     * Storing nodeValue extracted from DOMNodeList object
     *
     * @var array
     */
    private $nodeValue = array();

    public function __construct(DOMNodeList $result)
    { 
        $this->result = $result;
        $this->length = $result->length;
    }

    public function process()
    {
        if ($this->length == 0)
            return false;
        
        for ($i = 0; $i < $this->length; $i++) {
            $this->nodeValue[] = $this->result->item($i)->nodeValue;
        }
        return true;
    }

    public function getNodeValue()
    {
        return $this->nodeValue;
    }
}