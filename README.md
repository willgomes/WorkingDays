# WorkingDays

 This Class return only working days.
 
* @param string $working_day  format 'd/m/Y'
* @param int $ndays
* @return string format 'd/m/Y'


#How to use:

$date = new WorkingDays();

$date->working_day('02/04/2016', 3);

The return is a date string at this format d/m/Y


#That's it.
I created this class to practice and pass time.
Sorry for my english, I'm still learning...hahaha!

# Retorna uma data contando somente "dias úteis".

Essa classe retornar uma data a partir de X dias contando somente os dias uteis.
Além dos feriados nacionais é possível acrescentar no Array feriados municipais ou alguma data que não queira contar como dia útil.
