<?php

    header('Content-Type: application/javascript');

    try {
        $pdo= new PDO("mysql:host=localhost;dbname=TABLO_ADI;charset=utf8","VERİ_TABANİ_KULLANICI_ADI","VERİ_TABANİ_KULLANICI_ŞİFRESİ@",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    } catch ( PDOException $hata ){
        print $hata->getMessage();
    }


    $pdo->query("SET CHARACTER SET utf8");
    $pdo->query("set names utf8");
    
 
    $stmt = $pdo->prepare("SELECT * FROM question_db WHERE  question_sub_id = 0 and question_id>6");
    $stmt->execute();
    $questions = $stmt->fetchall();
    
    $questionData = null;
    foreach($questions as $key=>$val)  
    {

        $stmt = $pdo->prepare("SELECT * FROM question_db WHERE  question_sub_id = :sub_id");
        $stmt->execute(array('sub_id' => $val['question_id']));
        $questionsAnswer = $stmt->fetchall();
        
        
        $questionsAnswers = null;
        foreach($questionsAnswer as $keys=>$vals)  
        {
            $questionsAnswers[] = '"'.$vals['question_question'].'"';
            
            if($vals['question_truAnswer']==1)
            {
                $questionsTrueAnswer = $vals['question_question'];
            }
        }
    
        shuffle($questionsAnswers);
        
        $questionData[] = '{questions: [{type: "radiogroup",name: "question_'.$val['question_id'].'",title: "'.$val['question_question'].'",choices: ['.join(",",$questionsAnswers).'],correctAnswer: ""}]}';
 
    }
  
    /*


     

    */
?>

var json = {
    title: "Online Sınav Sistemi v0.0.1",
    showProgressBar: "bottom",
    showTimerPanel: "top",
    maxTimeToFinishPage: 30,
    maxTimeToFinish: 420,
    firstPageIsStarted: true,
    startSurveyText: "Sınava Başla",
    pages: [
        {
            questions: [
                {
                    type: "html",
                    html: "Merhaba, <br><br> Her soru için size otomatik olarak bir süre verilmektedir ve bu süreyi anlık olarak görebileceksiniz. <br> Sürenin tamamlanması durumunda otomatik olarak bir sonraki soruya geçecektir.. <br> Sınav soruları ve cevapları kişiden kişiye göre rastgele olacak şekilde ayarlanmıştır. <br><br> Sınava başlamak için hazır iseniz sağ altta yer alan <b style='color:green;'>'Sınava Başla'</b>  butonuna basarak sınava başlayabilirsiniz. <br><br>  <b style='color:green;'><h4>SINAVDA BAŞARILAR.</h4></b>"
                },
                {
                    type: "text",
                    name: "firstName",
                    title: "Ad:",
                    isRequired: true,
                   
                },
                {
                    type: "text",
                    name: "lastName",
                    title: "SOYAD :",
                    isRequired: true,
                    
                }, {
                    type: "text",
                    name: "studentNumber",
                    title: "Öğrenci Numaranız",
                    isRequired: true,
                }   
            ]
        },
        {questions: [{type: "radiogroup",name: "question_1",title: "'NE MUTLU … DİYENE' M.Kemal Atatürk",choices: ['TÜRKÜM','TÜRKÜM','TÜRKÜM','TÜRKÜM'],correctAnswer: "TÜRKÜM"}]}
        ,
        {questions: [{type: "radiogroup",name: "question_6",title: " 'Hiçbir şeye muhtaç değiliz, yalnız tekbir şeye ihtiyacımız vardır; … olmak.' M.Kemal Atatürk",choices: ['çalışkan','tembel','aptal','iki yüzlü'],correctAnswer: "çalışkan"}]}
        ,
        <?php shuffle($questionData); echo join(',',$questionData); ?>  
    ],
    completedHtml: "<h4>SINAVI TAMAMLADINIZ!</h4>"
};

window.survey = new Survey.Model(json);

survey
    .onComplete
    .add(function (result) 
    {

        console.log(result.data);
        //document.querySelector('#surveyResult').textContent = JSON.stringify(result.data, null, 3);

        $.ajax({
                    url: 'questionAnswer.php',
                    type: 'POST',
                    dataType: 'json',
                    data: result.data,
                    success: function (gelenveri) {
                        console.log(gelenveri);
                        alert("TEBRİKLER, SINAVINIZ BAŞARILI BİR ŞEKİLDE KAYIT EDİLDİ");
                    },
                    error: function (hata) {
                        alert("HMM, SINAVINIZDA İLLEGAL BİRŞEYLER TESPİT EDİLDİ!");
                    }
                })
                
    });

$("#surveyElement").Survey({ model: survey });