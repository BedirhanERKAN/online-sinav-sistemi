<?php

    try {
        $pdo= new PDO("mysql:host=localhost;dbname=TABLO_ADI;charset=utf8","VERİ_TABANİ_KULLANICI_ADI","VERİ_TABANİ_KULLANICI_ŞİFRESİ@",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    } catch ( PDOException $hata ){
        print $hata->getMessage();
    }

    $pdo->query("SET CHARACTER SET utf8");
    $pdo->query("set names utf8");
    
 
    $stmt = $pdo->prepare("SELECT * FROM results_db LEFT JOIN students_db ON students_db.students_id=results_db.results_students_id LEFT JOIN question_db ON question_db.question_id= results_question WHERE results_students_id IN ( SELECT students_id FROM students_db WHERE  students_no = :students_no) ");
    $stmt->execute(array("students_no" => $_GET['no']));
    $detayliSonuc = $stmt->fetchall();
    
?>


<html>
    <head>
            <style>
                html, body, div, span, applet, object, iframe,
                h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                a, abbr, acronym, address, big, cite, code,
                del, dfn, em, img, ins, kbd, q, s, samp,
                small, strike, strong, sub, sup, tt, var,
                b, u, i, center,
                dl, dt, dd, ol, ul, li,
                fieldset, form, label, legend,
                table, caption, tbody, tfoot, thead, tr, th, td,
                article, aside, canvas, details, embed, 
                figure, figcaption, footer, header, hgroup, 
                menu, nav, output, ruby, section, summary,
                time, mark, audio, video {
                    margin: 0;
                    padding: 0;
                    border: 0;
                    font-size: 100%;
                    font: inherit;
                    vertical-align: baseline;
                }
                /* HTML5 display-role reset for older browsers */
                article, aside, details, figcaption, figure, 
                footer, header, hgroup, menu, nav, section {
                    display: block;
                }
                body {
                    line-height: 1;
                }
                ol, ul {
                    list-style: none;
                }
                blockquote, q {
                    quotes: none;
                }
                blockquote:before, blockquote:after,
                q:before, q:after {
                    content: '';
                    content: none;
                }
                table {
                    border-collapse: collapse;
                    border-spacing: 0;
                }


                html{
                    margin:0 20%;
                    background-color:#fcfcfc;
                    color:White;
                    font-size:38px;
                    color:#979baf;
                    font-family:Sans-Serif;
                    
                }

              

                .siralama
                {
                    background-color:#fdfeff;
                    height:100px;
                    width:98%;
                    margin:10px 0 10px 0 ;
                    padding:20px 0 20px 20px;
                    border-radius:5px;
                    border:1px  solid #eee ;
                }
                
                .header
                {
                    background-color:#4367e7;
                    width:100%;
                    height:150px;
                    margin-top:10px;
                    border-top-left-radius:10px;
                    border-top-right-radius:10px;
                    
                }
                .wordwrap { 
                        white-space: pre-wrap;      /* CSS3 */   
                        white-space: -moz-pre-wrap; /* Firefox */    
                        white-space: -pre-wrap;     /* Opera <7 */   
                        white-space: -o-pre-wrap;   /* Opera 7 */    
                        word-wrap: break-word;      /* IE */
                }

                

            </style>
    </head>
    <body>


            <div class="header">
                    <h5 style="text-align:center; padding:5%; color:#fff;"> <?php echo ( $detayliSonuc[0]['students_firstName']." ". $detayliSonuc[0]['students_lastName']  ); ?> </h5>
            </div>

        
        <?php  foreach($detayliSonuc as $key=>$val){ ?>


            <div class="siralama" style=" background-color:#4367e7 !important; color:white;">
                
                <?php echo $val['question_question'];  ?>
      
            </div>

            <div class="siralama">
         
                <div style="float:left; margin-left:1%; width:80%;" class="wordwra">  <?php echo $val['results_answer']; ?> </div>

                <?php if($val['result_true'] ){ ?> 
                    <div style=" float:right; margin-right:5%; color:#3fd7ac;"> DOĞRU </div>
                <?php }else{ ?>
                    <div style=" float:right; margin-right:5%; color:#d73f3f;"> YANLIŞ </div>
                <?php }  ?>
       
            </div>
        

        <?php  } ?>


             
    </body>
</html>

    
       