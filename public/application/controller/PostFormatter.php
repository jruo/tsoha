<?php

namespace application\controller;

defined('INDEX') or die;

class PostFormatter {

    private $BBCodeTags = array(
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
    private $HTMLTags = array(
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

    public function format($text) {
        $text = htmlspecialchars($text);
        $text = str_replace("\n", '<br/>', $text);
        $text = preg_replace($this->BBCodeTags, $this->HTMLTags, $text);
        return $text;
    }

}
