<?php declare(strict_types=1); ?>

<?php require 'functions.php' ?>

<?php
    //connect to database
    $servername = "127.0.0.1";
    $username = "root";
    $password = "mysql";
    $dbname = "project_manager_db"; //need to comment $dbname first and remove it from $conn when creating DB
    
    $conn = mysqli_connect($servername, $username, $password, $dbname); // Create connection
    
    // // Check connection
    // if (!$conn) {
    //     die("Connection failed: " . mysqli_connect_error());
    // }
    // echo "Connected successfully <br>";

    // //****************************************************************************//
    // //  This is for adding Database, Table and putting some values to it (MySQL)  //
    // //****************************************************************************//
    //
    // // Create database
    // $sql = "CREATE DATABASE project_manager_db";
    // if (mysqli_query($conn, $sql)) {
    //     echo "Database created successfully <br>";
    // } else {
    //     echo "Error creating database: " . mysqli_error($conn) . '<br>';
    // }

    // //======================================================================================
    // // sql to create table WORKERS
    // $sql = "CREATE TABLE `workers` (
    //     `id` int(6) NOT NULL AUTO_INCREMENT,
    //     `firstname` varchar(45) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
    //     `course_id` int(6) DEFAULT NULL,
    //     PRIMARY KEY (`id`)
    //     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;
    //    ";
    // if (mysqli_query($conn, $sql)) {
    //     echo "Table WORKERS created successfully <br>";
    // } else {
    //     echo "Error creating table: " . mysqli_error($conn) . '<br>';
    // }

    // // sql to add values to WORKERS
    // $sql = "INSERT INTO workers (`id`, `firstname`, `course_id`)
    //     VALUES 
    //         (1, 'Jonukas', 1), (2, 'Grytute', 2), (3, 'Petriukas', 3),
    //         (4, 'Onutė', 4), (5, 'Mykoliukas', 5), (6, 'Pavyzdukas', NULL);
    //     ";
    // if (mysqli_query($conn, $sql)) {
    //     echo "Workers added successfully <br>";
    // } else {
    //     echo "Error adding workers: " . mysqli_error($conn) . '<br>';
    // }

    // //======================================================================================
    // // sql to create table COURSES
    // $sql = "CREATE TABLE `courses` (
    //     `id` int(6) NOT NULL AUTO_INCREMENT,
    //     `coursename` varchar(45) COLLATE utf8mb4_lithuanian_ci NOT NULL,
    //     PRIMARY KEY (`id`)
    //     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;";
    // if (mysqli_query($conn, $sql)) {
    //     echo "Table COURSES created successfully <br>";
    // } else {
    //     echo "Error creating table: " . mysqli_error($conn) . '<br>';
    // }

    // // sql to add values to COURSES
    // $sql = "INSERT INTO courses (`id`, `coursename`)
    //     VALUES 
    //          (1, 'Java'), (2, 'PhP'), (3, 'HTML'), (4, 'CSS'), (5, 'Python');
    //     ";
    // if (mysqli_query($conn, $sql)) {
    //     echo "Courses added successfully <br>";
    // } else {
    //     echo "Error adding courses: " . mysqli_error($conn) . '<br>';
    // }

    // //************************************************************************************//
    // //  Important!! You need to disable MySql "Safe Updates Preference" to modify tables  //
    // //************************************************************************************//
    //
    // $sql = 'SET SQL_SAFE_UPDATES = 0;';
    // mysqli_query($conn, $sql);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <header>
        <form action="index.php" method="post">
            <button type="submit">Workers</button>
        </form>
        <form action="project.php" method="post">
            <button type="submit">Courses</button>
        </form>
        <div class="name">Project manager</div>
    </header>
    <main>
        <table>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Assign to course</th>
                <th>Action</th>
            </tr>
            <?php
            // Print to HTML WORKERS
            $sql = "SELECT w.id, w.firstname, c.coursename FROM workers w
                    LEFT JOIN courses c ON w.course_id = c.id;
                    ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>". $row["id"] ."</td>
                    <td>". $row["firstname"] ."</td>
                    <td>". $row['coursename'] ."</td>
                    <td>
                        <form action='functions.php' method='post'><input type='submit' name='delete_person' value='DELETE'><input type='hidden' name='person_id' value='".$row["id"]."'></form>
                        <form method='post'><input type='submit' name='update_name' value='UPDATE NAME'><input type='hidden' name='person_id' value='".$row["id"]."'></form>
                        <form method='post'><input type='submit' name='update_course' value='CHANGE COURSE'><input type='hidden' name='person_id' value='".$row["id"]."'></form>
                    </td>
                        </tr>";
                }
            } else {
                echo "<tr>
                <td> 0 </td><td> 0 </td><td> 0 </td><td> 0 </td>
                    </tr>";
            }
            ?>
        </table>
        <?php
        // RENAME worker
            if(isset($_POST['update_name']))
            echo "<div class='update_name'>
                    <form action='functions.php' method='post'>
                        <label>Worker id: &nbsp; ".$_POST['person_id']." </label>
                        <input type='text' name='new_name' placeholder='Here write new name' required>
                        <input type='hidden' name='pers_id' value='".$_POST['person_id']."'>
                        <input type='submit' name='name_submit' value='SUBMIT'>
                    </form>
                </div>";
        ?>
        <?php
        // CHANGE worker course
            if(isset($_POST['update_course'])) {
            echo "<div class='update_course'>
                    <form action='functions.php' method='post'>
                        <label name='new_coursename'>Worker id: &nbsp; ".$_POST['person_id']." </label>
                        <input type='hidden' name='again_id' value='".$_POST['person_id']."'>
                        <select name='new_coursename' id='new_coursename'>
                            <option name='selected_course' value='NULL'>Free one ONE</option>";
                            $sql_c = 'SELECT id, coursename FROM courses';
                            $result_c = mysqli_query($conn, $sql_c);
                                if (mysqli_num_rows($result_c) > 0) {
                                    while($row_c = mysqli_fetch_assoc($result_c)) {
                                        print("<option name='selected_course' value='".$row_c['id']."'>".$row_c['coursename']."</option>");
                                    }
                                }; echo "
                        </select>
                        <input type='submit' name='course_submit' value='SUBMIT'>
                    </form>
                </div>";}
        ?>
        <br>
        <h3>Add new worker:</h3>
        <form action="functions.php" method="post" class="new_worker">
            <input type="text" name="new_worker" placeholder="workers name" required>
            <label for="courses"></label>
            <select name="courses" id="courses">
                <?php
                // DROPDOWN logic
                echo "<option value='NULL'>Free one</option>";
                    $sql = "SELECT id, coursename FROM courses;";
                    $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                    echo "<option name='select_course' value='".$row['id']."'>".$row['coursename']."</option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" name="add_worker" value="ADD">
        </form>
    </main>
    <footer>
       This is for education. 
       <p>My GitHub <a class="fa fa-github" href="https://github.com/Edvinas-S" target="_blank" rel="noopener noreferrer"></a></p>
    </footer>

    <?php mysqli_close($conn) ?>
    
</body>
</html>