<?php namespace Aprillins\LiteGrabber;

use Aprillins\LiteGrabber\Interfaces\HtmlTag;
use Aprillins\LiteGrabber\Classes\HTMLTagsMethod;
use Aprillins\LiteGrabber\Classes\HTMLAttributesMethod;
use Aprillins\LiteGrabber\Classes\HTMLMethodProcessor;
use Aprillins\LiteGrabber\Classes\ProcessorArguments;
use Aprillins\LiteGrabber\Classes\LiteGrabberProcessor;

use Stringy\StaticStringy as S;
use DomDocument;
use DOMXPath;
use Exception;

/*
* For xpath syntax go to http://www.w3schools.com/xpath/xpath_syntax.asp
*
*
*/
class LiteGrabber
{
    /**
     * Variable to put all the processed query in.
     *
     * @var string;
     */
    protected $query;

    /**
     * Every website has pages. If you want to grab a page the URL you concern
     * goes on this variable.
     *
     * @var string;
     */
    protected $url;

    /**
     * This is alphabetical list of some attribute often used in HTML
     *
     * @var array
     */
    protected $htmlattributes = [
        'alt', 'disabled', 'href', 'id', 'src', 'style', 'title', 'value',
        'name', 'class', 'rel', 'type'
    ];

    /**
     * Variable for storing reconstructed $htmlattributes variable in order to
     * match at[Function] such as atSrc, atStyle, and such.
     *
     * @var array
     */
    protected $rhtmlattributes;

    /**
     * The result of curlGet() method goes on this variable. The content will be
     * like if you push CTRL+U on Mozilla Firefox to see its source.
     *
     * @var string;
     */
    protected $source;

    /**
     * DOMXPath instantiation stored in this variable.
     *
     * @var object;
     */
    protected $xPathObj;

    /**
     * If the testing is set to true then the class will not execute the curlGet()
     * method and returnXPathObject() method
     *
     * @var boolean;
     */


    private $tagsMethod; 
    private $attributesMethod;
    private $htmlMethodProcessor;

    public function __construct($url)
    {
        $this->callFunctions();
        $this->initGrabber($url);
    }

    public function callFunctions()
    {
        $htmlTagsMethod = new HTMLTagsMethod;
        $this->tagsMethod = $htmlTagsMethod->getList();

        $htmlAttributesMethod = new HTMLAttributesMethod;
        $this->attributesMethod = $htmlAttributesMethod->getAsProperty();

        $this->htmlMethodProcessor = new HTMLMethodProcessor;
    }
    /**
     * If you're gonna test the class using PHPUnit you can call either
     * by using this method or the class constructor argument. This method
     * disable the curlGet() method, so you can get the test results faster.
     *
     * @param string $method
     * @param array $args
     * @return null
     */
    public function initGrabber($url)
    {
        $this->url = $url;
        $this->clearQuery();
        $lgp = new LiteGrabberProcessor($url);
        $this->xPathObj = $lgp->getXPathObj();
    }

    /**
     * Get value of $testing variable. 
     *
     * @return bool
     */
    public function getTesting()
    {
        return $this->testing;
    }

    public function __call($method, $args)
    {   
        if (in_array($method, $this->tagsMethod))
            return $this->methodProcessor($method, $args);
        
        if (in_array($method, $this->attributesMethod)) 
            return $this->atMethodProcessor($method, $args);
            
        //return new Exception("Sorry $method() method not found!");
        return false;
    }

    /**
     * This method has two functions: first, to return $this->htmlattributes.
     * Second, to reconstruct the $this->htmlattributes array to have 'at' 
     * prefix and camelCase for each value in the array and return it as result.
     * 
     * @param bool $reconstruct
     * @return null
     */
    public function getHtmlAttributes($reconstruct = false)
    {
        $htmlattributes = $this->htmlattributes;

        if(!$reconstruct) {
            return $this->htmlattributes;
        }

        array_walk($htmlattributes, function(&$item){ $item = 'at'.ucfirst($item); } );
        return $htmlattributes;
    }

    /**
     * Get all available HTML tags from $htmltags variable.
     *
     * @return array
     */
    public function getHtmlTags()
    {
        return $this->htmltags;
    }

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
    public function methodProcessor($method, $args)
    {   

        $query = $this->htmlTagsProcessor($args);
        
        if (!empty($args[1]) && $args[1] == true) {
            $this->query .= '//'.$method.$query;
        } else {
            $this->query .= '/'.$method.$query;
        }
        return $this;
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
     * A shortcut method of query() method of DOMXPath.
     *
     * @param string $query
     * @return object
     */
    public function query($query)
    {
        try {
            return $this->xPathObj->query($query);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function execute($query)
    {
        return $this->query($query);
    }

    /**
     * Set query string to $query variable.
     *
     */
    public function setQuery($query)
    {
        $this->query = $query;
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

    /**
     * Clear or make the $query variable empty
     *
     * @return null
     */
    public function clearQuery()
    {
        $this->query = null;
    }

}