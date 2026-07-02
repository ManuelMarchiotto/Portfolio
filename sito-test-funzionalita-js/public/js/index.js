
function showCategories(categoriesDto, categoriesRow){
        categoriesDto.forEach((categoryDto) => {            
        const col = document.createElement('div');
        col.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-xl-3');
        categoriesRow.appendChild(col);

        const card = document.createElement('div');
        card.classList.add('category-card');
        col.appendChild(card);

        const cardBody = document.createElement('div');
        cardBody.classList.add('category-card-body');
        card.appendChild(cardBody);

        const iconContainer = document.createElement('div');
        iconContainer.classList.add('category-icon-container');
        cardBody.appendChild(iconContainer);

        const icon = document.createElement('i');
        const classes = categoryDto.icon.split(' ');
        
        classes.forEach(singleClass => {
        icon.classList.add(singleClass);
        });
        //icon.classList.add('bi', 'bi-car-front-fill');
        iconContainer.appendChild(icon);

        const title = document.createElement('h3');
        title.textContent = categoryDto.name;
        cardBody.appendChild(title);

        const description = document.createElement('p');
        description.classList.add('mb-0');
        description.textContent = `${categoryDto.announcementsCount} Annunci`;
        cardBody.appendChild(description);
    });
}


async function loadCategories(){
    const response = await fetch('./server/api/categorie.json');
    const categoriesDto = await response.json();
    return categoriesDto;
}

document.addEventListener('DOMContentLoaded', async function () {
    const categoriesRow = document.getElementById('categoriesRow');   
    const categoriesDto = await loadCategories(); 
    showCategories(categoriesDto, categoriesRow);

})
