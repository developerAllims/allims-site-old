<?php $codes = $_GET['code']; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/css/fonts.css">
	<style type="text/css">
		html,body{ margin:0 auto; padding: 0px; font-family:'Arial';  }
		.etiquetas{ width: 214.3mm; height: 277.8mm; padding: 1.6mm 1.6mm; border: 0px solid #000; margin:0 auto; page-break-after: always;  }
		.etiquetas .etiqueta{ width:86.36mm; height: 118.11mm; margin: 0; padding: 10mm; float: left; border-radius: 15px; color:#000; border: 0px solid #F00;}

		.destinatario{ font-size: 3.4mm; }
		.destinatario span{ width: 170px; height: 56px; line-height: 9.5mm; color: #FFF; background: url('/images/arrow_destinatario.png') center top no-repeat; padding: 0px 0px; display: inline-block; border-radius: 5px; text-align: center;}
		.destinatario span b{ margin: 0 10px; }

		.remetente{ font-size: 3.0mm; }

		iframe{ width: auto; height:80px; display: inline-block; margin: 0 auto; border: 0px solid #000; }

	</style>
</head>
<body>
	<?php include '../inc/list_impressao_selos.php'; ?>
</body>
</html>