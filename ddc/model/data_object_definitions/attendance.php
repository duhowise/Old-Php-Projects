<?php

class attendance extends Model{
    public function __construct()
    {
        parent::__construct();
    }

    public $id;
    public $created_at;
    /**
     * @var int $number the number of people who attended the activity
     */
    public $number;
    /**
     * @var string $branch the name of the branch where the attendance was taken
     */
    public $branch;
    /**
     * @var string $activity the church activity the attendance was taken for
     */
    public $activity;

    public function get_branch_attendance($branch_name)
    {
        $return = array();
        $result = $this->pdo_fetch("CALL hbc.fetch_branch_attendance(?)",array($branch_name),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $attendance = new attendance();
            $attendance->id = $row["attendance_id"];
            $attendance->created_at = $row["created_at"];
            $attendance->number = $row["number"];
            $attendance->branch = $row["branch_id"];
            $attendance->activity = $row["activity"];
            $return[] = $attendance;
        }
        return $return;
    }


    public function get_ministry_attendance($branch_name, $ministry_name)
    {
        $return = array();
        $result = $this->pdo_fetch("CALL hbc.fetch_ministry_attendance(:branch_name,:ministry_name)",
            array(
                ":branch_name" => $branch_name,
                ":ministry_name" => $ministry_name
            ),
            PDO::FETCH_ASSOC,true);

        foreach ($result["data"] as $row) {
            $attendance = new attendance();
            $attendance->id = $row["attendance_id"];
            $attendance->created_at = $row["created_at"];
            $attendance->number = $row["number"];
            $attendance->branch = $row["branch_id"];
            $attendance->activity = $row["activity"];
            $return[] = $attendance;
        }
        return $return;
    }

    public function set_attendance()
    {
        $result = $this->pdo_insert("CALL hbc.set_attendance(:branch_name,:created_at,:number,:activity)",
            array(
                ":branch_name" => $this->branch,
                ":created_at" => $this->created_at,
                ":number" => $this->number,
                ":activity" => $this->activity
            ));
    }
}