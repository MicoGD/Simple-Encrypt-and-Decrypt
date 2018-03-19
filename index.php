<!DOCTYPE html>
<html>
<head>
	<title>Classical Encrypted Algorithm</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
   	<link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
   	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   	<link href="style.css" rel="stylesheet">
</head>
<body>
	<section id="contact">
			<div class="section-content">
				<h1 class="section-header">Program <span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s">Enkripsi dan Dekripsi Chiper</span></h1>
				
			</div>
			<div class="contact-section">
				<div class="container">
					<form method="post" action="logic.php">
						<div class="col-md-12">
							<div class="setengah container">
								<div class="form-group" align="left">
									<label for="exampleInputUsername">Metode</label>
									<select class="warna" name="pilihan2">
										<option value="enk">Enkripsi</option>
										<option value="dek">Dekripsi</option>
									</select>
								</div>
					  			<div class="form-group" align="left">
					  				<label for="exampleInputUsername">Algoritma</label>
					  				<select class="warna" name="pilihan">
										<option value="Caesar">Caesar Chiper</option>
										<option value="Mono">Monoalphabetic Ciphers</option>
										<option value="Playfair">Playfair Cipher</option>
										<option value="Poly">Polyalphabetic Ciphers</option>
										<option value="Transpositioni">Transposition Technique (Rail Fence)</option>
									</select>
									<br>
								</div>
								
								<div class="form-group" align="left" >
									<input type="text" class="form-control" name="inputt" id="" placeholder="Masukkan Input" >
								</div>
								<div class="form-group" align="center">
									<button type="submit" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Process</button>
								</div>
							</div>
							<br>
					  	</div>
					</form>
				</div>
			</div>
	</section>
</body>
</html>