var filterButton = document.querySelector('button#display_filters');
filterButton.addEventListener('click', () => {
    let filterDiv = document.querySelector('div.filters');
    if (filterDiv.style.display === 'none') {
        filterDiv.style.display = 'block';
        filterButton.innerText = 'Hide Filters';
    } else {
        filterDiv.style.display = 'none';
        filterButton.innerText = 'Show Filters';
    }
});