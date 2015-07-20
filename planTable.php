<!--
        /*
        * Add edit delete rows dynamically using jquery and php
        * http://www.amitpatil.me/
        *
        * @version
        * 2.0 (4/19/2014)
        * 
        * @copyright
        * Copyright (C) 2014-2015 
        *
        * @Auther
        * Amit Patil
        * Maharashtra (India)
        *
        * @license
        * This file is part of Add edit delete rows dynamically using jquery and php.
        * 
        * Add edit delete rows dynamically using jquery and php is freeware script. you can redistribute it and/or 
        * modify it under the terms of the GNU Lesser General Public License as published by
        * the Free Software Foundation, either version 3 of the License, or
        * (at your option) any later version.
        * 
        * Add edit delete rows dynamically using jquery and php is distributed in the hope that it will be useful,
        * but WITHOUT ANY WARRANTY; without even the implied warranty of
        * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        * GNU General Public License for more details.
        * 
        * You should have received a copy of the GNU General Public License
        * along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
        */
-->
<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <script>
            // Column names must be identical to the actual column names in the database, if you dont want to reveal the column names, you can map them with the different names at the server side.
            var columns = new Array("semester", "year", "moduleCode", "requirement", "gpa");
            var placeholder = new Array("", "", "Enter Module", "", "");
            var inputType = new Array("select", "select", "text", "select", "select");
            var table = "tableDemo";
            var selectOptSem = new Array("1", "2");
            var selectOptYear = new Array("1", "2", "3", "4", "5");
            var selectOptGPA = new Array("A+/A : 5", "A- : 4.5", "B+ : 4", "B : 3.5", "B- : 3", "C+ : 2.5", "C : 2", "Satisfactory", "Unsatisfactory", "D+ : 1.5", "D : 1", "F : 0");
            var selectOptRequirement = new Array("General Education", "Breadth", "Singapore Studies", "Core", "Electives", "Internship", "Unrestricted Electives");

            // Set button class names 
            var savebutton = "ajaxSave";
            var deletebutton = "ajaxDelete";
            var editbutton = "ajaxEdit";
            var updatebutton = "ajaxUpdate";
            var cancelbutton = "cancel";

            var saveImage = "assets/images/save.png"
            var editImage = "assets/images/edit.png"
            var deleteImage = "assets/images/remove.png"
            var cancelImage = "assets/images/back.png"
            var updateImage = "assets/images/save.png"

            // Set highlight animation delay (higher the value longer will be the animation)
            var saveAnimationDelay = 3000;
            var deleteAnimationDelay = 1000;

            // 2 effects available available 1) slide 2) flash
            var effect = "slide";

        </script>
        <script src="assets/js/jquery-ui.js"></script>	
        <script src="assets/js/scriptForTable.js"></script>
        <script src="assets/js/require.js"></script>
        <link rel="stylesheet" href="assets/css/styleForTable.css">
    </head>
    <body>
        <table border="0" class="tableDemo bordered">
            <tr class="ajaxTitle">
                <th width="15%">Semester</th>
                <th width="15%">Year</th>
                <th width="22%">Module Code</th>
                <th width="18">Requirement</th>
                <th width="15%">Expected GPA</th>
                <th width="15%">Action</th>
            </tr>
            <?php
            print_r($_SESSION['test']);
            for ($i = 0; $i < count($_SESSION['test']); $i++) {
                ?>
                <tr id="<?= $_SESSION['test'][$i]['id']; ?>">
                    <td class="semester"><?php echo $_SESSION['test'][$i]['semester']; ?></td>
                    <td class="year"><?= $_SESSION['test'][$i]['year']; ?></td>
                    <td class="moduleCode"><?= $_SESSION['test'][$i]['moduleCode']; ?></td>
                    <td class="requirement"><?= $_SESSION['test'][$i]['requirement']; ?></td>
                    <td class="gpa"><?= $_SESSION['test'][$i]['gpa']; ?></td>
                    <td>
                        <a href="javascript:;" id="<?= $_SESSION['test'][$i]['id']; ?>" class="ajaxEdit"><img src="" class="eimage"></a>
                        <a href="javascript:;" id="<?= $_SESSION['test'][$i]['id']; ?>" class="ajaxDelete"><img src="" class="dimage"></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>  
    </body>
</html>