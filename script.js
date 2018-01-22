window.onload = function(){	
	progress();
	up();
	if(location.href == 'http://bartlomiejhartuna.pl/phone-book/'){
		change();	
		next();
	}
}
function change(){
	var element = document.getElementById('change');
	element.addEventListener('click', modify, false);
}
function modify(){
	var button = document.getElementsByClassName('send');
	if(button[0].style.display == 'none'){
		button[1].style.display = 'none';
		button[0].style.display = 'inline-block';
	}
	else{
		button[0].style.display = 'none';
		button[1].style.display = 'inline-block';
	}
}
function progress(){
	var busyData = document.getElementById('busy').textContent * 4;
	busy(busyData, busyData, 208);
}
function busy(busyData, height, color){
	var progress = document.getElementById('progress');
	if(busyData >= 0){
		if(document.getElementById('volume').offsetWidth == 160){
			progress.style.height = height - busyData + 'px';
		}
		else{
			progress.style.width = height - busyData + 'px';	
		}
		progress.style.backgroundColor = 'rgb(240, ' + color + ', 0)';
		busyData -= 4;
		color -= 4;
		setTimeout(function(){busy(busyData, height, color)}, 10);
	}
}
function next(){
	var next = document.getElementsByClassName('pager');
	next[0].addEventListener('click', goPrevious, false);
	next[1].addEventListener('click', goNext, false);
}
function goNext(){
	var current = parseInt(document.getElementById('number').textContent);
	var max = parseInt(document.getElementById('numberMax').textContent);
	next = current + 1;
	if(next > max){
		next = 1;
	}
	changeResult(next, current, 0, 'left');
}
function goPrevious(){
	var current = parseInt(document.getElementById('number').textContent);
	var max = parseInt(document.getElementById('numberMax').textContent);
	next = current - 1;
	if(next < 1){
		next = max;
	}
	changeResult(next, current, 0, 'left');
}
function changeResult(next, current, margin, direction){
	var result = document.getElementsByClassName('result');
	if(direction == 'left'){
		if(margin > -600){
			margin -= 40;
			result[current - 1].style.marginLeft = margin + 'px';
			setTimeout(function(){changeResult(next, current, margin, direction)}, 10);	
		}
		else{
			result[current - 1].style.display = 'none';
			result[next - 1].style.marginLeft = margin + 'px';
			result[next - 1].style.display = 'inline-block';
			direction = 'right';
			document.getElementById('number').textContent = next;	
			setTimeout(function(){changeResult(next, current, margin, direction)}, 10);	
		}
	}
	else{
		if(margin < 0){
			margin += 40;
			result[next - 1].style.marginLeft = margin + 'px';
			setTimeout(function(){changeResult(next, current, margin, direction)}, 10);	
		}
	}
}
function up(){
	var up = document.getElementById('up');
	up.addEventListener('click', checkUp, false);
}
function checkUp(){
	var help = document.getElementById('up');
	if(help.textContent == '?'){
		expandHelp(-220, 'up');
	}
	else{
		expandHelp(0, 'down');
	}
}
function expandHelp(value, direction){
	var up = document.getElementById('help');
	if(value < 0 && direction == 'up'){
		value += 20;
		up.style.bottom = value + 'px';
		setTimeout(function(){expandHelp(value, direction)}, 10);
	}
	else if(direction == 'down' && value > -220){
		value -= 20;
		up.style.bottom = value + 'px';
		setTimeout(function(){expandHelp(value, direction)}, 10);
	}
	else{
		var help = document.getElementById('up');
		if(help.textContent == '?'){
			help.textContent = 'X';
		}
		else{
			help.textContent = '?';
		}	
	}
}