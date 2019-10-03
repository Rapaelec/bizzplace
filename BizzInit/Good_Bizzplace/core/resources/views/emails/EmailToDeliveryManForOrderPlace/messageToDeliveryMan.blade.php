@component('mail::message')

Vous avez reçu un message de: 

-M/Mlle: {{ $nom_client }}<br>
-Contact téléphonique : {{ $phone_client }}<br>
-Adresse email:  {{ $adress_email }}<br>
-Sujet : {{ $subject_client }}<br>

@component('mail::panel')
{{ $message_client }}
@endcomponent

{{ config('app.name') }}
@endcomponent