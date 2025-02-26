<?php

use Bmatovu\LaravelXml\Support\ArrayToXml;
use Bmatovu\LaravelXml\Support\JsonSimpleXMLElementDecorator;
use Bmatovu\LaravelXml\Support\XmlValidator;

if (! function_exists('xml_encode')) {
    /**
     * Convert the an array to an xml string.
     *
     * @param string[] $array
     * @param string   $rootElementName
     * @param bool     $replaceSpacesByUnderScoresInKeyNames
     * @param string   $xmlEncoding
     * @param string   $xmlVersion
     *
     * @return string
     */
    function xml_encode(array $array, $rootElementName = 'document', $replaceSpacesByUnderScoresInKeyNames = true, $xmlEncoding = 'UTF-8', $xmlVersion = '1.0')
    {
        return ArrayToXml::convert($array, $rootElementName, $replaceSpacesByUnderScoresInKeyNames, $xmlEncoding, $xmlVersion);
    }
}

if (! function_exists('xml_decode')) {
    /**
     * Convert a string of XML into an array.
     *
     * @see http://php.net/manual/en/function.simplexml-load-string.php
     * @see https://stackoverflow.com/a/20431742/2732184
     * @see https://stackoverflow.com/a/2970701/2732184
     *
     * @param string $data       A well-formed XML string
     * @param string $class_name [optional] Default: SimpleXMLElement
     * @param int    $options
     * @param string $ns         [optional] Namespace prefix or URI
     * @param bool   $is_prefix  [optional] TRUE if ns is a prefix, FALSE if it's a URI, defaults to FALSE
     *
     * @return mixed Array or FALSE on failure
     */
    function xml_decode($data, $class_name = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false)
    {
        $simple_xml = simplexml_load_string($data, $class_name, $options, $ns, $is_prefix);
        $json_simple_xml = new JsonSimpleXMLElementDecorator($simple_xml);

        return json_decode(json_encode($json_simple_xml), true);
    }
}

if (! function_exists('is_valid_xml')) {
    /**
     * Check if a string is valid XML.
     *
     * @param string $xml
     *
     * @return bool
     */
    function is_valid_xml($xml)
    {
        $validator = new XmlValidator();

        return $validator->is_valid($xml);
    }
}

if (! function_exists('validate_xml')) {
    /**
     * Validate XML string.
     *
     * @param string $xml
     * @param string $xsd file
     *
     * @return array errors
     */
    function validate_xml($xml, $xsd)
    {
        $validator = new XmlValidator();

        return $validator->validate($xml, $xsd);
    }
}
