const slides = document.querySelectorAll('.image-slider .swiper-slide');
const progressElement = document.querySelector('.autoplay-progress');

if (slides.length <= 1) {
  if (progressElement) {
    progressElement.remove();
  }
}

const enableAutoplay = slides.length > 1;

const progressCircle = document.querySelector(".autoplay-progress svg");
const progressContent = document.querySelector(".autoplay-progress span");
const swiper = new Swiper(".image-slider", {    // Объявление слайдера
  direction: "horizontal",                      // Горизонтальный свайп слайдов
  loop: true,                                   // Бесконечный слайдер
  simulateTouch: true,                          // Листать курсором
  touchRatio: 2,                                // Значение перелистывания курсором
  touchAngle: 45,                               // Градус перелистывания курсором
  grabCursor: true,                             // Юзать курсор-руку при зажатии и наведении
  slidesPerView: 1,                             // Сколько показывать слайдов
  watchOverflow: true,                          // Убрать всё, кроме слайда, если он один
  speed: 800,                                   // Скорость перелистывания
  effect: "fade",                               // Анимация появления
  fadeEffect: {                                 // Крутой эффект появления
    crossFade: true,
  },
  pagination: {                                 // Пагинация
    el: ".swiper-pagination",                   // Класс для пагинации
    type: "bullets",                            // Тип пагинации (точки)
    clickable: true,                            // Кликабельные ли точки
  },
  navigation: {                                 // Навигация
    nextEl: ".swiper-button-next",              // Класс кнопки вправо
    prevEl: ".swiper-button-prev",              // Класс кнопки влево
  },
  keyboard: {                                   // Перелистывание клавиатурой
    enable: true,                               // Включить
    onlyInViewport: true,                       // На стрелочки
    pageUpDown: true,                           // На кнопки pgUp, pgDn
  },
  mousewheel: {                                 // Перелистывание мышкой
    sensitivity: 1,
    eventsTarget: ".image-slider",
  },
  autoplay: enableAutoplay ? {                  // Автоматический переход на следующий слайд
    delay: 5000,                                // Задержка 3 секунды 
    stopOnLastSlide: true,                      // Остановить на ласт слайде
    disableOnInteraction: false,                // Отключить переключение после взаимодействия
    pauseOnMouseEnter: true,                    // Пауза при наведении мышкой на слайд
    waitForTransition: true,                    // Ожидание перехода
  } : false,
  on: {
    autoplayTimeLeft(s, time, progress) {
      if (enableAutoplay) {
        progressCircle.style.setProperty("--progress", 1 - progress);
        progressContent.textContent = `${Math.ceil(time / 1000)}`;
      }
    },
  },
  preloadImages: false,                         // Лоадер, если инет хуйня
  lazy: {
    loadOnTransitionStart: false,
    loadPrevNext: false,
  },
  watchSlidesProgress: true,                    // Видеть прогресс-бар
  watchSlidesVisibility: true,
  parallax: true,                               // Включить параллакс (клёвые анимашки)
});

if (servers && site) {
  function InfoOnline() {
    $.ajax({
      type: 'POST',
      url: domain + "app/modules/module_block_main_banner_slider/includes/js_controller.php",
      data: ({ servers: servers, site: site }),
      dataType: 'json',
      global: false,
      success: function (data) {
        $('#online_site').html('');
        $('#online_server').html('');
        $('#online_site').append(data['online_site']);
        $('#online_server').append(data['online_server']);
      }
    });
  }
  InfoOnline();
};
setInterval(InfoOnline, 30000);