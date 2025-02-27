const menu = document.querySelector(".menu-bars");
const navigation = document.querySelector(".navigation");
const naviBack = document.querySelector(".navi-back");
const fullContent = document.querySelector(".full-content");
const h2 = document.querySelector(".navigation h2");

menu.addEventListener("click", () => {
    if (
        navigation.style.display === "none" ||
        navigation.style.width === "0%"
    ) {
        navigation.style.display = "block";
        naviBack.style.display = "block";
        setTimeout(() => {
            navigation.style.width = "17%";
            naviBack.style.width = "17%";
            fullContent.style.transition = "0.5s";
            fullContent.style.width = "83%";
            h2.style.display = "block";
        }, 100);
    } else {
        fullContent.style.width = "100%";
        navigation.style.width = "0%";
        naviBack.style.width = "0%";
        h2.style.display = "none";
        setTimeout(() => {
            navigation.style.display = "none";
            naviBack.style.display = "none";
        }, 350);
    }
});
