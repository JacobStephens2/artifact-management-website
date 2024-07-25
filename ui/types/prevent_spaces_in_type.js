var form = document.querySelector('form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    if (document.querySelector('input').value.includes(' ')) {
        alert('Make sure the type has no spaces in it.');
    } else {
        form.submit();
    }
});