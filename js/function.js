var isDropdownOpen = false; 

function toggleDropdown() {
    var dropdownContent = document.querySelector('.dropdown-content');
    var menuIcon = document.getElementById('menuIcon');

    if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
        dropdownContent.style.display = 'block';
        menuIcon.classList.add('spin');
    } else {
        dropdownContent.style.display = 'none';
        menuIcon.classList.remove('spin');
    }
}

window.onclick = function (event) {
    var dropdownContainer = document.querySelector('.dropdown');
    var dropdownContent = document.querySelector('.dropdown-content');
    var menuIcon = document.getElementById('menuIcon');

    if (dropdownContainer.contains(event.target)) {
        console.log('hello');
        isDropdownOpen = true;
        return;
    }

    if (isDropdownOpen) {
        dropdownContent.style.display = 'none';
        menuIcon.classList.remove('spin');
        isDropdownOpen = false;
    }
};