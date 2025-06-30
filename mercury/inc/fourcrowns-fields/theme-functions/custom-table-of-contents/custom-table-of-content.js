document.addEventListener("DOMContentLoaded", function () {
    // Rozbalování / sbalování osnovy
    const osnovaToggle = document.querySelector(".osnova-toggle");
    const osnovaList = document.querySelector(".osnova-list");
    const osnovaArrow = document.querySelector(".osnova-arrow");

    if (osnovaToggle && osnovaList) {
        osnovaToggle.addEventListener("click", function () {
            const isVisible = osnovaList.style.display === "block";
            osnovaList.style.display = isVisible ? "none" : "block";
            osnovaArrow.style.transform = isVisible ? "rotate(0deg)" : "rotate(180deg)";
        });
    }

    // Hladký scroll k nadpisům
    document.querySelectorAll(".osnova-list a").forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 20,
                    behavior: "smooth"
                });
            }
        });
    });
});