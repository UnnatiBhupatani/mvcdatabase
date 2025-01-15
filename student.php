<?php

class Student
{

    public function validate($pid, $name, $email)
    {
        $error = [
            'pid'    => '',
            'name'   => '',
            'email'  => '',
            'gender' => '',
            'city'   => '',

        ];

        if (empty($pid)) {
            $error['pid'] = 'pid must not empty ';
        } elseif (! is_numeric($pid)) {
            $error['pid'] = 'pid   must numeric';
        }
        if (empty($name)) {
            $error['name'] = 'name must not empty ';

        }if (empty($email)) {
            $error['email'] = 'email must not empty ';

        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'email  must be in email form';

        }
        if (! isset($_POST['gender'])) {
            $error['gender'] = 'select any one';
        }
        if (! isset($_POST['city']) || $_POST['city'] == '') {
            $error['city'] = 'select any one';
        }
        // if($pid==$pid){
        //     $error['pid']='pid must be unique';
        // }
            

        return $error;
    }

}
