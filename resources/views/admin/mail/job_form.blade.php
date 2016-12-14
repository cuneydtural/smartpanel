<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Satış Temsilciliği Başvuru Formu</title>
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
        <td>Eğitim Durumu</td>
        <td>{{ @$data['education'] }}</td>
    </tr>
    <tr>
        <td>Askerlik Durumu</td>
        <td>{{ @$data['military_status'] }}</td>
    </tr>
    <tr>
        <td>Doğum Tarihi</td>
        <td>{{ @$data['birthday'] }}</td>
    </tr>
    <tr>
        <td>Tarih</td>
        <td>{{ \Carbon\Carbon::now() }}</td>
    </tr>
</table>

<p><b>ihlaspazarlama.com.tr</b> üzerinden gönderildi.</p>


</body>
</html>