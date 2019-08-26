<?php

class page extends Model{

    public function __construct($name=null)
    {
        parent::__construct();
        if(!is_null($name))$this->get_page($name);
    }

    /**
     * @var int $id the unique id of the page
     */
    public $id;

    /**
     * @var string $name the name of the page
     */
    public $name;

    /**
     * function to fetch the information on all the pages on the platform
     * @return array|page returns an array of pages
     */
    public function get_pages()
    {
        $pages = array();
        $result = $this->pdo_fetch("CALL hcms.fetch_pages()",array(),PDO::FETCH_ASSOC,true);
        if($result["count"] > 0) {
            foreach ($result["data"] as $val) {
                $page = new page();
                $page->id = $val["page_id"];
                $page->name = $val["page_name"];
                $pages[] = $page;
            }
        }

        return $pages;
    }

    public function get_page($name)
    {
        $result = $this->pdo_fetch("CALL hcms.fetch_page(?)",array($name),PDO::FETCH_ASSOC);
        if($result["count"] > 0) {
                $this->id = $result["data"]["page_id"];
                $this->name = $result["data"]["page_name"];
        }
    }

    /**
     * function to insert a page into the database
     */
    public function set_page()
    {
        $this->pdo_insert("CALL hcms.insert_page(:name)",array(
            ":name" => $this->name
        ));
    }

    /**
     * function to delete a page from the database
     */
    public function delete_page()
    {
        $this->pdo_delete("CALL hcms.delete_page(?)",array($this->id));
    }
}