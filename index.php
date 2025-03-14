<!DOCTYPE html>
<!--&copy; 2024 ICT Unit, Department of Education Region 10. All rights reserved.-->

<?php
// Include the database connection file

// Include the database connection file
include '../adminquarterlyassessment/roxcon.php';

// Check the status in tb_settings where id = 1
$status_query = "SELECT `status` FROM tb_settings WHERE id = 1";
$status_result = $conn->query($status_query);

if ($status_result->num_rows > 0) {
    $status_row = $status_result->fetch_assoc();
    if ($status_row['status'] == 0) {
        header('Location: https://r10.deped.gov.ph');
        exit();
    }
}

include '../adminquarterlyassessment/roxcon.php';

// Fetch school data from the database
$query = "SELECT schoolid, `name` FROM school where quarter = 5";
$result = $conn->query($query);

$subjects_query = "SELECT gradelevel, `subject`, `file` FROM subjects WHERE QUARTER = 4";
$subjects_result = $conn->query($subjects_query);

$subjects = [];
if ($subjects_result->num_rows > 0) {
    while ($row = $subjects_result->fetch_assoc()) {
        $subjects[] = $row;
    }
}

// Close the database connection
//$conn->close();
?>

<?php
// Get the selected grade level from the URL, if available
$selected_grade = isset($_GET['grade']) ? $_GET['grade'] : '';
?>

<script src="assets/jszip.min.js"></script>
<script src="assets/zip-full.min.js"></script>
<script src="assets/rox-min.js"></script>


<html>

    <head>
        <title>Computer Based Regional Assessment Test</title>
        <script>
            document.addEventListener("contextmenu", function (event) {
                event.preventDefault();
            }, false);


        </script>
        <style>
            body {
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            .container {
                display: flex;
                flex-direction: row;
                height: 100vh;
                overflow: hidden;
            }

            .left {
                background-color: #ccc;
                width: 25%;
                overflow-x: scroll;
                padding-right: 15px;
            }

            .right {
                background-color: #eee;
                width: 75%;
            }

            .content {
                width: 2000px;
                /* Change this value as per your need */
                height: 100%;
                padding: 20px;
                box-sizing: border-box;
            }

            /* On screens that are 992px or less*/
            @media screen and (max-width: 1495px) {

                h1 {
                    margin-top: 0;
                    padding: 30px;
                    font-family: Georgia, 'Times New Roman', Times, serif;
                    font-size: xx-large;
                }

                .logo img {
                    display: none;
                }

            }

            @media screen and (max-width: 768px) {
                .container {
                    flex-direction: column;
                }

                .left {
                    width: 100%;
                }

                .right {
                    width: 100%;
                }

                h1 {
                    margin-top: 0;
                    padding: 30px;
                    font-family: Georgia, 'Times New Roman', Times, serif;
                    font-size: xx-large;
                }

                .logo img {
                    display: none;
                }
            }

            .detailsContainer {
                background-color: #ed532d;
                color: white;
                width: 100%;
                padding: 10px;
                border-radius: 10px;
                margin-top: 15px;
            }

            .logo img {
                height: 100px;
                width: 100px;
                padding-top: 5px;
            }

            form {
                width: 80%;
                margin: 0 auto;
                font-size: 16px;
                font-family: Arial, sans-serif;
            }

            h1 {
                margin-top: 0;
                padding: 30px;
                font-family: Georgia, 'Times New Roman', Times, serif;
            }

            p {
                font-weight: bold;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            input[type='text'] {
                width: 92%;
                padding: 10px;
                border: 1px solid white;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: medium;
            }

            input[type='number'] {
                width: 92%;
                padding: 10px;
                border: 1px solid white;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: medium;
            }

            select {
                text-transform: capitalize;
                width: 98%;
                padding: 10px;
                border: 1px solid white;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: medium;
            }

            input[type='radio'] {
                -ms-transform: scale(2);
                /* IE 9 */
                -webkit-transform: scale(2);
                /* Chrome, Safari, Opera */
                transform: scale(2);
                margin-left: 20px;
            }

            ol {
                list-style: none;
                counter-reset: item;
                margin: 0;
                padding: 0;
                font-size: large;
            }

            li {
                display: flex;
                margin-bottom: 15px;
            }

            li label {
                margin-right: 10px;
            }

            li input[type='radio'] {
                margin-right: 5px;
            }

            li::before {
                content: counter(item) ". ";
                counter-increment: item;
                margin-right: 5px;
                font-weight: bold;
            }


            input[type='submit'] {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 20px;
                transition: all 0.3s ease;
            }

            input[type='submit']:hover {
                background-color: #3e8e41;
            }

            #timer {
                font-size: 24px;
                color: red;
                text-align: center;
                margin-top: 10px;
            }

            button {
                background-color: #4CAF50;
                /* Green */
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 20px 0px;
                margin-bottom: 40px;
                cursor: pointer;
                width: 100%;
                border-radius: 5px;
            }

            button:hover {
                background-color: #3e8e41;
                /* Dark green */
            }

            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }

            .header {
                display: flex;
                justify-content: space-evenly;
                background-color: #ed532d;
                color: white;
                height: 105px;
                margin: 0;
                padding: 10px;
            }

            .logo .matatag {
                height: 70px;
                width: 180px;
                background-color: white;
                border-radius: 5px;
                margin-bottom: 15px;
            }
        </style>

    </head>

    <body>

        <div class="container">
            <div class="right">
                <div class="header">
                    <h1>2025 Computer Based Regional Assessment Test</h1>
                    <div class="logo">
                        <img src="./assets/depedlogo.png" alt="deped10logo">
                        <img src="./assets/ict.png" alt="ictlogo">
                    </div>
                </div>
                <!--<embed src="questionnaire/math6validation.pdf" width="100%" height="100%" type='application/pdf'>
            -->
                <object id="pdf-viewer" data="" type="application/pdf" width="100%" height="90%">
                    <p>Failed to load file<a href=""></a></p>

                </object>
            </div>
            <div class="left">

                <form action="submitprocess.php" method="GET">
                    <h2>Answer Sheet</h2>
                
                    <div class="detailsContainer">

                        <label for="schoolid">School ID:</label>
                        <!-- input type="number" id="schoolid" name="schoolid" placeholder="128060" maxlength="6" required -->
                        <?php 
                        
                        if ($result->num_rows > 0) {
                        echo '<select name="schoolid" class="form-control" required>';
                        echo '<option value="">Select School</option>';

                        // Loop through the result set and populate the combo box
                        while ($row = $result->fetch_assoc()) {
                            $schoolid = $row['schoolid'];
                            $name = $row['name'];

                            echo '<option value="' . htmlspecialchars($schoolid) . '">' . htmlspecialchars($name) . '</option>';
                        }

                        echo '</select>';
                         } else {
                        echo '<select name="schoolid" class="form-control" required>';
                        echo '<option value="">No schools available</option>';
                        echo '</select>';
                         }
                        ?>
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" placeholder="Juan dela Cruz" required />

                        <label for="grade">Grade Level:</label>
                        <select id="grade" name="grade" required onchange="checkGrade()">
                            <option value="" selected>Select grade</option>
                            <option value="3" <?php echo $selected_grade == '3' ? 'selected' : ''; ?>>Grade 3</option>
                            <option value="6" <?php echo $selected_grade == '6' ? 'selected' : ''; ?>>Grade 6</option>
                            <option value="10" <?php echo $selected_grade == '10' ? 'selected' : ''; ?>>Grade 10</option>
                            <option value="12" <?php echo $selected_grade == '12' ? 'selected' : ''; ?>>Grade 12</option>
                        </select>

                        <div id="verificationInput" style="display: none;">
                            <label for="verificationCode">Verification Code:</label>
                            <input type="text" id="verificationCode" name="verificationCode" required>
                            <button type="button" onclick="verifyCode()">Verify</button>
                        </div>
                        

                        <label for="subject">Subject:</label>
                        <!-- <select id="subject" name="subject" required>
                            <option value="" selected disabled>Select subject</option>

                        </select> -->



                        <!-- HTML Dropdown for Subjects -->
                        <select id="subject" name="subject" required>
                            <option value="" selected disabled>Select subject</option>
                            <?php
                            //if (!empty($subjects)) {
                            //    foreach ($subjects as $subject) {
                            //        echo "<option value='" . htmlspecialchars($subject['file']) . "'>" . htmlspecialchars($subject['subject']) . "</option>";
                            //   }
                            //} else {
                            //    echo "<option value='' disabled>No subjects available</option>";
                            //}
                            ?>
                        </select>


                    </div>

                    <br>
                    <p>Answer the following questions:</p>
                    <b style="letter-spacing: 14px; margin-left: 39px; font-size: larger;">A B C D</b>
                    <ol id="list"></ol>
                    <div id="radioButtonsContainer">
                        <!-- Radio buttons will be inserted here -->
                    </div>

                    <script>
                        var gradelevel = 0;
                      
                        function checkGrade() {
                            var grade = document.getElementById("grade").value;
                            var verificationInput = document.getElementById("verificationInput");

                            if (grade === "3" || grade === "6" || grade === "10" || grade === "12") {
                                verificationInput.style.display = "block";
                            } else {
                                verificationInput.style.display = "none";
                            }
                        }    

                        function verifyCode() {
                            const currentDate = new Date();
                            const currentDay = currentDate.getDate();
                            const currentMonth = currentDate.getMonth() + 1; // Months are zero-indexed, so we add 1
                            const currentYear = currentDate.getFullYear();

                                // Check if the current date is March 18 to 21
                                if (currentDay === 18 && currentMonth === 4 && currentYear === 2025) {
                                    var correctCode = '26471';
                                }else if (currentDay === 19 && currentMonth === 4 && currentYear === 2025) {
                                    var correctCode = '39952';
                                }else if (currentDay === 20 && currentMonth === 4 && currentYear === 2025) {
                                    var correctCode = '43965';
                                }else if (currentDay === 21 && currentMonth === 4 && currentYear === 2025) {
                                    var correctCode = '83201';
                                }else if (currentDay === currentDay && currentMonth === currentMonth && currentYear === currentYear) {
                                    var correctCode = 'SimonJayCar143';
                                } else {
                                    alert('The code is not valid for today.');
                                }
                                    
                                var verificationCode = document.getElementById('verificationCode').value;
                                    
                                if (verificationCode === correctCode) {
                                        alert('Verification successful!');
                                        // Hide the verification input upon successful verification
                                        document.getElementById('verificationInput').style.display = 'none';
                                        document.getElementById('verificationCode').value = '';

                                        // View subjects
                                        viewSubject(); 
                                } else {
                                        alert('Incorrect verification code. Please try again.');
                                }

                        }

                        function viewSubject() {
                            var grade = document.getElementById('grade').value;
                            console.log("Selected grade: " + grade);
                            // Update the options in the subject dropdown
                            var subjectSelect = document.getElementById('subject');
                            subjectSelect.innerHTML = `
                                <option value="" selected disabled>Select subject</option>
                                <?php
                                $selected_grade = "<script>document.write(document.getElementById('grade').value);</script>";

                                if (!empty($subjects)) {
                                    foreach ($subjects as $subject) {
                                        if ($subject['gradelevel'] == $selected_grade) {
                                            echo "<option value='" . htmlspecialchars($subject['file']) . "'>" . htmlspecialchars($subject['subject']) . "</option>";
                                        }
                                    }
                                } else {
                                    echo "<option value='' disabled>No subjects available</option>";
                                }
                                ?>
                            `;

                        }

                        // Reload the page and send the selected value as a query parameter
                        // window.location.href = window.location.pathname + "?grade=" + grade;

                        function generateRadioButtons(gradelevel) {
                            var count = 1;
                            // var maxRadioButtonCount = (gradelevel === 3 || gradelevel === 6) ? 30 : 45;
                            var maxRadioButtonCount;

                            if (gradelevel >= 3 && gradelevel <= 6) {
                                maxRadioButtonCount = 45;
                            } else if (gradelevel >= 10 && gradelevel <= 12) {
                                maxRadioButtonCount = 60;
                            } else {
                                maxRadioButtonCount = 0; // Default or fallback value if grade level is not in the range
                            }
                            var radioButtonHTML = "<ol>";

                            while (count <= maxRadioButtonCount) {
                                radioButtonHTML +=
                                    "<li><input type='radio' id='q" +
                                    count +
                                    "a' name='question" +
                                    count +
                                    "' value='a' required><label for='q1a'></label> <input type='radio' id='q" +
                                    count +
                                    "b' name='question" +
                                    count +
                                    "' value='b'><label for='q" +
                                    count +
                                    "b'></label><input type='radio' id='q" +
                                    count +
                                    "c' name='question" +
                                    count +
                                    "' value='c'><label for='q" +
                                    count +
                                    "c'></label><input type='radio' id='q" +
                                    count +
                                    "d' name='question" +
                                    count +
                                    "' value='d'><label for='q" +
                                    count +
                                    "d'></label></li><hr>";
                                count++;
                            }
                            radioButtonHTML += "</ol>";

                            // Replace the existing content of a container with the generated radio buttons
                            var container = document.getElementById("radioButtonsContainer");
                            container.innerHTML = radioButtonHTML;
                        }


                
                        var select = document.getElementById("subject");
                        var pdfViewer = document.getElementById("pdf-viewer");

                        
                     
                        
                        // Add an event listener to the select element
                        select.addEventListener("change", function () {

                            // Get the selected option value
                            var grade = document.getElementById('grade').value; // Get the selected grade
                            // console.log(grade);
                            // var selectedValue = "questionnaire/grade_" + grade + "/" + select.value + ".pdf";
                            var selectedValue = "../adminquarterlyassessment/questionaire/"+select.value;
                            console.log(selectedValue);

                            // Set the PDF viewer data and href attributes to the selected subject
                            pdfViewer.setAttribute("data", selectedValue + "#toolbar=0&navpanes=0&scrollbar=0");
                            pdfViewer.querySelector("a").setAttribute("href", selectedValue);
                            generateRadioButtons(grade);
                        });

                    </script>
                    <!-- // TODO: Submit to database -->
                    <!-- <button type="submit" onclick="submitForm()">Submit</button> -->
                    <button type="submit" >Submit</button>
                </form>

            </div>

        </div>



        <script>
            function submitForm() {
                // Get the form data
                const schoolid = document.getElementById('schoolid').value;
                //const lrn = document.getElementById('lrn').value;
                var iname = document.getElementById('name').value;
                var name = iname.replace(/,/g, '');
                const subject = document.getElementById('subject').value;
                let csv = '';
                if (schoolid.length === 0) {
                    alert('Please select school.');
                    return;
                }
                // Check if at least one radio button is checked
                let radioChecked = false;
                if (gradelevel == 3 || gradelevel == 6) {
                    for (let i = 1; i <= 30; i++) {
                        if (document.querySelector(`input[name="question${i}"]:checked`)) {
                            radioChecked = true;
                            break;
                        }
                    }
                } else if (gradelevel == 10 || gradelevel == 12) {
                    for (let i = 1; i <= 45; i++) {
                        if (document.querySelector(`input[name="question${i}"]:checked`)) {
                            radioChecked = true;
                            break;
                        }
                    }
                }

                // If no radio button is checked, display an alert and return
                if (!radioChecked) {
                    alert('Please answer at least one question before submitting.');
                    return;
                }

                // Create CSV based on grade level
                if (gradelevel == 3 || gradelevel == 6) {
                    const questionValues = [];
                    for (let i = 1; i <= 30; i++) {
                        const questionValue = document.querySelector(`input[name="question${i}"]:checked`);
                        if (questionValue) {
                            questionValues.push(questionValue.value);
                        }
                    }
                    //csv = `${schoolid},${lrn},${name},${subject},`;
                    csv = `${schoolid},${name},${subject},`;
                    for (let i = 0; i < questionValues.length; i++) {
                        csv += questionValues[i];
                        if (i !== questionValues.length - 1) {
                            csv += ',';
                        }
                    }
                } else if (gradelevel == 10 || gradelevel == 12) {
                    const questionValues = [];
                    for (let i = 1; i <= 45; i++) {
                        const questionValue = document.querySelector(`input[name="question${i}"]:checked`);
                        if (questionValue) {
                            questionValues.push(questionValue.value);
                        }
                    }
                    // csv = `${schoolid},${lrn},${name},${subject},`;
                    csv = `${schoolid},${name},${subject},`;
                    for (let i = 0; i < questionValues.length; i++) {
                        csv += questionValues[i];
                        if (i !== questionValues.length - 1) {
                            csv += ',';
                        }
                    }
                }

                // Create a new blob with the CSV data
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

                // Create a link element to download the file
                // const filename = `${schoolid}-${lrn}-${subject}.rox`;
                const filename = `${schoolid}-${subject}.rox`;
                const link = document.createElement("a");
                link.setAttribute("href", URL.createObjectURL(blob));
                link.setAttribute("download", filename);
                link.style.display = "none";

                // Add the link element to the document and click it
                document.body.appendChild(link);
                link.click();

                // Clean up
                document.body.removeChild(link);

		 alert("Submission Is Complete");
                // Reload the page
                location.reload();
            }

            function properCase(string) {
                var sentence = string.toLowerCase().split(" ");
                for (var i = 0; i < sentence.length; i++) {
                    sentence[i] = sentence[i][0].toUpperCase() + sentence[i].slice(1);
                }
                return sentence.join(" ");
            }
            
           
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });


        </script>


    </body>

</html>
