function leftScroll() {
	const left = document.querySelector(".soft-screens");
	left.scrollBy(300, 0);
}

function rightScroll() {
	const right = document.querySelector(".soft-screens");
	right.scrollBy(-300, 0);
}

$(document).ready(function () {
  $("a[name='dfile']").click(function () {
    noty('Началась загрузка файла', 'success', '/storage/assets/sounds/success2.mp3', 0.1);
  });
});