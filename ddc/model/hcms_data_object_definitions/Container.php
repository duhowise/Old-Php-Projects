<?php
/**
 * A container is a piece or a portion of page who's content can be edited.
 * A container can have sub-containers.
 * A sub-container is a container nested within another container
 */
class Container extends Model{

    /**
     * initialize a container with a tag name to fetch information for the container or
     * initialize a container without a tag name to create an empty container
     * @param null $tag
     */
    public function __construct($tag = null)
    {
        parent::__construct();
        if(!is_null($tag)){$this->get_container($tag);}
    }

    /**
     * @var int $id the unique id of the container
     */
    public $id;

    /**
     * @var string $tag the name or reference of the container
     */
    public $tag;

    /**
     * @var string $content_type specifies the type of data that the container will house whether text or multimedia
     */
    public $content_type;

    /**
     * @var string $content_format specifies the format of data that the container will house e.g. picture, text or video
     */
    public $content_format;

    /**
     * @var bool $parent indicate if the container has sub-containers
     */
    public $parent;

    /**
     * @var bool $child indicate if the container is a sub-container
     */
    public $child;

    /**
     * @var page $page the page the container belongs to
     */
    public $page;

    /**
     * @var bool $content_multi value to determine whether the content stored in the container
     * will be singular or whether it will have multiple contents
     */
    public $content_multi;

    /**
     * @var array|Container $children array of containers which are the sub-containers of the main container
     */
    public $children = array();


    /**
     * function to fetch information on a container with the specified tag
     * @param $tag string the name of the container
     */
    private function get_container($tag)
    {
        $result = $this->pdo_fetch("CALL hcms.fetch_container(?)",array($tag),PDO::FETCH_ASSOC);
            //check if the container has child containers (sub-containers)
            if($result["data"]["parent"]){
                $chld_rslt = $this->pdo_fetch("CALL hcms.fetch_sub_containers(?)",array($result["data"]["container_id"]),PDO::FETCH_ASSOC,true);
                foreach ($chld_rslt["data"] as $val1) {
                    $c_container = new Container($val1["tag"]);
                    $this->children[] = $c_container;
                }
            }
            $this->id = $result["data"]["container_id"];
            $this->content_type = $result["data"]["content_type"];
            $this->content_format = $result["data"]["content_format"];
            $this->content_multi = $result["data"]["content_multi"];
            $this->tag = $result["data"]["tag"];
            $this->page = $result["data"]["page_id"];
            $this->child = $result["data"]["child"];
            $this->parent = $result["data"]["parent"];
    }

    /**
     * function to fetch all the containers that belong to a page
     * @param $page string the name of the page
     * @return array|Container returns an array of containers that belong to the page specified
     */
    public function get_containers($page)
    {
        $containers = array();
        $result = $this->pdo_fetch("CALL hcms.fetch_containers(?)",array($page),PDO::FETCH_ASSOC,true);
        if($result["count"] > 0){
            foreach ($result["data"] as $val) {
                $container = new Container($val["tag"]);
                $containers[] = $container;
            }
        }
        return $containers;
    }

    /**
     * function to create a container in the database
     */
    public function set_container()
    {
        $this->pdo_insert("CALL hcms.insert_container(:tag,:page_name,:content_type,:content_format,:content_multi,:created_at,:parent,:child)",
            array(
                ":tag" => $this->tag,
                ":page_name" => $this->page->name,
                ":content_type" => $this->content_type,
                ":content_format" => $this->content_format,
                ":content_multi" => $this->content_multi,
                ":created_at" => $this->dt->get_date("date.timezone"),
                ":parent" => $this->parent,
                ":child" => $this->child
            ));
    }

    /**
     * function to set a sub-container for a parent container
     */
    public function set_sub_container($ptag,$ctag)
    {
        $this->pdo_insert("CALL hcms.insert_sub_container(?,?)",array($ptag,$ctag));
    }

    /**
     * function to delete a container
     */
    public function del_container()
    {
        $this->pdo_delete("CALL hcms.delete_container(?)",array($this->tag));
    }

    /**
     * function to check if the current instance of the container is a parent container
     * @return bool returns true if the container is a parent and false if otherwise
     */
    public function is_parent()
    {
        return $this->parent == 1;
    }

    /**
     * function to check if the current instance of the container is a child container
     * @return bool returns true if the container is a child and false if otherwise
     */
    public function is_child()
    {
        return $this->child == 1;
    }

    /**
     * function to check if the container displays multiple contents at the same time
     * @return bool returns true if the container displays multiple contents
     */
    public function is_multi()
    {
        return $this->content_multi == 1;
    }
}