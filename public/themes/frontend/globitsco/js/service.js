window.addEventListener("scroll", function () {
  const sections = document.querySelectorAll(".card-stories__section");
  const navItems = document.querySelectorAll(".side__anchor .side__title");

  let currentSection = "";

  sections.forEach((section) => {
    const sectionPosition = section.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;

    if (
      sectionPosition < windowHeight / 1.1 &&
      sectionPosition >= -windowHeight / 1.1
    ) {
      currentSection = section.getAttribute("id");
      section.classList.add("visible");
    } else {
      section.classList.remove("visible");
    }
  });

  if (!currentSection && sections.length > 0) {
    currentSection = sections[0].getAttribute("id");
  }

  const lastSection = sections[sections.length - 1];
  const lastSectionPosition = lastSection.getBoundingClientRect().bottom;
  if (lastSectionPosition <= window.innerHeight) {
    currentSection = lastSection.getAttribute("id");
  }

  updateNavItems(currentSection, navItems);
  updateImages(currentSection);
});

function updateNavItems(currentSection, navItems) {
  navItems.forEach((item) => {
    const link = item.querySelector("a");
    item.classList.remove("is-active");

    if (link.getAttribute("href") === `#${currentSection}`) {
      item.classList.add("is-active");
    }
  });
}

function updateImages(currentSection) {
  const images = document.querySelectorAll(".picture-service");

  images.forEach((image) => {
    image.classList.remove("is-active");
  });

  const targetImage = document.querySelector(
    `.picture-service[data-target="${currentSection}"]`
  );
  if (targetImage) {
    targetImage.classList.add("is-active");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const firstNavItem = document.querySelector(".side__anchor .side__title");
  const images = document.querySelector(".picture-service");

  if (firstNavItem || images) {
    firstNavItem.classList.add("is-active");
    images.classList.add("is-active");
  }
});
