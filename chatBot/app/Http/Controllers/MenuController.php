<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;

class MenuController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function build($csvQuestions)
    {

        $path = self::getNames($csvQuestions);


        $root = new Menu();

        foreach ($path as $subNames) {
            self::regiterTopic($subNames);
            $questions = array();
            foreach ($csvQuestions as $csvQuestion) {
                if ($csvQuestion["path"] === $subNames) {
                    array_push(
                        $questions,
                        $csvQuestion
                    );
                }
            }

            $menu = self::menuBuild($root, $subNames, $questions);
            $root->setSubmenu($menu);
        }
        return response(['menu' => $root]);
    }


    public static function getNames($csvQuestions)
    {
        $path = array();
        foreach ($csvQuestions as $csvQuestion) {
            if (!in_array($csvQuestion["path"], $path)) {
                array_push($path, $csvQuestion["path"]);
            }
        }

        return $path;
    }


    public static function menuBuild(Menu | null $root, array $path, array $questions)
    {

        if (!is_null($root)) {
            $removedName = null;
            if (!isset($path) || count($path) > 0) {
                $removedName = $path[0];

                $result = array_splice($path, 1);

                if ($root->getName() === '') {
                    $root->setName($removedName);
                }
                if (count($result) > 0) {
                    $submenu = new Menu();
                    $root->setSubmenu($submenu);

                    $root  = self::menuBuild($submenu, $result, $questions);
                } else {
                    $root->setSubmenu(null);
                    if (!is_null($root)) {
                        if ($root->getName() == end($questions[0]["path"])) {

                            $root->setQuestions($questions);
                            self::regiterQuestion($root);
                        }
                    }

                    $root  = self::menuBuild(null, $result, $questions);
                }
            }
        }





        return $root;
    }


    public static function regiterTopic(array $topicNames)
    {
        if ($topicNames) {
            $parent = null;
            foreach ($topicNames as $name) {

                $topic = Topic::where('name', $name)->first();
                if (!$topic) {
                    $topic = Topic::create([
                        "name" => $name,
                    ]);
                }
                if ($parent) {
                    $node = Topic::find($parent);

                    $node->appendNode($topic);
                }
                $parent = $topic->id;
            }
        }
    }
    public static function regiterQuestion(Menu $menu)
    {
        if ($menu) {
            $topic = Topic::where('name', $menu->getName())->first();
            foreach ($menu->getQuestions() as $question) {
                $topic = Topic::where('name', $menu->getName())->first();
                if ($topic) {

                    $question = Question::create([
                        "description" => $question["description"],
                        "answer" => $question["answer"],
                        "topic_id" => $topic->id
                    ]);

                    if ($topic->id == 22) {
                        print_r($topic);
                        print_r($question);
                    }
                }
            }
        }
    }
}
