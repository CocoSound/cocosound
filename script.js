function afficher()
{
	document.getElementById('style').style.display = 'inline';
	document.getElementById('search').style.display = 'none';
}

function cacher()
{
	document.getElementById('style').style.display = 'none';
	document.getElementById('search').style.display = 'inline';
}



function checkGenre (){
	if (document.getElementById('genre').value==3) 
	{
		return(true);
	}
	else{
 		return(false);		
	}
}

function checkAll(){
	console.log('Genre : ', checkGenre() );
	
	if (checkGenre()) 
	{
		console.log('ok');
		afficher();
	}		


	else
	{
		console.log('pas ok');
		cacher();
	}	
}

function getElem() {

    document.getElementById('genre').addEventListener('change', checkAll);    
}

window.addEventListener("load", getElem);
