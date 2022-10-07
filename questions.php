<?php
include("./header.php");
include("./utils/api.php");
//get random question


//Random vraag ophalen.
$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());
if (!isset($getQuestionRes) || !isset($getQuestionRes->success) || !$getQuestionRes->success) {
    //error.
    echo "error!";
    return;
}

$question = $getQuestionRes->data;
// var_dump($question);

if (!isset($question)) {
    //handled all questions.
    //TODO: send to next page?

    header("Location: /");
}


function buildTextInputField($questionId) {
    echo "<form action='/server/scavengerHunt/questions/textQuestion.php' method='POST'>";
    echo "<legend>Antwoord:</legend>";
    echo "<textarea name='text-answer'></textarea>";
    echo "<br>";
    echo "<input hidden value='" . $questionId . "' required name='question-id'>";
    echo "<button type='submit' class='login-register-btn' name='submit'>Inleveren</button>";
    echo "</form>";
}

function buildPhotoInputField($questionId) {
    echo "<form action='/server/scavengerHunt/questions/photoQuestion.php' method='POST' enctype='multipart/form-data'>";
    echo '    <div class="container">
    <div class="wrapper">
       <div class="image">
          <img src="" alt="">
       </div>
       <div class="content">
          <div class="icon">
             <i class="fas fa-cloud-upload-alt"></i>
          </div>
          <div class="text">
             Nog geen fotos gekozen!
          </div>
       </div>
       <div id="cancel-btn">
          <i class="fas fa-times"></i>
       </div>
       <div class="file-name">
          File name here
       </div>
    </div>
    <input id="default-btn" type="file" hidden>';
    echo "<input type='file' onclick='defaultBtnActive()' class='buttonep' name='image-answer' accept='image/png, image/jpeg'>";
    echo "<button type='submit' class='login-register-btn' name='submit'>Inleveren</button>";
    echo "</form>";

    echo '
    <script>
       const wrapper = document.querySelector(".wrapper");
       const fileName = document.querySelector(".file-name");
       const defaultBtn = document.querySelector("#default-btn");
       const customBtn = document.querySelector("#custom-btn");
       const cancelBtn = document.querySelector("#cancel-btn i");
       const img = document.querySelector("img");
       let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
       function defaultBtnActive(){
         defaultBtn.click();
       }
       defaultBtn.addEventListener("change", function(){
         const file = this.files[0];
         if(file){
           const reader = new FileReader();
           reader.onload = function(){
             const result = reader.result;
             img.src = result;
             wrapper.classList.add("active");
           }
           cancelBtn.addEventListener("click", function(){
             img.src = "";
             wrapper.classList.remove("active");
           })
           reader.readAsDataURL(file);
         }
         if(this.value){
           let valueStore = this.value.match(regExp);
           fileName.textContent = valueStore;
         }
       });
    </script>';
}

?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">
            <?php echo $question->question ?>
        </h2>
    </div>


    <?php $question->type == "TEXT" ? buildTextInputField($question->questionId) : buildPhotoInputField($question->questionId) ?>

</div>