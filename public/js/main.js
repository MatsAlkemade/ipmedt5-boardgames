const navButton = document.getElementById('js--navButton');
const navDropdown = document.getElementById('js--navDropdown');

navButton.addEventListener('click', function(){
    if(navDropdown.style.display === 'none'){
        navDropdown.style.display = 'block';
    }else {
        navDropdown.style.display = 'none';
    }
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('js--nc')){
        return;
    } else {
        navDropdown.style.display = 'none';
    }
});