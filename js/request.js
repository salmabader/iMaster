const fields = document.querySelectorAll("[data-field]")
const radioBtns = document.querySelectorAll("[data-categories]")
const names = document.querySelectorAll("[data-fullname]")
const searchBar = document.querySelector("[data-search]")
let category = ""
// to filter table based on the field
radioBtns.forEach(btn => {
    btn.addEventListener('change', function () {
        if (btn.checked) {
            category = btn.value
            if (category != 'All') {
                fields.forEach(f => {
                    if (!f.innerHTML.includes(category)) {
                        f.parentElement.style.display = "none"
                    } else {
                        f.parentElement.style.display = "table-row"
                    }
                })
            } else {
                fields.forEach(element => {
                    element.parentElement.style.display = "table-row"
                });
            }
        }
    })
})
searchBar.addEventListener('input', function () {
    console.log('hi')
    names.forEach(name => {
        if (!name.innerHTML.toLowerCase().includes(searchBar.value.toLowerCase())) {
            name.parentElement.style.display = "none"
        } else {
            name.parentElement.style.display = "table-row"
        }
    });
})