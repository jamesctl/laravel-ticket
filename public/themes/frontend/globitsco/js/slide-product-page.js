const images = gsap.utils.toArray(".picture-product img");
const rightElements = gsap.utils.toArray(".content-product");

const slideProduct = gsap.timeline({
  scrollTrigger: {
    trigger: ".middle-product",
    start: "top top",
    end: "+=300%",
    pin: true,
    scrub: true,
    markers: false,
  },
});

images.forEach((img, i) => {
  if (images[i + 1]) {
    slideProduct
      .to(img, { opacity: 0 }, "+=0.5")
      .to(images[i + 1], { opacity: 1 }, "<")
      .to(rightElements, { yPercent: -(100 * (i + 1)), ease: "none" }, "<");
  }
});
slideProduct.to({}, {}, "+=0.5");
