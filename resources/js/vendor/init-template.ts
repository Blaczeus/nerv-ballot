type JQueryLike = ((selector?: unknown) => any) & {
    fn?: Record<string, unknown>;
};

type SwiperInstance = {
    destroy: (deleteInstance?: boolean, cleanStyles?: boolean) => void;
    update?: () => void;
};

declare global {
    interface Window {
        jQuery?: JQueryLike;
        Swiper?: new (el: Element | string, options: Record<string, unknown>) => any;
        WOW?: new () => { init: () => void };
    }

    interface HTMLElement {
        __templateSwiper?: SwiperInstance;
        __templateCountdownIntervalId?: number;
    }
}

const toNumber = (value: string | undefined, fallback: number): number => {
    if (value === undefined) return fallback;
    const parsed = Number(value);
    return Number.isFinite(parsed) ? parsed : fallback;
};

const toBoolean = (value: string | undefined, fallback = false): boolean => {
    if (value === undefined) return fallback;
    return value === '' || value === 'true' || value === '1';
};

const initImageSelect = ($: JQueryLike) => {
    if (!$.fn || !$.fn.selectpicker) return;

    $('.image-select').each((_: unknown, element: Element) => {
        const $select = $(element);

        $select.find('option').each((__: unknown, optionElement: Element) => {
            const $option = $(optionElement);
            const imgUrl = $option.attr('data-thumbnail');

            if (imgUrl) {
                $option.attr('data-content', '<img src="' + imgUrl + '" /> ' + $option.text());
            }
        });

        if ($select.data('selectpicker')) {
            $select.selectpicker('refresh');
            return;
        }

        $select.selectpicker();
    });
};

const initGoTop = ($: JQueryLike) => {
    const button = $('#scroll-top');
    if (!button.length) return;

    const updateVisibility = () => {
        if ($(window).scrollTop() > 500) {
            button.addClass('show');
        } else {
            button.removeClass('show');
        }
    };

    $(window).off('scroll.templateGoTop').on('scroll.templateGoTop', () => {
        requestAnimationFrame(updateVisibility);
    });

    button.off('click.templateGoTop').on('click.templateGoTop', (event: Event) => {
        event.preventDefault();
        $('html, body').scrollTop(0);
    });

    updateVisibility();
};

const initCartSuccess = ($: JQueryLike) => {
    const cartSuccess = $('.tf-add-cart-success');
    if (!cartSuccess.length) return;

    cartSuccess.removeClass('active');

    $(document)
        .off('click.templateCartSuccess', '.btn-add-to-cart')
        .on('click.templateCartSuccess', '.btn-add-to-cart', () => {
            cartSuccess.addClass('active');
        });

    $(document)
        .off('click.templateCartSuccessClose', '.tf-add-cart-success .tf-add-cart-close')
        .on('click.templateCartSuccessClose', '.tf-add-cart-success .tf-add-cart-close', () => {
            cartSuccess.removeClass('active');
        });
};

const initStaggerWrap = () => {
    const wraps = document.querySelectorAll<HTMLElement>('.stagger-wrap');
    if (!wraps.length) return;

    const items = document.querySelectorAll<HTMLElement>('.stagger-item');
    if (!items.length) return;

    let time = 0.2;
    items.forEach((item, index) => {
        item.style.transitionDelay = `${time * (index + 1)}s`;
        item.classList.add('stagger-finished');
    });
};

const initTemplateThemeVars = () => {
    const templateRoot = document.querySelector<HTMLElement>('.preload-wrapper');
    if (!templateRoot) return;

    // Avoid collision with app-level design tokens (e.g. Tailwind/shadcn --primary)
    templateRoot.style.setProperty('--primary', '#e43131');
};

const createOrReplaceSwiper = (
    element: HTMLElement,
    options: Record<string, unknown>,
    SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any,
): SwiperInstance => {
    if (element.__templateSwiper) {
        element.__templateSwiper.destroy(true, true);
    }

    element.__templateSwiper = new SwiperCtor(element, options) as SwiperInstance;

    return element.__templateSwiper;
};

const initSlideshow = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-slideshow').forEach((element) => {
        const ds = element.dataset;
        const isAutoplay = toBoolean(ds.autoPlay);

        const options: Record<string, unknown> = {
            slidesPerView: toNumber(ds.mobile, 1),
            loop: toBoolean(ds.loop),
            spaceBetween: toNumber(ds.spaceMb, 0),
            speed: toNumber(ds.speed, 1000),
            observer: true,
            observeParents: true,
            pagination: {
                el: '.sw-pagination-slider',
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: '.navigation-next-slider',
                prevEl: '.navigation-prev-slider',
            },
            centeredSlides: false,
            breakpoints: {
                768: {
                    slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                    spaceBetween: toNumber(ds.space, 0),
                    centeredSlides: false,
                },
                1200: {
                    slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                    spaceBetween: toNumber(ds.space, 0),
                    centeredSlides: toBoolean(ds.centered),
                },
            },
        };

        if (isAutoplay) {
            options.autoplay = {
                delay: toNumber(ds.delay, 3000),
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            };
        } else {
            options.autoplay = false;
        }

        if (ds.effect === 'fade') {
            options.effect = 'fade';
            options.fadeEffect = {
                crossFade: true,
            };
        }

        createOrReplaceSwiper(element, options, SwiperCtor);
    });
};

const initCollection = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-collection').forEach((element) => {
        const ds = element.dataset;

        createOrReplaceSwiper(
            element,
            {
                slidesPerView: toNumber(ds.mobile, 1),
                spaceBetween: toNumber(ds.space, 0),
                speed: 1000,
                observer: true,
                observeParents: true,
                pagination: {
                    el: '.sw-pagination-collection',
                    clickable: true,
                },
                slidesPerGroup: toNumber(ds.pagination, 1),
                navigation: {
                    clickable: true,
                    nextEl: '.nav-next-collection',
                    prevEl: '.nav-prev-collection',
                },
                breakpoints: {
                    575: {
                        slidesPerView: toNumber(ds.mobileSm, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.space, 0),
                        slidesPerGroup: toNumber(ds.pagination, 1),
                    },
                    768: {
                        slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                        slidesPerGroup: toNumber(ds.paginationMd, 1),
                    },
                    1200: {
                        slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                        spaceBetween: toNumber(ds.spaceLg, toNumber(ds.spaceMd, toNumber(ds.space, 0))),
                        slidesPerGroup: toNumber(ds.paginationLg, 1),
                    },
                },
            },
            SwiperCtor,
        );
    });
};

const initCategories = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-categories').forEach((element) => {
        const ds = element.dataset;

        const options: Record<string, unknown> = {
            slidesPerView: toNumber(ds.mobile, 1),
            spaceBetween: toNumber(ds.space, 0),
            speed: 1000,
            observer: true,
            observeParents: true,
            centeredSlides: toBoolean(ds.centered),
            loop: toBoolean(ds.loop),
            pagination: {
                el: '.sw-pagination-categories',
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: '.nav-next-categories',
                prevEl: '.nav-prev-categories',
            },
            slidesPerGroup: toNumber(ds.pagination, 1),
            breakpoints: {
                575: {
                    slidesPerView: toNumber(ds.mobileSm, toNumber(ds.mobile, 1)),
                    spaceBetween: toNumber(ds.space, 0),
                    slidesPerGroup: toNumber(ds.pagination, 1),
                },
                768: {
                    slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                    spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                    slidesPerGroup: toNumber(ds.paginationMd, 1),
                },
                1200: {
                    slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                    spaceBetween: toNumber(ds.spaceLg, toNumber(ds.spaceMd, toNumber(ds.space, 0))),
                    slidesPerGroup: toNumber(ds.paginationLg, 1),
                },
            },
        };

        createOrReplaceSwiper(element, options, SwiperCtor);
    });
};

const initRecent = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-recent').forEach((element) => {
        const ds = element.dataset;

        createOrReplaceSwiper(
            element,
            {
                slidesPerView: toNumber(ds.mobile, 1),
                spaceBetween: toNumber(ds.space, 0),
                speed: 1000,
                observer: true,
                observeParents: true,
                pagination: {
                    el: '.sw-pagination-recent',
                    clickable: true,
                },
                slidesPerGroup: toNumber(ds.pagination, 1),
                navigation: {
                    clickable: true,
                    nextEl: '.nav-prev-recent',
                    prevEl: '.nav-next-recent',
                },
                breakpoints: {
                    768: {
                        slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                        slidesPerGroup: toNumber(ds.paginationMd, 1),
                    },
                    1200: {
                        slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                        spaceBetween: toNumber(ds.spaceLg, toNumber(ds.spaceMd, toNumber(ds.space, 0))),
                        slidesPerGroup: toNumber(ds.paginationLg, 1),
                    },
                },
            },
            SwiperCtor,
        );
    });
};

const initShopGallery = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-shop-gallery').forEach((element) => {
        const ds = element.dataset;

        createOrReplaceSwiper(
            element,
            {
                slidesPerView: toNumber(ds.mobile, 1),
                spaceBetween: toNumber(ds.space, 0),
                speed: 1000,
                observer: true,
                observeParents: true,
                centeredSlides: toBoolean(ds.centered),
                loop: toBoolean(ds.loop),
                pagination: {
                    el: '.sw-pagination-gallery',
                    clickable: true,
                },
                slidesPerGroup: toNumber(ds.pagination, 1),
                navigation: {
                    clickable: true,
                    nextEl: '.nav-next-gallery',
                    prevEl: '.nav-prev-gallery',
                },
                breakpoints: {
                    575: {
                        slidesPerView: toNumber(ds.mobileSm, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.space, 0),
                        slidesPerGroup: toNumber(ds.pagination, 1),
                    },
                    768: {
                        slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                        slidesPerGroup: toNumber(ds.paginationMd, 1),
                        centeredSlides: false,
                    },
                    1200: {
                        slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                        spaceBetween: toNumber(ds.spaceLg, toNumber(ds.spaceMd, toNumber(ds.space, 0))),
                        slidesPerGroup: toNumber(ds.paginationLg, 1),
                        centeredSlides: toBoolean(ds.centered),
                    },
                },
            },
            SwiperCtor,
        );
    });
};

const initIconbox = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    document.querySelectorAll<HTMLElement>('.tf-sw-iconbox').forEach((element) => {
        const ds = element.dataset;

        createOrReplaceSwiper(
            element,
            {
                slidesPerView: toNumber(ds.mobile, 1),
                spaceBetween: toNumber(ds.space, 0),
                speed: 1000,
                observer: true,
                observeParents: true,
                pagination: {
                    el: '.sw-pagination-iconbox',
                    clickable: true,
                },
                slidesPerGroup: toNumber(ds.pagination, 1),
                navigation: {
                    clickable: true,
                    nextEl: '.nav-next-iconbox',
                    prevEl: '.nav-prev-iconbox',
                },
                breakpoints: {
                    575: {
                        slidesPerView: toNumber(ds.mobileSm, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                        slidesPerGroup: toNumber(ds.paginationSm, 1),
                    },
                    768: {
                        slidesPerView: toNumber(ds.tablet, toNumber(ds.mobile, 1)),
                        spaceBetween: toNumber(ds.spaceMd, toNumber(ds.space, 0)),
                        slidesPerGroup: toNumber(ds.paginationMd, 1),
                    },
                    1200: {
                        slidesPerView: toNumber(ds.preview, toNumber(ds.tablet, 1)),
                        spaceBetween: toNumber(ds.spaceLg, toNumber(ds.spaceMd, toNumber(ds.space, 0))),
                        slidesPerGroup: toNumber(ds.paginationLg, 1),
                    },
                },
            },
            SwiperCtor,
        );
    });
};

const initProductGallery = (SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any) => {
    const thumbsEl = document.querySelector<HTMLElement>('.tf-product-media-thumbs');
    const mainEl = document.querySelector<HTMLElement>('.tf-product-media-main');
    if (!thumbsEl || !mainEl) return;

    const direction = thumbsEl.dataset.direction ?? 'vertical';

    const thumbs = createOrReplaceSwiper(
        thumbsEl,
        {
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            direction: 'vertical',
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
            breakpoints: {
                0: {
                    direction: 'horizontal',
                },
                1200: {
                    direction,
                },
            },
        },
        SwiperCtor,
    );

    const main = createOrReplaceSwiper(
        mainEl,
        {
            spaceBetween: 0,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: '.thumbs-next',
                prevEl: '.thumbs-prev',
            },
            thumbs: {
                swiper: thumbs,
            },
        },
        SwiperCtor,
    );

    const update = () => {
        if (thumbs && typeof thumbs.update === 'function') {
            thumbs.update();
        }
        if (main && typeof main.update === 'function') {
            main.update();
        }
    };

    requestAnimationFrame(update);
    window.setTimeout(update, 100);
    window.setTimeout(update, 300);
};

const initCountdowns = () => {
    // Let template's native count-down.js handle first page load.
    // Our custom init should only fill gaps after Inertia navigations.
    if (document.readyState !== 'complete') return;

    const countdownElements = document.querySelectorAll<HTMLElement>('.js-countdown');
    if (!countdownElements.length) return;

    countdownElements.forEach((element) => {
        // Already initialized (either by template script or previous custom init)
        if (element.querySelector('.countdown__timer')) return;

        const labels = (element.dataset.labels ?? '')
            .split(',')
            .map((label) => label.trim())
            .filter((label) => label.length > 0);

        const wrapper = document.createElement('div');
        wrapper.setAttribute('aria-hidden', 'true');
        wrapper.className = 'countdown__timer';

        const values: HTMLElement[] = [];
        for (let i = 0; i < 4; i += 1) {
            const item = document.createElement('span');
            item.className = 'countdown__item';

            const value = document.createElement('span');
            value.className = `countdown__value countdown__value--${i} js-countdown__value--${i}`;
            item.appendChild(value);
            values.push(value);

            if (labels[i]) {
                const label = document.createElement('span');
                label.className = 'countdown__label';
                label.textContent = labels[i];
                item.appendChild(label);
            }

            wrapper.appendChild(item);
        }

        element.prepend(wrapper);

        let endTime = Number.NaN;
        if (element.dataset.timer) {
            endTime = Number(element.dataset.timer) * 1000 + Date.now();
        } else if (element.dataset.countdown) {
            endTime = new Date(element.dataset.countdown).getTime();
        }

        if (!Number.isFinite(endTime)) return;

        const update = () => {
            let remaining = Math.floor((endTime - Date.now()) / 1000);
            if (!Number.isFinite(remaining) || remaining < 0) {
                remaining = 0;
            }

            const days = Math.floor(remaining / 86400);
            remaining %= 86400;
            const hours = Math.floor(remaining / 3600);
            remaining %= 3600;
            const mins = Math.floor(remaining / 60);
            const secs = remaining % 60;

            values[0].textContent = String(days);
            values[1].textContent = String(hours).padStart(2, '0');
            values[2].textContent = String(mins).padStart(2, '0');
            values[3].textContent = String(secs).padStart(2, '0');
        };

        update();
        element.__templateCountdownIntervalId = window.setInterval(update, 1000);
    });
};

const initPreloader = () => {
    const preloader = document.querySelector<HTMLElement>('.preload.preload-container');
    if (!preloader) return;

    window.setTimeout(() => {
        preloader.style.display = 'none';
        preloader.remove();
    }, 100);
};

const initStickyAtcFooterOffset = () => {
    const footer = document.querySelector<HTMLElement>('footer');
    if (!footer) return;

    const stickyAtc = document.querySelector<HTMLElement>('.tf-sticky-btn-atc');
    const scrollTop = document.querySelector<HTMLElement>('#scroll-top');
    if (stickyAtc) {
        footer.classList.add('has-pb');
        scrollTop?.classList.add('type-1');
    } else {
        footer.classList.remove('has-pb');
        scrollTop?.classList.remove('type-1');
    }
};

const runTemplateInit = () => {
    const $ = window.jQuery;
    if (!$) return false;

    $(function () {
        initTemplateThemeVars();
        initImageSelect($);
        initGoTop($);
        initCartSuccess($);
        initStaggerWrap();
        initPreloader();
        initStickyAtcFooterOffset();
        initCountdowns();

        if (window.Swiper) {
            initSlideshow(window.Swiper);
            initCollection(window.Swiper);
            initCategories(window.Swiper);
            initRecent(window.Swiper);
            initShopGallery(window.Swiper);
            initIconbox(window.Swiper);
            initProductGallery(window.Swiper);
        }

        if (window.WOW) {
            new window.WOW().init();
        }
    });

    return true;
};

export const initTemplatePlugins = (attempt = 0) => {
    requestAnimationFrame(() => {
        const initialized = runTemplateInit();

        if (!initialized && attempt < 30) {
            window.setTimeout(() => {
                initTemplatePlugins(attempt + 1);
            }, 50);
        }
    });
};
