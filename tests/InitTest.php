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

    public function testMatchAll()
    {
        // codes are here:
        // http://apps.timwhitlock.info/emoji/tables/unicode#block-1-emoticons

        $text = "a #💩 #and #🍦 #😳";
        $parser = new EmojiParser();
        $parser->setPrepend("#(?:[\\w]|");
        $matches = $parser->matchAll($text);

        $this->assertNotEmpty($matches);
        $this->assertNotEmpty($matches[0]);
        $this->assertEquals(4, count($matches[0]));

        $this->assertGreaterThan(0, preg_match("/\\x{1F4A9}/u", $matches[0][0]));
        $this->assertGreaterThan(0, preg_match("/^\#\\x{1F4A9}$/u", $matches[0][0]));
        $this->assertGreaterThan(0, preg_match("/\xF0\x9F\x92\xA9/", $matches[0][0]));
        $this->assertGreaterThan(0, preg_match("/^\#\xF0\x9F\x92\xA9$/", $matches[0][0]));

        $this->assertGreaterThan(0, preg_match("/^#and$/u", $matches[0][1]));

        $this->assertGreaterThan(0, preg_match("/\\x{1F366}/u", $matches[0][2]));
        $this->assertGreaterThan(0, preg_match("/^\#\\x{1F366}$/u", $matches[0][2]));
        $this->assertGreaterThan(0, preg_match("/\xF0\x9F\x8D\xA6/", $matches[0][2]));
        $this->assertGreaterThan(0, preg_match("/^\#\xF0\x9F\x8D\xA6$/", $matches[0][2]));

        $this->assertGreaterThan(0, preg_match("/\\x{1F633}/u", $matches[0][3]));
        $this->assertGreaterThan(0, preg_match("/^\#\\x{1F633}$/u", $matches[0][3]));
        $this->assertGreaterThan(0, preg_match("/\xF0\x9F\x98\xB3/", $matches[0][3]));
        $this->assertGreaterThan(0, preg_match("/^\#\xF0\x9F\x98\xB3$/", $matches[0][3]));
    }

    public function testReplaceCallback()
    {
        $parser = new EmojiParser();
        $parser->setPrepend("#(?:[\\w]|");
        $text = "a #💩 #and or #🍦 #😳";
        $i = 0;
        $matches = [];

        $replaced = $parser->replaceCallback($text, function($match)use(&$i, &$matches){
            $key = '_$'.$i++.'_';
            $matches[$key] = $match[0];
            return $key;
        });

        $this->assertEquals("a _$0_ _$1_ or _$2_ _$3_", $replaced);
    }

    public function testReplace()
    {
        $text = "a #💩 #and or #🍦 #😳";
        $parser = new EmojiParser();
        $replaced = $parser->replace($text, "q");
        $this->assertEquals("a #q #and or #q #q", $replaced);
    }

    public function testMatch(){
        $text = "a #💩 #and or #🍦 #😳";
        $parser = new EmojiParser();
        $match = $parser->match($text);
        $this->assertGreaterThan(0, $match);
    }
}
