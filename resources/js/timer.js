function initializeTimer(el) {
	let endTime = el.data('init'),
		timerId = 0,
		endDate = new Date(endTime), // получаем дату истечения таймера
		currentDate = new Date(), // получаем текущую дату
		seconds = (endDate - currentDate) / 1000, // определяем количество секунд до истечения таймера
		minutes = seconds / 60, // определяем количество минут до истечения таймера
		hours = minutes / 60; // определяем количество часов до истечения таймера

	minutes = (hours - Math.floor(hours)) * 60; // подсчитываем кол-во оставшихся минут в текущем часе
	hours = Math.floor(hours); // целое количество часов до истечения таймера
	seconds = Math.floor((minutes - Math.floor(minutes)) * 60); // подсчитываем кол-во оставшихся секунд в текущей минуте
	minutes = Math.floor(minutes); // округляем до целого кол-во оставшихся минут в текущем часе

	setTimePage(el, hours, minutes, seconds); // выставляем начальные значения таймера

	function secOut() {
		if (seconds === 0) { // если секунду закончились то
			if (minutes === 0) { // если минуты закончились то
				if (hours === 0) { // если часы закончились то
					showMessage(timerId); // выводим сообщение об окончании отсчета
				} else {
					hours--; // уменьшаем кол-во часов
					minutes = 59; // обновляем минуты
					seconds = 59; // обновляем секунды
				}
			} else {
				minutes--; // уменьшаем кол-во минут
				seconds = 59; // обновляем секунды
			}
		} else {
			seconds--; // уменьшаем кол-во секунд
		}
		setTimePage(el, hours, minutes, seconds); // обновляем значения таймера на странице
	}

	timerId = setInterval(secOut, 1000) // устанавливаем вызов функции через каждую секунду
}

function setTimePage(el, h, m, s) { // функция выставления таймера на странице
	let res = prettyTimePart(m) + ":" + prettyTimePart(s);
	if (h > 0) {
		res = prettyTimePart(h) + ":" + res;
	}
	el.html(res)  // выставляем новые значения таймеру на странице
}

function showMessage(timerId) { // функция, вызываемая по истечению времени
	clearInterval(timerId);
	document.getElementById('timeoutForm').submit();
}

function prettyTimePart(timePart) {
	timePart = String(timePart);
	if (timePart.length === 1) {
		timePart = "0" + timePart;
	}
	return timePart;
}

let el = $('#timer');
if (el.length > 0) {
	initializeTimer(el);
}
