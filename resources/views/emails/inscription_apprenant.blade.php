{{-- <!DOCTYPE html>
<html>
<head>
    <title>Authentication Details</title>
</head>
<body>
    <p>Dear {{ $email }},</p>
    <p>Your account has been created. Here are your authentication details:</p>
    <p>Email: {{ $login }}</p>
    <p>Password: {{ $password }}</p>
    <p>Please change your password after logging in for the first time.</p>
    <p>Regards,<br>Team</p>
</body>
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <title>Inscription Apprenant</title>
</head>
<body>
    <p>Bonjour {{ $mailData['email'] }},</p>
    <p>Votre compte a été créé avec succès sur la plateforme. Voici vos informations de connexion :</p>
    <p><strong>Email :</strong> {{ $mailData['login'] }}</p>
    <p><strong>Mot de passe :</strong> {{ $mailData['password'] }}</p>

    <p>Vous pouvez vous connecter en utilisant le lien suivant :</p>
    <a href="{{ $mailData['lien_auth'] }}">Se connecter</a>

    <p>Votre QR code est également joint à cet email.</p>

    <p>Cordialement,<br>Equipe</p>
</body>
</html>
