<br><br>
	<div class="contents" style="max-width: 600px; margin: 0 auto; border: 2px solid #000036;">

<div class="header" style="background-color: #000036; padding: 15px; text-align: center;">
	<div class="logo" style="width: 260px;text-align: center; margin: 0 auto;">
	<img src="{{asset('assets/user/interfaceControl/logoIcon/footer_logo.jpg')}}" alt="footer-logo">
	<br></div>
</div>

<div class="mailtext" style="padding: 30px 15px; background-color: #f0f8ff; font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 26px;">

Hello,<br>
<br>
<ul>
 <li>Nom: {{ $nom_client }}</li>
 <li>Adresse: {{ $phone_client }}</li>
 <li>Email:  {{ $adress_email }}</li>
</ul>
 <br>
 <p>Sujet : {{ $subject_client }}</p>

<br><br>
{!! $message_client !!}
<br><br>
<br><br>
</div>

<div class="footer" style="width: 597px;background-color: #000036; padding: 15px; text-align: center;max-width: 600px;">
<a href="https://bizzplace.fr/" style="	background-color: #2ecc71;
	padding: 10px 0;
	margin: 10px;
	display: inline-block;
	width: 100px;
	text-transform: uppercase;
	text-decoration: none;
	color: #ffff;
	font-weight: 600;
	border-radius: 4px;">Site web</a>
<a href="https://bizzplace.fr/products" style="	background-color: #2ecc71;
	padding: 10px 0;
	margin: 10px;
	display: inline-block;
	width: 100px;
	text-transform: uppercase;
	text-decoration: none;
	color: #ffff;
	font-weight: 600;
	border-radius: 4px;">Produit</a>
<a href="https://bizzplace.fr/contact" style="	background-color: #2ecc71;
	padding: 10px 0;
	margin: 10px;
	display: inline-block;
	width: 100px;
	text-transform: uppercase;
	text-decoration: none;
	color: #ffff;
	font-weight: 600;
	border-radius: 4px;">Contact</a>
</div>
<div class="footer" style="width: 597px;background-color: #000036; padding: 15px;padding-left:0px;padding-right:0px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.2);">
<strong style="color: #fff;">© Copyright <script>document.write(new Date().getFullYear())</script> . All Rights Reserved.</strong>
<p style="color: #ddd;">{{ config('app.name') }} n'est associé à aucun autre
entreprise ou personne. Nous travaillons en équipe et n'avons aucun revendeur,
distributeur ou partenaire...</p>
</div>
</div>
<br><br>
