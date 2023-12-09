document.addEventListener("DOMContentLoaded", function() {
    var current = location.pathname;
    if (!current.includes('php')){
        document.querySelector("li").classList.add('active');
    }
    var links = document.querySelectorAll("ul li a");
    links.forEach(function(link) {
        if (current.indexOf(link.getAttribute('href').toLowerCase()) !== -1) {
            link.parentNode.classList.add('active');
        }
    });
});
