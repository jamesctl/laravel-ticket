document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

  const tl = gsap.timeline({
    defaults: {
      ease: "none", // nicer with scrub: true ScrollTriggers
      duration: 1, // Just for testing
    },
    scrollTrigger: {
      trigger: ".sticky-container",
      start: "top top+=120px",
      end: "top+=3000px top",
      pin: true,
      markers: false,
      scrub: true,
      onUpdate: (self) => {
        const slides = document.querySelectorAll(".sticky-slide");
        const navItems = document.querySelectorAll(".sticky-nav li");

        // Remove the 'active' class from all nav items
        navItems.forEach((item) => item.classList.remove("active"));

        // Determine the active slide based on scroll progress
        const activeIndex = Math.round(self.progress * (slides.length - 1));
        navItems[activeIndex].classList.add("active");
      },
    },
  });

  // Loop trough all the slides
  document.querySelectorAll(".sticky-slide").forEach((slide, index) => {
    if (index === 0) return;
    tl.from(slide, {
      yPercent: 100,
      stagger: 0.5,
    });
  });

  // const links = gsap.utils.toArray('.sticky-nav a');

  // function setActive(link) {
  //     links.forEach(el => el.classList.remove('active'));
  //     link.classList.add('active');
  // }

  // links.forEach((a) => {
  //     const element = document.querySelector(a.getAttribute('href'));
  //     const linkST = ScrollTrigger.create({
  //         trigger: element,
  //         start: 'top top',
  //     });
  //     ScrollTrigger.create({
  //         trigger: element,
  //         start: 'top top',
  //         end: 'top top',
  //         markers: false,
  //         onToggle: self => self.isActive && setActive(a),
  //     });
  //     a.addEventListener('click', (e) => {
  //         e.preventDefault();
  //         gsap.to(window, { duration: 1, scrollTo: linkST.start, overwrite: 'auto' });
  //     });
  // });
});
