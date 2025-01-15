<?php
require_once 'Student.php';
require_once 'conntest.php';

class StudentController
{
    private $student;
    public $connobj;

    // private $add;
    public function __construct()
    {
        $this->connobj = (new Conntest())->conn;

        $this->student = new Student();

        // $add = $this->connobj->$conn;

    }

    public function addStudent($pid, $name, $email, $gender, $city)
    {   
        
        $sql="select pid from students where pid=$pid";
        $result=$this->connobj->query($sql);
        if($result->num_rows>0){
            $error['pid']="please enter unique pid";
            return $error;
        }
        
  
        $error = $this->student->validate($pid, $name, $email, $gender, $city);

        if (empty(array_filter($error))) {
            $sql = "insert into students(pid,name,email,gender,city) values($pid,'$name','$email','$gender','$city')";

            if ($this->connobj->query($sql) === true) {
                echo "data added successfully";
            } else {
                echo "error :" . $sql . "<br>";
            }

        }
        return $error;

    }
    public $result;
    public function display()
    {
        $sql= "select * from students";
        $this->result = $this->connobj->query($sql);

        return $this->result;

    }

    public function updateStudentById($old_pid, $pid, $name, $email, $gender, $city)
    {

        $error = $this->student->validate($pid, $name, $email, $gender, $city);
        if (empty(array_filter($error))) {
            $sql = "update students set pid=$pid,name='$name',email='$email',gender='$gender',city='$city' where pid=$pid";
            
            if ($this->connobj->query($sql) === true) {
                echo "data updated successfully";
            } else {
                echo "error :" . $sql . "<br>";
            }

        }return $error;

    }

    public function deleteStudentByID($pid)
    {
        $sql          = "DELETE FROM students where pid=$pid";
        $this->result = $this->connobj->query($sql);
        return $this->result;

    }

    

}
