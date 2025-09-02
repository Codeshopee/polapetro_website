document.addEventListener("DOMContentLoaded", () => {
    const parallaxSections = document.querySelectorAll(".parallax-bg");

    // Set background images from data attribute
    parallaxSections.forEach(bg => {
        const img = bg.getAttribute("data-parallax-bg");
        bg.style.backgroundImage = `url('${img}')`;
    });

    window.addEventListener("scroll", () => {
        const scrollTop = window.pageYOffset;

        parallaxSections.forEach(bg => {
            const section = bg.parentElement;
            const speed = 0.4; // kecepatan gerak background
            const offset = section.offsetTop;
            const yPos = (scrollTop - offset) * speed;
            bg.style.transform = `translateY(${yPos}px)`;
        });
    });
});
