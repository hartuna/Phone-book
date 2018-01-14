window.onload = function(){
	change();
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