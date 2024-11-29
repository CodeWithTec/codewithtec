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

// Form resetting function 

function submitForm() {
    // Get the first form with the name
    // Usually the form name is not repeated
    // but duplicate names are possible in HTML
    // Therefore to work around the issue, enforce the correct index
    let frm = document.getElementsByName('quote-from')[0];
    frm.submit(); // Submit the form
    frm.reset();  // Reset all form data
    return false; // Prevent page refresh
 }