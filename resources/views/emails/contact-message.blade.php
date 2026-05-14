<h1>Nouveau message depuis Au-delà des faits</h1>

<p><strong>Nom :</strong> {{ $data['name'] }}</p>
<p><strong>Email :</strong> {{ $data['email'] }}</p>

@if(!empty($data['organization']))
    <p><strong>Organisation :</strong> {{ $data['organization'] }}</p>
@endif

<p><strong>Sujet :</strong> {{ $data['subject'] }}</p>

<p><strong>Message :</strong></p>
<p>{{ $data['message'] }}</p>
