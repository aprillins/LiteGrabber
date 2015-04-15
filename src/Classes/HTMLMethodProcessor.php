<?php namespace Aprillins\LiteGrabber\Classes;

use Aprillins\LiteGrabber\LiteGrabber;
use Aprillins\LiteGrabber\Classes\ProcessorArguments;

/**
 * This class searches target method if available and processes it in order
 * to get the proper XPath query string.
 *
 */
class HTMLMethodProcessor
{
    /**
     * This build query for XPath attribute.
     *
     * @param array $args
     * @return string
     */
    public function htmlTagsProcessor($args = array())
    { 
        if (!empty($args[0])) {
            $query = '[@'.key($args[0]).'="'.current($args[0]).'"]';
        } else {
            return;
        }

        return $query;
    }

    /**
     * Method processor for HTML tags.
     *
     * @param string $method
     * @param array $args
     * @return object
     */
    // public function methodProcessor($method, $args)
    public function process(ProcessorArguments $pa)
    {   
        $query = $this->htmlTagsProcessor($pa->getArgs());
        
        if (!empty($args[1]) && $args[1] == true) {
            $this->query .= '//'.$pa->getMethod().$pa->getQuery();
        } else {
            $this->query .= '/'.$pa->getMethod().$pa->getQuery();
        }
        $pa->setArgs($this->query);

        //return $this;
    }   
    
    /**
     * Method processor for HTML attributes.
     *
     * @param string $method
     * @param array $args
     * @return object
     */
    public function atMethodProcessor($method, $args)
    {
        $query = $this->htmlTagsProcessor($args);
        $method = S::removeLeft($method, 'at');
        $method = S::toLowerCase($method);
        if (!empty($args[1]) && $args[1] == true) {
            $this->query .= '//@'.$method.$query;
        } else {
            $this->query .= '/@'.$method.$query;
        }
        return $this;
    }

    /**
     * Get default query string from $query variable.
     *
     * @return string
     */
    public function getQuery()
    {     
        return $this->query;
    }
}