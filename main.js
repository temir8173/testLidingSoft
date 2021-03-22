$( document ).keyup(function(e) {
	switch (e.keyCode) {
		case 37:
			alert('Нажата клавиша "левая стрелка"');
			break;
		case 38:
			alert('Нажата клавиша "вверх"');
			break;
		case 39:
			alert('Нажата клавиша "правая стрелка"');
			break;
		case 40:
			alert('Нажата клавиша "вниз"');
			break;
	}
});