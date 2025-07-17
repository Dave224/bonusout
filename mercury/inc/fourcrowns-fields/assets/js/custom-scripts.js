document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.dynamic-typewriter');

    links.forEach(link => {
        const h3 = link.querySelector('h3');
        const originalText = h3.textContent;
        const newText = link.querySelector('.hidden-text').textContent;

        function typeText(element, text) {
            element.textContent = '';
            let i = 0;
            const interval = setInterval(() => {
                if (i < text.length) {
                    element.textContent += text[i];
                    i++;
                } else {
                    clearInterval(interval);
                }
            }, 25);
        }

        link.addEventListener('mouseenter', () => {
            typeText(h3, newText);
        });

        link.addEventListener('mouseleave', () => {
            typeText(h3, originalText);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.article-swiper', {
        slidesPerView: 1.25,
        spaceBetween: 5,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            425: { slidesPerView: 1.65 },
            560: { slidesPerView: 2.2 },
            680: { slidesPerView: 2.7 },
            796: { slidesPerView: 3.1 },
            869: { slidesPerView: 3.4 },
            1100: { slidesPerView: 3.8 },
            1269: { slidesPerView: 4.7 },
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".custom-tabs-nav li");
    const panels = document.querySelectorAll(".custom-tab-panel");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove("active"));
            panels.forEach(p => p.classList.remove("active"));

            tab.classList.add("active");
            document.querySelector(`.custom-tab-panel[data-tab="${target}"]`).classList.add("active");
        });
    });
});

function equalizeCardHeights() {
    const cards = document.querySelectorAll('.swiper-slide .article-card');
    let maxHeight = 0;

    // Reset height to auto to recalculate properly
    cards.forEach(card => card.style.height = 'auto');

    cards.forEach(card => {
        const height = card.offsetHeight;
        if (height > maxHeight) maxHeight = height;
    });

    cards.forEach(card => card.style.height = maxHeight + 'px');
}

// Run on DOM load and on window resize (and after swiper init)
window.addEventListener('load', equalizeCardHeights);
window.addEventListener('resize', equalizeCardHeights);

const swiper = new Swiper('.expert-slider', {
    slidesPerView: 1.3, // zobrazí část další karty
    spaceBetween: 20,
    loop: true,
    centeredSlides: true,
    watchOverflow: true,
    breakpoints: {
        374: {
            slidesPerView: 2, // malý telefon
            centeredSlides: false,
        },
        640: {
            slidesPerView: 2.2,
            centeredSlides: false,
        },
        768: {
            slidesPerView: 3.2,
        },
        1024: {
            slidesPerView: 5,
            centeredSlides: false,
        },
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

document.addEventListener('DOMContentLoaded', function () {
    const fullBar = document.querySelector('.float-bar-full');
    const collapsedBar = document.querySelector('.float-bar-collapsed');
    const closeBtn = document.getElementById('float-bar-close');
    const expandBtn = document.getElementById('expand-bar');

    // Najde iframe Tawk.to chatu
    function moveTawkTo(bottomValue) {
        const tawkIframe = document.querySelector("iframe[title='chat widget']");
        if (tawkIframe) {
            tawkIframe.style.bottom = bottomValue;
        }
    }

    closeBtn.addEventListener('click', function () {
        fullBar.style.maxHeight = '0';
        fullBar.style.opacity = '0';
        setTimeout(() => {
            fullBar.style.display = 'none';
            collapsedBar.style.display = 'block';
            moveTawkTo('75px'); // Posun chatu dolů (např. o 20px odspodu)
        }, 500); // čas odpovídá CSS animaci
    });

    expandBtn.addEventListener('click', function () {
        collapsedBar.style.display = 'none';
        fullBar.style.display = 'block';
        setTimeout(() => {
            fullBar.style.maxHeight = '500px';
            fullBar.style.opacity = '1';
            moveTawkTo('152px'); // Posun chatu výš, podle výšky lišty
        }, 10); // drobné zpoždění, aby animace proběhla
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter-number');
    const options = { threshold: 0.5 };

    const animateCounter = (el) => {
        const target = parseInt(el.dataset.target, 10);
        const duration = 1500;
        const fps = 60;
        const totalFrames = Math.round(duration / (1000 / fps));
        let frame = 0;

        const counter = setInterval(() => {
            frame++;
            const progress = frame / totalFrames;
            const current = Math.round(target * easeOutQuad(progress));
            el.textContent = current.toLocaleString('cs-CZ');

            if (frame === totalFrames) clearInterval(counter);
        }, 1000 / fps);
    };

    const easeOutQuad = (t) => t * (2 - t);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                animateCounter(entry.target);
                entry.target.dataset.animated = 'true';
            }
        });
    }, options);

    counters.forEach(counter => observer.observe(counter));
});

document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector(".fc-outline-toggle");
    const content = document.querySelector(".fc-outline-content");

    if (toggleButton && content) {
        toggleButton.addEventListener("click", () => {
            const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";
            toggleButton.setAttribute("aria-expanded", !isExpanded);
            if (!isExpanded) {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        });
    }
});