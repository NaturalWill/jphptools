<?php
/**
 * Json to XML
 * @author Jier(NaturalWill) <naturalwill@qq.com>
 * @link https://github.com/NaturalWill/jphptools/ The JPHPTools Project.
 * @note json2xml.php is a simple implementation of JSON to XML conversion.
 */

function xml_to_json($source)
{
	//判断source是file，还是string
    if (is_file($source)) {
        $xml = simplexml_load_file($source);
    } elseif (is_string($source)) {
        $xml = simplexml_load_string($source);
    } else {
		return false;
	}
    $json = json_encode(array($xml->getName() => $xml)); //php5，以及以上，如果是更早版本，请下载JSON.php
    return $json;
}

function json_to_xml($source, $charset = 'UTF-8')
{
    if (empty($source)) {
        return false;
    }
    $array = json_decode($source); //php5，以及以上，如果是更早版本，请下载JSON.php
    $xml   = '<?xml version="1.0" encoding="' . $charset . '"?>';
    $xml .= _json_to_xml($array);
    return $xml;
}

function _json_to_xml($source, $pkey = '')
{
    $string = '';
    foreach ($source as $k => $v) {
        if (is_array($v)) { //判断是否是数组
            $string .= _json_to_xml($v, $k);
        } else {
			$key = is_numeric($k) ? $pkey : $k; //判断Key是否是数字，如果是，则使用上一级的Key
            $string .= empty($key) ? '' : '<' . $key . '>';
            if (is_object($v)) { //判断是否是对像
                $string .= _json_to_xml($v, $k);
            } else {
                $string .= $v; //取得标签数据
            }
            $string .= empty($key) ? '' : '</' . $key . '>';
        }
    }
    return $string;
}
?>