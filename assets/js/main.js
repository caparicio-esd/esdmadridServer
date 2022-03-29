window.addEventListener("load", () => {
  startAnimation();
});

const slider = document.querySelector(".slider");
const svg = slider.querySelector(".brand_home_an");
const c_outline = svg.querySelector(".c_outline");
const c_no_outline = svg.querySelector(".c_no_outline");
const brand = svg.querySelector(".brand");
let animation;
let animationHover;

const startAnimation = () => {
  animation = anime
    .timeline({
      duration: 500,
      delay: 500,
      easing: "easeInOutQuad",
    })
    .add({
      targets: [c_outline],
      strokeDashoffset: [anime.setDashoffset, 0],
      opacity: [0, 1],
    })
    .add(
      {
        targets: [c_no_outline],
        opacity: [0, 1],
        translateY: [30, 0],
      },
      "-=500",
    )
    .add(
      {
        targets: [brand],
        opacity: [0, 1],
      },
      "-=200",
    );
};
