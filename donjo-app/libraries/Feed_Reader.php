<?php



defined('BASEPATH') || exit('No direct script access allowed');

class Feed_Reader
{
    private $sumber_feed = '';
    private $parser;
    private $channels;
    public $items;

    public function __construct($sumber_feed = '')
    {
        include_once 'FeedParser.php';
        $this->sumber_feed = $sumber_feed;
        $this->buka_feed($sumber_feed);
    }

    private function buka_feed($sumber_feed)
    {
        $this->parser = new FeedParser();
        $this->parser->parse('https://www.covid19.go.id/feed/');
        $this->channels = $this->parser->getChannels();
        $this->items    = $this->parser->getItems();
    }
}
