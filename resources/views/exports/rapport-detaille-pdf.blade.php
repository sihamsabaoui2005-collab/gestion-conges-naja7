<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>{{ $rapport->titre }}</title>
@include('exports.partials.style')
</head>
<body>
@include('exports.partials.body-detaille', ['rapport' => $rapport])
</body>
</html>