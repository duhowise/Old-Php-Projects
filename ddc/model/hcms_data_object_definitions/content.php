<?php

class content extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var int $id the unique id of the content
     */
    public $id;

    /**
     * @var Container $container the container the content belongs to
     */
    public $container;

    /**
     * @var DateTime $created_at the date and time at which the content was inserted into the database
     */
    public $created_at;

    /**
     * @var page $page the page the content belongs to
     */
    public $page;

    /**
     * @var string $text the text content
     */
    public $text;

    /**
     * @var string $url the url for the multimedia content
     */
    public $url;

    /**
     * @var int $url value to determine if the content has been removed or deleted
     */
    public $flag;

    /**
     * @var array|content $children an array of child contents that belong to a parent container
     */
    public $children;

    /**
     * function to fetch the contents of a container
     * @param $tag string the tag name of the container
     * @return array|content returns a array of contents for the specified container together with the contents of its child containers
     */
    public function get_content($tag)
    {
        //obtain container information
        $container = new Container($tag);
        $result = $this->pdo_fetch("CALL hcms.fetch_content(?,?)", array($container->id,$container->content_type),PDO::FETCH_ASSOC,true);
        $contents = array();
        $contents[$tag]=array();
        //check if the container is a multi container
            foreach ($result["data"] as $val) {
                $content = new content();
                $content->id = $val["content_id"];
                $content->created_at = $val["created_at"];
                $content->flag = $val["flag"];
                $content->text = $container->content_type == "text"? $val["text"]:null;
                $content->url = $container->content_type == "multimedia"? $val["url"]:null;
                $contents[$container->tag][] = $content;
            }
            if($container->is_parent()) {
                //time to fetch child content
                foreach ($container->children as $child) {
                    $this->fetch_children($child);
                    $contents["children"] = $this->children;
                }
            }
        return $contents;
    }

    /**
     * function to fetch the contents of the child containers of the parent container
     * the contents of the child containers are assigned to the children array property
     * of the content object
     * @param Container $container
     */
    public function fetch_children(Container $container) {
        $result = $this->pdo_fetch("CALL hcms.fetch_content(?,?)",array($container->id,$container->content_type),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $val) {
            $content = new content();
            $content->id = $val["content_id"];
            $content->created_at = $val["created_at"];
            $content->flag = $val["flag"];
            $content->text = $container->content_type == "text" ?$val["text"]:null;
            $content->url = $container->content_type == "multimedia" ?$val["url"]:null;
            $this->children[$container->tag][] = $content;
        }
        if($container->is_parent()){
            //time to fetch child content
            foreach ($container->children as $child) {
                $this->fetch_children($child);
            }
        }
    }

    /**
     * function to insert page content for a specific container into the database
     */
    public function insert_content()
    {
        $this->pdo_insert("CALL hcms.insert_content(:contid,:cntnttype,:txt,:url,:createdat)",array(
            ":txt" => $this->text,
            ":url" => $this->url,
            ":createdat" => $this->dt->get_date("date.timezone"),
            ":cntnttype" => $this->container->content_type,
            ":contid" => $this->container->id
        ));
    }

    /**
     * function to delete content on the system by flagging it
     */
    public function delete_content()
    {
        $this->pdo_delete("CALL hcms.delete_content(?)",array($this->id));
    }
}