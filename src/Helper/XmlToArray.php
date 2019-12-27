<?php

namespace VnCoder\Helper;

use DOMDocument;

class XmlToArray
{
    protected $xmlContent = '';

    static function get($file = ''){
        $xmlContent = file_get_contents($file);
        return with(new static)->loadData($xmlContent);
    }

    static function load($xmlContent = ''){
        return with(new static)->loadData($xmlContent);
    }

    function loadData($str = ''){
        $this->xmlContent = $str;
        return $this;
    }

    function toArray($outputRoot = false){
        $array = $this->xmlStringToArray();
        if (!$outputRoot && array_key_exists('@root', $array)) {
            unset($array['@root']);
        }
        return $array;
    }

    protected function xmlStringToArray()
    {
        $dom = simplexml_load_string($this->xmlContent);
        $root = $dom->documentElement;
        $output = $this->domNodeToArray($root);
        $output['@root'] = $root->tagName;
        return $output;
    }

    protected function domNodeToArray($node)
    {
        $output = [];
        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = $this->domNodeToArray($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;
                        if (!isset($output[$t])) {
                            $output[$t] = [];
                        }
                        $output[$t][] = $v;
                    } elseif ($v || $v === '0') {
                        $output = (string) $v;
                    }
                }
                if ($node->attributes->length && !is_array($output)) { // Has attributes but isn't an array
                    $output = ['@content' => $output]; // Change output into an array.
                }
                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = [];
                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }
                        $output['@attributes'] = $a;
                    }
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1 && $t != '@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }
}
