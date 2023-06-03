export class SwiperSlider extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const slides = this.querySelectorAll('.swiper-slide');
    const slidesPerView = this.getAttribute('slides-per-view') || 1;
    const pagination = this.getAttribute('pagination') === 'true';
    const breakpoints = JSON.parse(this.getAttribute('breakpoints') || '[]');
  
    let slidesHTML = '';
    slides.forEach(slide => {
      slidesHTML += `
        <div class="swiper-slide">
          ${slide.innerHTML}
        </div>
      `;
    });
  
    this.innerHTML = `
      <div class="swiper-container relative overflow-hidden">
        <div class="swiper-wrapper">
          ${slidesHTML}
        </div>
        ${pagination ? '<div class="swiper-pagination"></div>' : ''}
      </div>
    `;
  
    let config = {
      direction: 'horizontal',
      loop: true,
      slidesPerView: slidesPerView,
      spaceBetween: 30,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    };
  
    if (breakpoints.length > 0) {
      config.breakpoints = {};
  
      breakpoints.forEach(bp => {
        const width = Object.keys(bp)[0];
        const options = bp[width];
  
        config.breakpoints[width] = {
          slidesPerView: options.slidesPerView,
          spaceBetween: options.spaceBetween || 30,
        };
      });
    }
  
    new Swiper('.swiper-container', config);
  }
  
}

customElements.define('swiper-slider', SwiperSlider);
