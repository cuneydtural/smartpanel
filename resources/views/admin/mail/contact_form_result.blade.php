<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biz Sizi Arayalım Formu</title>
</head>
<body>

<table width="500" border="1">
    <tr>
        <td>Ad Soyad</td>
        <td>{{ @$form['name'] }}</td>
    </tr>
    <tr>
        <td>E-Mail</td>
        <td>{{ @$form['email'] }}</td>
    </tr>
    <tr>
        <td>Telefon</td>
        <td>{{ @$form['phone'] }}</td>
    </tr>
    <tr>
        <td>Mesaj</td>
        <td>{{ @$form['message'] }}</td>
    </tr>
    <tr>
        <td>İl</td>
        <td>{{ @$form['city'] }}</td>
    </tr>
    <tr>
        <td>İlçe</td>
        <td>{{ @$form['district'] }}</td>
    </tr>
    <tr>
        <td>Tarih</td>
        <td>{{ \Carbon\Carbon::now() }}</td>
    </tr>
</table>

<p><b>ihlaspazarlama.com.tr</b> üzerinden gönderildi.</p>


</body>
</html>