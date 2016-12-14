<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Türkiye Gazetesi Abone Formu</title>
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
        <td>Sabit Telefon</td>
        <td>{{ @$data['phone'] }}</td>
    </tr>
    <tr>
        <td>Mobil</td>
        <td>{{ @$data['mobile'] }}</td>
    </tr>
    <tr>
        <td>İl</td>
        <td>{{ @$data['city'] }}</td>
    </tr>
    <tr>
        <td>İlçe</td>
        <td>{{ @$data['district'] }}</td>
    </tr>
    <tr>
        <td>Tarih</td>
        <td>{{ \Carbon\Carbon::now() }}</td>
    </tr>
</table>

<p><b>ihlaspazarlama.com.tr</b> üzerinden gönderildi.</p>


</body>
</html>