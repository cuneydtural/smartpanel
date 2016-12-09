<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ücretsiz Deneyin Formu</title>
</head>
<body>

<table width="500" border="1">
    <tr>
        <td>Ad Soyad</td>
        <td>{{ @$data['name'] }}</td>
    </tr>
    <tr>
        <td>E-Mail</td>
        <td>{{ @$data['email'] }}</td>
    </tr>
    <tr>
        <td>Telefon</td>
        <td>{{ @$data['phone'] }}</td>
    </tr>
    <tr>
        <td>Ürün</td>
        <td>{{ @$data['message'] }}</td>
    </tr>
    <tr>
        <td>Tarih</td>
        <td>{{ \Carbon\Carbon::now() }}</td>
    </tr>
</table>

<p><b>ihlaspazarlama.com.tr</b> üzerinden gönderildi.</p>


</body>
</html>