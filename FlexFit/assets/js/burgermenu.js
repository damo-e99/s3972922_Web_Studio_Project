// --------------------- Hamburger NavBar ------------------------
document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector(".hamburger")
    const topnav = document.querySelector("#topnav")
    const iconNav = document.querySelector("#iconNav")

    hamburger.addEventListener ("click", () => {
        hamburger.classList.toggle("active")
        topnav.classList.toggle("active")
        iconNav.classList.toggle("active")
    })

    document.querySelectorAll("#topnav a", "#iconNav a").forEach(n => n.addEventListener("click", () => {
        hamburger.classList.remove("active");
        topnav.classList.remove("active"); 
        iconNav.classList.remove("active"); 
    }))
})
