<?php

namespace application\controller;

defined('INDEX') or die;

class Formatter {

    private static $BBCodeTags = array(
        '/\[b\](.*?)\[\/b\]/is',
        '/\[i\](.*?)\[\/i\]/is',
        '/\[u\](.*?)\[\/u\]/is',
        '/\[color=(.*?)\](.*?)\[\/color\]/is',
        '/\[img\](.*?)\[\/img\]/is',
        '/\[url\]http\:\/\/(.*?)\[\/url\]/is',
        '/\[url\]https\:\/\/(.*?)\[\/url\]/is',
        '/\[url\](.*?)\[\/url\]/is',
        '/\[url\=http\:\/\/(.*?)\](.*?)\[\/url\]/is',
        '/\[url\=https\:\/\/(.*?)\](.*?)\[\/url\]/is',
        '/\[url\=(.*?)\](.*?)\[\/url\]/is'
    );
    private static $HTMLTags = array(
        '<strong>$1</strong>',
        '<em>$1</em>',
        '<u>$1</u>',
        '<span style="color:$1;">$2</span>',
        '<br/><img src="$1"/><br/>',
        '<a href="http://$1">$1</a>',
        '<a href="https://$1">$1</a>',
        '<a href="http://$1">$1</a>',
        '<a href="http://$1">$2</a>',
        '<a href="https://$1">$2</a>',
        '<a href="http://$1">$2</a>'
    );

    public static function formatPostContent($text) {
        $text = self::escapeText($text);
        $text = str_replace("\n", '<br/>', $text);
        $text = preg_replace(self::$BBCodeTags, self::$HTMLTags, $text);
        return $text;
    }
    
    public static function escapeText($text) {
        return htmlspecialchars($text);
    }

}
