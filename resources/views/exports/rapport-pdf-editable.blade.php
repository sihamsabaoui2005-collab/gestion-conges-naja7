<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>{{ $rapport->titre }}</title>
@include('exports.partials.style')
</head>
<body>
<div class="report-doc">
{!! $rapport->contenu_html !!}
</div>
</body>
</html>