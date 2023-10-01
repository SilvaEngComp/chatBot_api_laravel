<?php

namespace App\Models;

class Menu
{
    public string $name;
    public array $questions;
    public array $submenu;

    function __construct($name = '')
    {
        $this->name = $name;
        $this->questions = [];
        $this->submenu = [];
    }


    public function build()
    {
        return [
            "name" => $this->getName(),
            "submenu" => $this->getSubmenu(),
            "questions" => $this->getQuestions(),
        ];
    }
    /**
     * Get the value of submenu
     *
     * @return  array
     */
    public function getSubmenu()
    {

        return $this->submenu;
    }

    /**
     * Set the value of submenu
     *
     * @param  array  $submenu
     *
     * @return  self
     */
    public function setSubmenu(Menu | null $submenu)
    {
        array_push($this->submenu, $submenu);

        return $this;
    }

    /**
     * Get the value of questions
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set the value of questions
     *
     * @param array $questions
     *
     * @return self
     */
    public  function setQuestions(array $questions): self
    {

        $this->questions = $questions;

        return $this;
    }





    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
