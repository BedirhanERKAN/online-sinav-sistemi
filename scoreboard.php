<?php
    ob_start();


    try {
        $pdo= new PDO("mysql:host=localhost;dbname=TABLO_ADI;charset=utf8","VERİ_TABANİ_KULLANICI_ADI","VERİ_TABANİ_KULLANICI_ŞİFRESİ@",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    } catch ( PDOException $hata ){
        print $hata->getMessage();
    }


    $pdo->query("SET CHARACTER SET utf8");
    $pdo->query("set names utf8");
    
 
    $stmt = $pdo->prepare("SELECT students_no, students_firstName, students_lastName , results_students_id , COUNT(*) as dogruSoruSayisi FROM results_db LEFT JOIN students_db ON students_db.students_id=results_db.results_students_id WHERE result_true=1 GROUP BY results_students_id ORDER BY dogruSoruSayisi DESC");
    $stmt->execute();
    $skorlar = $stmt->fetchall();
    
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
                    height:40px;
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
                

            </style>
    </head>
    <body>


            <div class="header">
                    <h5 style="text-align:center; padding:5%; color:#fff;">SKOR TABLOSU</h5>
            </div>
        
        <?php $i=1; foreach($skorlar as $key=>$val){ ?>

            <div class="siralama">
                <div style="float:left; margin-left:0; color:#979baf; text-decoration:none;">
                    <a href="detayli_sonuc.php?no=<?php echo $val['students_no']; ?>">
                        <?php echo $val['students_no']; ?>
                    </a>
                </div> 
                <div style="float:left; margin-left:10%;"><?php echo $val['students_firstName']; ?> <?php echo $val['students_lastName']; ?></div>
                <div style=" float:right; margin-right:10%; color:#3fd7ac;"><?php echo round($val['dogruSoruSayisi']*(10/15),1); ?> <b style="font-size:18px;">Puan</b></div>
            </div>
        

        <?php   } ?>


             
    </body>
</html>

    <?php

        $icerik = ob_get_contents();
        ob_end_clean();
        ob_end_flush();


        $file = "skortablosu.html";
        $fw = fopen($file, "w");
        fputs($fw,$icerik, strlen($icerik));
        fclose($fw);

    ?>

    