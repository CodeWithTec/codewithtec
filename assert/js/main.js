// selecting all the filter button and items to filter
const filterContainer = document.querySelector(".portfolio-filter"), 
portfolioItems =document.querySelectorAll(".portfolio-item");

// creating an event listener for click on filter-item
filterContainer.addEventListener("click", (event) =>{
    if(event.target.classList.contains("filter-item")){
        //deactive existing active 'filter-item'
        filterContainer.querySelector(".active").classList.remove("active");
        // active new filter-item
        event.target.classList.add("active");
        const filterValue = event.target.getAttribute( "data-filter" );
        portfolioItems.forEach((item) =>{
            if(item.classList.contains(filterValue) || filterValue === 'all'){
                item.classList.remove("hide");
                item.classList.add("show");
            }
            else{
                item.classList.remove("show");
                item.classList.add("hide");
            }
        })



    }
    });


// contact section success message Go back button

