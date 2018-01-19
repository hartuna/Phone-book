window.onload = function(){	
	if(location.href == 'http://bartlomiejhartuna.pl/phone-book/'){
		change();	
	}
	progress();
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
		progress.style.height = height - busyData + 'px';
		progress.style.backgroundColor = 'rgb(240, ' + color + ', 0)';
		busyData -= 2;
		color -= 2;
		setTimeout(function(){busy(busyData, height, color)}, 10);
	}
}