<?php
/**
 * PHP Version 5
 *
 * @package   
 * @author    "Yury Kozyrev" <urakozz@gmail.com>
 * @copyright 2015 "Yury Kozyrev" 
 * @license   MIT
 * @link      https://github.com/urakozz/php-instagram-client
 */

namespace Kozz\Tests;


use Kozz\Components\Emoji\EmojiParser;

class InitTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $text = "a #💩 #and #🍦 #😳";
        $parser = new EmojiParser();
        $parser->setPrepend("#\\w+|#");
        $pattern = $parser->matchAll($text);
        var_dump($pattern);
    }
}