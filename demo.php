<!DOCTYPE html>
<!--&copy; 2024 ICT Unit, Department of Education Region 10. All rights reserved.-->

<script src="assets/jszip.min.js"></script>
<script src="assets/zip-full.min.js"></script>
<script src="assets/rox-min.js"></script>


<html>

    <head>
        <title>CBRAT/RUQA Demo</title>
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
                    <h1>CBRAT/RUQA Demo Site</h1>
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

                        <label for="grade">Grade Level:</label>
                        <select id="grade" name="grade" required >
                            <option value="" disabled>Select grade</option>
                            <option value="3">Grade 3</option>
                            <option value="6">Grade 6</option>
                            <option value="10">Grade 10</option>
                            <option value="12">Grade 12</option>
                        </select>

                        <label for="schoolid">School ID:</label>
                        <select id="schoolid" name="schoolid" required>
                            <option value="" disabled selected>Select School</option>
                            <option value="A">School A</option>
                            <option value="B">School B</option>
                            <option value="C">School C</option>
                            <option value="D">School D</option>
                            <option value="E">School E</option>
                            <option value="F">School F</option>
                            <option value="G">School G</option>
                            <option value="H">School H</option>
                        </select>
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" placeholder="Juan dela Cruz" required />
                        <label for="subject">Subject:</label>
                            <select id="subject" name="subject" required>
                                <option value="" selected disabled>Select subject</option>
                                <option value="math">Mathematics</option>
                                <option value="science">Science</option>
                                <option value="english">English</option>
                                <option value="filipino">Filipino</option>
                                <option value="ap">Araling Panlipunan</option>
                                <option value="esp">Edukasyon sa Pagpapakatao</option>
                                <option value="mapeh">Music, Arts, PE, and Health</option>
                                <option value="tle">Technology and Livelihood Education</option>
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

    // Reload the page and send the selected value as a query parameter
    window.location.href = window.location.pathname + "?grade=" + grade;
    }

    




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
                            var selectedValue = "../CBRAT/demo_questionaire.pdf";
                            console.log(selectedValue);

                            // Set the PDF viewer data and href attributes to the selected subject
                            pdfViewer.setAttribute("data", selectedValue);
                            pdfViewer.querySelector("a").setAttribute("href", selectedValue);
                            generateRadioButtons(grade);
                        });

                    </script>
                    <!-- // TODO: Submit to database -->
                    <!-- <button type="submit" onclick="submitForm()">Submit</button> -->
                    <button type="button" onclick="location.reload();">Submit</button>
                </form>

            </div>

        </div>






    </body>

</html>
