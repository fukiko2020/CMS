const img_tag = "<img src='img/";
const close_tag = "'>";

function addTag(tag) {
    document.getElementById(tag).addEventListener("click", () => {
        document.getElementById("content").value += "<" + tag + ">" + "</" + tag + ">";
    });
};

document.getElementById("thumbnail_btn").addEventListener("click", () => {
    let chosen_img = document.getElementById("thumbnail_name").value;
    document.getElementById("show_img").innerHTML = img_tag + chosen_img + close_tag;
    console.log(img_tag + chosen_img + close_tag);
});

document.body.addEventListener("keyup", function () {
    document.getElementById("show_content").innerHTML = document.getElementById("content").value;
});

document.body.addEventListener("keyup", function () {
    document.getElementById("show_title").innerHTML = document.getElementById("title").value;
});

document.getElementById("img").addEventListener("click", () => {
    document.getElementById("content").value += "<img class='content_img' src='img/ここに画像へのパス'>";
});

addTag("h1");
addTag("h2");
addTag("p");
addTag("br");
