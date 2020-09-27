let svg = document.querySelector('.brand_home_an');
let c_o = svg.querySelector('.c_outline');
let c_no = svg.querySelector('.c_no_outline');
let br = svg.querySelector('.brand');
let loaded = false;


let animationIn = anime.timeline({
    easing: 'easeOutExpo',
    delay: 1000,
});
animationIn.add({
    targets: c_o,
    opacity: 1,
    duration: 100
});
animationIn.add({
    targets: c_o,
    strokeDashoffset: [anime.setDashoffset, 0],
    duration: 1500
}, 50);
animationIn.add({
    targets: c_no,
    opacity: 1,
    duration: 1000
}, 500);
animationIn.add({
    targets: [br],
    duration: 2500,
    opacity: 1
}, 2000);



let animationMouseIn = anime.timeline({
    easing: 'easeOutExpo',
    autoplay: false,
    duration: 1500
});
animationMouseIn.add({
    targets: [c_no],
    scale: .9,
}, 0);
animationMouseIn.add({
    targets: [br],
    scale: 1.1,
}, 100);


let animationMouseOut = anime.timeline({
    easing: 'easeOutExpo',
    autoplay: false,
    duration: 1500,
    direction: 'reverse'
});
animationMouseOut.add({
    targets: [c_no],
    scale: .9,
}, 0);
animationMouseOut.add({
    targets: [br],
    scale: 1.1,
}, 100);

svg.addEventListener('mouseenter', function () {
    anime.remove([c_no, br]);
    animationMouseIn.play();
});
svg.addEventListener('mouseleave', function () {
    anime.remove([c_no, br]);
    animationMouseOut.play();
});




// let brand_animation = anime.timeline({
//     easing: 'easeOutExpo',
//     autoplay: false,
//     delay: 1000,
//     complete: (anim) => {
//         svg.classList.remove('init');
//         loaded = true;
//     }
// });
// brand_animation.add({
//     targets: c_o,
//     opacity: 1,
//     duration: 100
// }, 1);
// brand_animation.add({
//     targets: c_o,
//     strokeDashoffset: [anime.setDashoffset, 0],
//     duration: 1500
// }, 50);
// brand_animation.add({
//     targets: c_no,
//     opacity: 1,
//     duration: 1000
// }, 500);
// brand_animation.add({
//     targets: [br],
//     duration: 2500,
//     opacity: 1
// }, 2000);
// brand_animation.play();




// let brand_animation_in = anime.timeline({
//     easing: 'easeOutExpo',
//     autoplay: false,
//     duration: 1500
// });
// let brand_animation_out = anime.timeline({
//     easing: 'easeOutExpo',
//     autoplay: false,
//     duration: 1500
// });

// let branding_in = () => {
//     brand_animation_out.children.forEach(c => {
//         c.animatables.forEach(d => {
//             anime.remove(d.target);
//         });
//     });
//     brand_animation_in.add({
//         targets: [c_no],
//         scale: .9,
//     }, 0);
//     brand_animation_in.add({
//         targets: [br],
//         scale: 1.1,
//     }, 100);
//     brand_animation_in.play();
// };


// let branding_out = () => {
//     brand_animation_in.children.forEach(c => {
//         c.animatables.forEach(d => {
//             anime.remove(d.target);
//         });
//     });
//     brand_animation_out.add({
//         targets: [br],
//         scale: 1,
//     }, 0);
//     brand_animation_out.add({
//         targets: [c_no],
//         scale: 1,
//     }, 100);
//     brand_animation_out.play();
// };


// svg.addEventListener('mouseenter', function () {
//     branding_in();
// });
// svg.addEventListener('mouseleave', function () {
//     branding_out();
// });
