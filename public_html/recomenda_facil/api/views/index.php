<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Teste API</title>

	<!-- Bootstrap -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div class="row">
	<div class="container">
		<div class="row">
			<div class="nav navbar navbar-header ">
				<div class="navbar-fixed-top top">
					<div class="col-md-12 text-center">
						<div class="row">
							<h4>Teste API</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="">
				<div class="form-group">
					<div class="col-md-12">
						USAR O POSTMAN P/ PUT<br><br>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<!-- PUT method -->
						<form method="GET" action="/api/api/">
							<h5>Teste GET</h5>
							<div class="col-md-4">
								<input type="hidden" name="_METHOD" value="GET" />
								<input class="form-control" type="text" name="labId" value="2" placeholder="lab id" />
								<input class="form-control" type="text" name="labUser" value="daniel.loverde@gmail.com" placeholder="lab user" />
								<input class="form-control" type="password" name="labPass" value="464235" placeholder="lab pass" />
								<textarea name="jsonString" placeholder="json string">{
    "samples":
        {
            "sample_01": {
                "sampleId": "00112/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            },
            "sample_02": {
                "sampleId": "00113/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            },
            "sample_03": {
                "sampleId": "00114/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            }

        },
    "sampleCount" : 3
}</textarea>
							</div>
							<div class="col-md-2">
								<button class="btn btn-default btn-primary" type="submit">ENVIAR</button>
							</div>
						</form>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<!-- POST method -->
						<form method="POST" action="/api/api/">
							<h5>Teste POST</h5>
							<div class="col-md-4">
								<input type="hidden" name="_METHOD" value="POST" />
								<input class="form-control" type="text" name="labId" value="2" placeholder="lab id" />
								<input class="form-control" type="text" name="labUser" value="daniel.loverde@gmail.com" placeholder="lab user" />
								<input class="form-control" type="password" name="labPass" value="464235" placeholder="lab pass" />
								<textarea name="jsonString" placeholder="json string">{
    "samples":
        {
            "sample_01": {
                "sampleId": "00112/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            },
            "sample_02": {
                "sampleId": "00113/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            },
            "sample_03": {
                "sampleId": "00114/2012",
                "spectrophotometer": "NIR 001",
                "date": "2016-10-01",
                "time": "13:00:00",
                "sampType": 121,
                "materialType": "soil",
                "spectro": {
                    "001": 20202,
                    "001 ": 20202,
                    "001": 20202,
                    "001": 20202
                },
                "spectroCount" : 4
            }

        },
    "sampleCount" : 3
}</textarea>
							</div>
							<div class="col-md-2">
								<button class="btn btn-default btn-primary" type="submit">ENVIAR</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>