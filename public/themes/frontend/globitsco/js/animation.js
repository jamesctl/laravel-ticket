gsap.registerPlugin(ScrollTrigger);
// gsap.registerPlugin(ScrollSmoother);

// // /*--------------------------------------------------------------
// //     1. Typing Animation
// //   --------------------------------------------------------------*/

const textArray = [" DESIGN", "DEVELOPER"];

let arrayIndex = 0;
let charIndex = 0;
let isDeleting = false;
const speed = 90;
const deleteSpeed = 50;
const delayBetweenTexts = 1000;

function typeWriter() {
  const currentText = textArray[arrayIndex];

  if (!isDeleting && charIndex < currentText.length) {
    document.getElementById("typewriter").innerHTML +=
      currentText.charAt(charIndex);
    charIndex++;
    setTimeout(typeWriter, speed);
  } else if (isDeleting && charIndex > 0) {
    document.getElementById("typewriter").innerHTML = currentText.substring(
      0,
      charIndex - 1
    );
    charIndex--;
    setTimeout(typeWriter, deleteSpeed);
  } else if (charIndex === 0) {
    isDeleting = false;
    arrayIndex = (arrayIndex + 1) % textArray.length;
    setTimeout(typeWriter, speed);
  } else {
    isDeleting = true;
    setTimeout(typeWriter, delayBetweenTexts);
  }
}

typeWriter();

// // /*--------------------------------------------------------------
// //     3. Pin Animation
// //   --------------------------------------------------------------*/

function sectionTitleAnimation(container, settings) {
  const sectionTitle = container.querySelector(".pic-text");

  let timeline = gsap.timeline({
    scrollTrigger: {
      trigger: container,
      start: settings.pin_area_start,
      end: settings.pin_area_end,
      pin: sectionTitle,
      pinSpacing: false,
      scrub: 1,
      markers: false,
    },
  });

  timeline
    .to(sectionTitle, {
      y: 300,
      scale: 0.7,
      duration: 1,
    })
    .to(sectionTitle, {
      y: 0,
      scale: 1,
      duration: 1,
    });
}

const container = document.querySelector(".container-project-list");
sectionTitleAnimation(container, {
  pin_area_start: "top top",
  pin_area_end: "bottom center",
});

// // /*--------------------------------------------------------------
// //     End Pin Animation
// //   --------------------------------------------------------------*/
