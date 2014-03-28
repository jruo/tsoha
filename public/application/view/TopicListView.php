<?php

namespace application\view;

defined('INDEX') or die;

class TopicListView extends PageView {

    const PUBLIC_GROUP = 'Julkiset viestiketjut';
    const PRIVATE_GROUP = 'Sisäiset viestiketjut';

    private $topicGroups;

    function __construct() {
        $this->topicGroups = array();
    }

    public function addTopicGroup($name) {
        $this->topicGroups[$name] = <<<HTML

            <div class="panel panel-primary">
                <div class="panel-heading">{$name}</div>
                <table class="table-striped table">
                    <tr>
                        <th>Viestiketju</th>
                        <th class="col-md-1">Viestejä</th>
                        <th class="col-md-4">Viimeisin vastaus</th>
                    </tr>

HTML;
    }

    public function addTopic($groupName, $title, $topicID, $postCount, $lastUsername, $lastUserID, $lastTime, $newCount) {
        if (!array_key_exists($groupName, $this->topicGroups)) {
            throw new \Exception("Group $groupName does not exist");
        }
        $this->topicGroups[$groupName] .= <<<HTML

                    <tr>
                        <td>
                            <a href="{$this->baseURL}/?action=topic&id={$topicID}">{$title}</a>
                            <span class="badge">{$newCount}</span>
                        </td>
                        <td>{$postCount}</td>
                        <td><a href="{$this->baseURL}/?action=profile&id={$lastUserID}">{$lastUsername}</a>, {$lastTime}</td>
                    </tr>

HTML;
    }

    public function render() {
        foreach ($this->topicGroups as $html) {
            // Close all open tables and divs
            $html .= <<<HTML

                </table>
            </div>

HTML;

            // And print
            echo $html;
        }
    }

    public function getTitle() {
        return 'Keskustelufoorumi';
    }

}
