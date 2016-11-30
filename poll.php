<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Голосование</title>
</head>

<body>
В какие дни вы можете играть в мтг? (Выберите несколько вариантов, можете даже все)
<form action="results.php" id="poll" name="poll" method="post"> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="mo"> Понедельник <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="tu"> Вторник <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="we"> Среда <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="th"> Четверг <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="fr"> Пятница <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="saMorning"> Суббота до обеда <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="saAfternoon"> Суббота после обеда <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="saEvening"> Суббота вечером <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="suMorning"> Воскресенье до обеда<br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="suAfternoon"> Воскресенье после обеда <br> 
 <input type="checkbox" id='dayspoll' name="dayspoll[]" value="suEvening"> Воскресенье вечером <br> 
 <br> 
 <input type="submit" value="Голосовать"> 
</form>

</body>
</html>

