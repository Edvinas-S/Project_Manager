<?php
    //connect to database
    $servername = "127.0.0.1";
    $username = "root";
    $password = "mysql";
    $dbname = "project_manager_db";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    
// DELETE person from workers table
function delete_person() {
    global $conn;
    $sql = 'DELETE FROM workers WHERE `id`= '.$_POST['person_id'].';';
    mysqli_query($conn, $sql);
}
if(isset($_POST['delete_person'])) {
    delete_person();
    header('Location: index.php');
}

// DELETE project from course table
function delete_course() {
    global $conn;
    $sql = "DELETE FROM courses WHERE coursename = "."'".$_POST['course_name']."'".";";
    mysqli_query($conn, $sql);
}
if(isset($_POST['delete_course'])) {
    delete_course();
    header('Location: project.php');
}

// UPDATE person name from workers table 
function update_name() {
    global $conn;
    $sql = "UPDATE workers SET `firstname` ="."'".$_POST['new_name']."'"." WHERE `id`=".$_POST['pers_id'].";";
    mysqli_query($conn, $sql);
}
if(isset($_POST['name_submit'])) {
    update_name();
    header('Location: index.php');
}

// RENAME course name from courses table 
function rename_course() {
    global $conn;
    $sql = "UPDATE courses SET `coursename` ="."'".$_POST['new_course_name']."'"." WHERE `coursename`="."'".$_POST['old_name']."'".";";
    mysqli_query($conn, $sql);
}
if(isset($_POST['rename_submit'])) {
    rename_course();
    header('Location: project.php');
}

// ADD new worker
function add_new_worker() {
    global $conn;
    $sql = "INSERT INTO workers (`id`, `firstname`, `course_id`)
            VALUES (NULL,"."'".$_POST['new_worker']."'".",".$_POST['courses'].");";
    mysqli_query($conn, $sql);
}
if(isset($_POST['add_worker'])) {
    add_new_worker();
    header('Location: index.php');
}

// ADD new course
function add_new_course() {
    global $conn;
    $sql = "INSERT INTO courses (`id`, `coursename`)
    VALUES (NULL,"."'".$_POST['new_course']."'".");";
    mysqli_query($conn, $sql);
}
if(isset($_POST['add_course'])) {
    add_new_course();
    header('Location: project.php');
}

// CHANGE workers course
function change_course() {
    global $conn;
    $sql = "UPDATE workers SET `course_id` = ".$_POST['new_coursename']." WHERE `id` = ".$_POST['again_id'].";";
    mysqli_query($conn, $sql);
}
if(isset($_POST['course_submit'])) {
    change_course();
    header('Location: index.php');
}
?>