@component('mail::message')



<br><br>
	<div class="contents" style="max-width: 600px; margin: 0 auto; border: 2px solid #000036;">

<div class="header" style="background-color: #000036; padding: 15px; text-align: center;">
	<div class="logo" style="width: 260px;text-align: center; margin: 0 auto;"><br></div>
</div>

<div class="mailtext" style="padding: 30px 15px; background-color: #f0f8ff; font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 26px;">
@component('mail::panel')    
<center>
<p>Hello M/Mme/Mlle: <strong>{{ $nom_employe }} {{ $prenom_employe}}</strong>, </p><br>
<p>Vous venez de reçevoir votre carte privilège de la part de votre structure {{ $nom_entreprise }}<br></p>
<center><a class="btn btn-default">{{ $code_privilege }}</a><br>
<p>Durée de validité : <strong>{{ $dure_cart }} jours</strong> à partir de la date de reception.</p>
Merci...
</center>
</center>
@endcomponent
<br><br>
<br><br>
</div>

<div class="footer" style="background-color: #000036; padding: 15px; text-align: center;max-width: 600px;">
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


<div class="footer" style="background-color: #000036; padding: 15px; text-align: center; border-top: 1px solid rgba(255, 255, 255, 0.2);">

<strong style="color: #fff;">© Copyright <script>document.write(new Date().getFullYear())</script> . All Rights Reserved.</strong>
<p style="color: #ddd;">{{ config('app.name') }} n'est associé à aucun autre
entreprise ou personne. Nous travaillons en équipe et n'avons aucun revendeur,
distributeur ou partenaire...</p>

</div>
</div>
<br><br>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
