<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>HTML Code128C Barcode</title>
    <script type="text/javascript" src="js/connectcode-javascript-code128c.js"></script>
    <style type="text/css">
      html,body{ margin: 0; padding: 0; }
  	#barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 12px}
    </style>
</head>
<body>
<div id="barcodecontainer" style="width:250px">
<div id="barcode" ><?php print $_GET['code']; ?></div>
</div>
<script type="text/javascript">
/* <![CDATA[ */
  function get_object(id) {
   var object = null;
   if (document.layers) {
    object = document.layers[id];
   } else if (document.all) {
    object = document.all[id];
   } else if (document.getElementById) {
    object = document.getElementById(id);
   }
   return object;
  }
get_object("barcode").innerHTML=DrawHTMLBarcode_Code128C(get_object("barcode").innerHTML,"yes","in",0,2.4,0.5,"bottom","center","","black","white");
/* ]]> */
</script>
</body>
</html>



