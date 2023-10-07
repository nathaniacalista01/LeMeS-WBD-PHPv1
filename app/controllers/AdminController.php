<?php

    class AdminController extends Controller{
        // Landing page admin, menampilkan semua courses
        public function index(){
            header("Location: /admin/courses");
        }

        // Page admin untuk register
        public function register(){
            return $this->view("admin","register",[]);
        }

        // Page admin untuk melihat semua students
        public function users($params = "page=1"){
            if(!isset($_SESSION["user_id"])){
                $_SESSION["error"] = "You have to log in first";
                header("Location: /login");
            }
            $components = explode("=",$params);
            $page_number = $components[1];
            $admin = new Admin();
            $users = $admin->getUsers();
            $user_page = $admin->getFewUsers($page_number);
            $max_page = ceil(count($users)/6);
            return $this->view("admin","users",["page_number" => $page_number,"max_page" =>$max_page,"users"=>$user_page]);
        }
        public function editUser($params = "2"){
            $admin = new Admin();
            $user = $admin->getUserById($params);
            return $this->view("admin","editUser",["user"=>$user]);        
        }

        public function editCourse($params = ""){
            if(!$params){
                // Ini nanti ganti jadi notfound/error
                header("Location: /login");
            }else{
                $admin = new Admin();
                $course = $admin->get_course_by_id($params);
                return $this->view("admin","editCourse",["course" => $course]);
            }
        }
        // Page admin untuk melihat courses
        public function courses($params = "page=1"){
            $components = explode("=",$params);
            $page_number = $components[1];
            $course = new Course();
            $course_per_page = 6;
            $all_courses = $course->getAllCourses();
            $courses = $course->get_few_courses($course_per_page,$page_number);
            $max_page = ceil(count($all_courses)/$course_per_page);
            // print_r($courses);
            return $this->view("admin","courses",["page_number" => $page_number,"max_page" => $max_page,"courses" => $courses]);
        }
    }
?>