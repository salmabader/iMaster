// -------------- instructor tab filters -----------------
const fields = document.querySelectorAll("[inst-field]")
const radioBtns = document.querySelectorAll("[inst-categories]")
const names = document.querySelectorAll("[inst-fullname]")
const instructorSearchBar = document.querySelector("[inst-searching]")
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
instructorSearchBar.addEventListener('input', function () {
    names.forEach(name => {
        if (!name.innerHTML.toLowerCase().includes(instructorSearchBar.value.toLowerCase())) {
            name.parentElement.style.display = "none"
        } else {
            name.parentElement.style.display = "table-row"
        }
    });
})

// -------------- course tab filters -----------------
const categories = document.querySelectorAll("[course-field]")
const courseRadioBtns = document.querySelectorAll("[course-categories]")
const titles = document.querySelectorAll("[course-title]")
const instructors = document.querySelectorAll("[course-inst]")
const courseSearchBar = document.querySelector("[course-searching]")
// to filter table based on the field
courseRadioBtns.forEach(btn => {
    btn.addEventListener('change', function () {
        if (btn.checked) {
            category = btn.value
            if (category != 'All') {
                categories.forEach(g => {
                    if (!g.innerHTML.includes(category)) {
                        g.parentElement.style.display = "none"
                    } else {
                        g.parentElement.style.display = "table-row"
                    }
                })
            } else {
                categories.forEach(element => {
                    element.parentElement.style.display = "table-row"
                });
            }
        }
    })
})
courseSearchBar.addEventListener('input', function () {
    for (let i = 0; i < titles.length; i++) {
        if (!titles[i].innerHTML.toLowerCase().includes(courseSearchBar.value.toLowerCase()) && !instructors[i].innerHTML.toLowerCase().includes(courseSearchBar.value.toLowerCase())) {
            titles[i].parentElement.style.display = "none"
        } else {
            titles[i].parentElement.style.display = "table-row"
        }


    }
})

// ---------- to show toast msg ----------
const toast = document.getElementById("action-feedback")
const msg = document.getElementById("feedbackMsg")
window.addEventListener('load', function () {
    if (msg.innerHTML.length > 0) {
        toast.classList.remove("opacity-0")
        toast.classList.add("opacity-100")
    }
})
