<?php

    try {
        $pdo= new PDO("mysql:host=localhost;dbname=TABLO_ADI;charset=utf8","VERİ_TABANİ_KULLANICI_ADI","VERİ_TABANİ_KULLANICI_ŞİFRESİ@",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    } catch ( PDOException $hata ){
        print $hata->getMessage();
    }


    $pdo->query("SET CHARACTER SET utf8");
    $pdo->query("set names utf8");

    $fileName = $_POST['studentNumber']."_".time();
    $myfile = fopen("log/{$fileName }.txt", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($_POST));
    fclose($myfile);

    if( $_POST['studentNumber']>0 and strlen($_POST['studentNumber'])>7 )
    {

        $ogrenciAdi     =  $_POST['firstName'];
        $ogrenciSoyadi  =  $_POST['lastName'];
        $ogrenciNo      =  $_POST['studentNumber'];
    
        $stmt = $pdo->prepare("SELECT * FROM students_db WHERE  students_no = :no");
        $stmt->execute(array("no" => $ogrenciNo));
        $ogrenciBilgi = $stmt->fetch();

        $ogrenciID = $ogrenciBilgi['students_id'];

        if(!($ogrenciID>0))
        {
            // Öğrenci Kayıtlı Değil ise
            $stmt = $pdo->prepare("INSERT INTO students_db (students_firstName,students_lastName,students_no)VALUES(:firstname,:lastname,:no)");
            $stmt->execute(array(
                                    "firstname" => $ogrenciAdi,
                                    "lastname"  => $ogrenciSoyadi,
                                    "no"        => $ogrenciNo
                                ));

            $ogrenciID =  $pdo->lastInsertId();
        }

        unset($_POST['firstName']);
        unset($_POST['lastName']);
        unset($_POST['studentNumber']);

        foreach($_POST as $soruID=>$soruCevap)
        {

            $soruID = explode("_",$soruID);
            
            $stmt = $pdo->prepare("SELECT * FROM question_db WHERE  question_truAnswer = 1 and question_sub_id = :no");
            $stmt->execute(array("no" => $soruID[1]));

            $soruDogruCevap = $stmt->fetch();

            if($soruCevap==$soruDogruCevap['question_question'])
            {

                $soruDogrumu = 1;
            }else
            {
                $soruDogrumu = 0;
            }
                
            $stmt = $pdo->prepare("INSERT INTO results_db (results_students_id,results_question,results_answer,result_true)VALUES(:ogrenciNo,:soru,:cevap,:result_true)");
            $stmt->execute(array(
                                    "ogrenciNo"     => $ogrenciID,
                                    "soru"          => $soruID[1],
                                    "cevap"         => $soruCevap,
                                    "result_true"   => $soruDogrumu
                                ));
        }

         echo 1;
   
    }else
    {
        echo 0;
    }

?>
    
 
   