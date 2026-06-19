<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Resident Indigency</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #page-wrapper {
            width: 60%;
            height: auto;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            page-break-inside: avoid;
        }
        .logo-left {
            position: absolute;
            top: 10px;
            left: 10px;
            width:  170px;
            height:  170px;
        }
        .logo-right {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 170px;
            height: 170px;
        }
        .header {
            text-align: center;
            font-family: Tahoma;
            font-size: 16px;
            margin-top: 20px;
            border-bottom: 1px solid red;
            padding-bottom: 10px;
        }
        .office-title {
            font-family: Arial;
            font-size: 24px;
            text-align: center;
            margin-top: 50px;
        }
        .certificate-title {
            font-size: 38px;
            font-family: Tahoma;
            margin-top: 26px;
            text-align: center;
            text-decoration: underline;
        }
        .content {
            font-size: 27px;
            margin-top: 50px;
            text-align: justify;
        }
        .captain {
            font-size: 28px;
            margin-top: 50px;
        }
        .content, .captain {
            margin-left: 40px;
            margin-right: 40px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
        }
        .footer .progresibo {
            color: darkblue;
            font-size: 35px;
            font-weight: bolder;
        }
        .footer .malinao {
            color: darkred;
            font-size: 35px;
            font-weight: bolder;
        }
        .footer-line {
            border-top: 2px solid #000;
            margin-top: 20px;
        }
        .print-btn {
            margin-top: 15px;
            text-align: center;
        }
        .noprint {
            display: none;
        }
        @media print {
            .print-btn {
                display: none;
            }
            #page-wrapper {
                width: 100%;
                height: auto;
                margin: 0;
                padding: 20px;
                border: none;
                background-color: #fff;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
<?php
    $RS_ID = htmlspecialchars($_GET['RS_ID']);
    $requesterName = htmlspecialchars($_GET['requesterName']);
    $voterStatus = htmlspecialchars($_GET['voterStatus']);
    $fullname = htmlspecialchars($_GET['fullname']);
    $age = htmlspecialchars($_GET['age']);
    $address = htmlspecialchars($_GET['address']);
    $purpose = htmlspecialchars($_GET['purpose']);
    $dateIssued = htmlspecialchars($_GET['dateIssued']);
    ?>
    <div class="print-btn">
        <button style="padding: 10px;" onclick="window.print()">Print</button>
        <button style="padding: 10px;" onclick="window.location.href='Indigency.php'">Cancel</button>
    </div>

    <div id="page-wrapper">
        <div style="position: relative;">
            <img src="../images/BbrgyMalinaoLogo.png" alt="Logo Left" class="logo-left">
            <img src="../images/BbrgyMalinaoLogo.png" alt="Logo Right" class="logo-right">
            <div class="header">
                <span style="font-size: 20px;"><b>REPUBLIC OF THE PHILIPPINES</b><br>
                <span style="font-size: 20px;"><b>CITY OF PASIG</b></span><br>
                <span style="font-size: 30px;"><b>BARANGAY MALINAO</b></span><br>
                <span style="font-size: 16px;">Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</span><br>
                <span style="font-size: 16px;"><i>https://www.facebook.com/ProgresibongBarangayMalinao</i></span><br>
                <span style="font-size: 16px;"><i>malinaopasig.wixsite.com/progresibo</i></span><br>
                <span style="font-size: 16px;"><i>Tel no.: 8-461-6672 / 8-632-7605</i></span>
                </p>
            </div>

            <div class="certificate-title">
                <br><b>CERTIFICATE OF INDIGENCY</b><br><br>
            </div>

            <div class="content">
                <p>This is to certify that <b><?php echo $fullname; ?></b>, minor, whose parent/guardian <?php echo $requesterName; ?>, and 
                <?php 
                    if (strtolower($voterStatus) == "yes") {
                        echo "a registered voter";
                    } else {
                        echo "not a registered voter";
                    }
                ?> 
                of this barangay presently residing at <?php echo $address; ?> and he/she belongs to the indigent family.</p>
                <p>This certification is being issued upon the request of <?php echo $requesterName; ?>, parent/guardian of <?php echo $fullname; ?> in regards to <?php echo $purpose; ?>.</p>
                <p>Issued this <b><?php echo $dateIssued; ?></b> at the office of the Barangay Chairperson, Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</p>
            </div>

            <div class="captain">
                <br><br><br><b>JOEL S. DELA CRUZ</b><br>
                <p style="font-size: 16px;">BARANGAY CAPTAIN</p><br><br><br><br>
            </div>

            <div class="footer-line"></div>

            <div class="footer">
                <p class="progresibo">PROGRESIBONG</p>
                <p class="malinao">MALINAO</p>
            </div>
        </div>
    </div>
</body>
</html>
