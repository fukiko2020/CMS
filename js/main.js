// スマホ画面時のメニュー出し入れなど
const target = document.getElementById("target");
const menu = document.getElementById("menu");
const back = document.getElementById("back");
const scrolltop = document.getElementById("scrolltop");
const scrollmenu = document.getElementById("scrollmenu");


if (maxval != 999) {
    for (let i = 1; i <= maxval; i++) {
        let menuk = +i;
        let menuopen = +i;
        menuk = document.getElementById("menu" + i);
        menuopen = document.getElementById("menuopen" + i);
        menuk.addEventListener("click", () => {
            menuopen.classList.toggle("menuopen");
        });
    };
}

const n = 200;

window.addEventListener("scroll", function () {
    if (scrollY > n) {
        scrolltop.classList.add("look");
        scrollmenu.classList.add("look");
    } else {
        scrolltop.classList.remove("look");
        scrollmenu.classList.remove("look");
    }
});

scrolltop.addEventListener("click", function () {
    anime({
        targets: "html, body",
        scrollTop: 0,
        dulation: 600,
        easing: 'easeOutCubic',
    });
});

target.addEventListener("click", function () {
    menu.classList.toggle("open");
    back.classList.toggle("black");
});

back.addEventListener("click", function () {
    menu.classList.remove("open");
    back.classList.remove("black");
});

scrollmenu.addEventListener("click", () => {
    menu.classList.add("open");
    back.classList.add("black");
});
