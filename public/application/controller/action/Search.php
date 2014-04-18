<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\controller\Redirect;
use application\controller\Request;
use application\model\Database;
use application\model\SearchResultLoader;

defined('INDEX') or die;

class Search extends AbstractAction {

    private $database;
    private $request;
    private $posts;
    private $hasResults;

    function __construct(Database $database, Request $request) {
        $this->database = $database;
        $this->request = $request;
    }

    public function excute() {
        $query = $this->request->getPostData('query');
        $timeSelect = $this->request->getPostData('timeSelect');
        $timeInput = $this->request->getPostData('timeInput');
        $username = $this->request->getPostData('username');

        if (!isset($query, $timeSelect, $timeInput, $username)) {
            $this->hasResults = false;
            return;
        }

        if (empty($query) && ($timeSelect == 'none' || empty($timeInput)) && empty($username)) {
            new Redirect(array('action' => 'search', 'message' => 'Anna hakuehto'));
        }

        $search = new SearchResultLoader($this->database);

        if (!empty($query)) {
            $query = str_replace('%', '[%]', str_replace('_', '[_]', str_replace('[', '[[]', $query)));
            $search->addQuery($query);
        }
        if ($timeSelect != 'none' && !empty($timeInput)) {
            $time = strtotime($timeInput);
            if (!$time) {
                new Redirect(array('action' => 'search', 'message' => 'Aika on väärässä formaatissa. Oikea formaatti on YYYY-MM-SS hh:mm:ss'));
            }
            $search->addTimeFilter($time, $timeSelect == 'after');
        }
        if (!empty($username)) {
            $search->addUserFilter($username);
        }
        $this->posts = $this->formatPosts($search->search());
        $this->hasResults = true;
    }

    public function setVars() {
        $this->renderer->addVar('posts', $this->posts);
        $this->renderer->addVar('hasResults', $this->hasResults);
    }

    public function getTitle() {
        return 'Haku';
    }

    public function getView() {
        return 'search.php';
    }

    public function requireLogin() {
        return true;
    }

    private function formatPosts($posts) {
        $array = array();
        foreach ($posts as $post) {
            $postArray = $post->asArray();
            $postArray['content'] = Formatter::formatPostContent($postArray['content']);
            $postArray['timeSent'] = Formatter::formatTime($postArray['timeSent']);
            $array[] = $postArray;
        }
        return $array;
    }

}
