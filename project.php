<?php
    //connect to database
    $servername = "127.0.0.1";
    $username = "root";
    $password = "mysql";
    $dbname = "project_manager_db";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
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
                <th>Course title</th>
                <th>Persons assigned to this course</th>
                <th>Action</th>
            </tr>
            <?php
            // Print to HTML COURSES
            $sql = "SELECT c.coursename, group_concat(w.firstname SEPARATOR '; ') AS Persons FROM courses c
                    LEFT JOIN workers w ON c.id = w.course_id
                    GROUP BY c.coursename;
                    ;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>". $row["coursename"] ."</td>
                    <td>". $row['Persons'] ."</td>
                    <td>
                        <form action='functions.php' method='post'><input type='submit' name='delete_course' value='DELETE'><input type='hidden' name='course_name' value='".$row['coursename']."'></form>
                        <form method='post'><input type='submit' name='rename_course' value='RENAME COURSE'><input type='hidden' name='course_name' value='".$row["coursename"]."'></form>
                    </td>
                        </tr>";
                }
            } else {
                echo "<tr>
                <td> 0 </td><td> 0 </td><td> 0 </td>
                    </tr>";
            }
            // If there are persons without course print them 
                $sql = "SELECT group_concat(firstname SEPARATOR '; ') AS free_ones FROM workers
                        WHERE course_id IS NULL
                        GROUP BY course_id;
                        ;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>The FREE one's</td><td>". $row['free_ones'] ."</td><td> For future use </td>
                            </tr>";
                    }
                }
            ?>
        </table>
        <?php
            if(isset($_POST['rename_course']))
            echo "<div class='update_name'>
                    <form action='functions.php' method='post'>
                        <label>Selected: &nbsp;".$_POST['course_name']." </label>
                        <input type='text' name='new_course_name' placeholder='Here write new name'>
                        <input type='hidden' name='old_name' value='".$_POST['course_name']."'>
                        <input type='submit' name='rename_submit' value='SUBMIT'>
                    </form>
                </div>";
        ?>
        <br>
        <h3>Add new course:</h3>
        <form action="functions.php" method="post" class="new_course">
            <input type="text" name="new_course" placeholder="course name" required>
            <input type="submit" name="add_course" value="ADD">
        </form>
    </main>
    <footer>
       This is for education. 
       <p>My GitHub <a class="fa fa-github" href="https://github.com/Edvinas-S" target="_blank" rel="noopener noreferrer"></a></p>
    </footer>

    <?php mysqli_close($conn) ?>
    
</body>
</html>