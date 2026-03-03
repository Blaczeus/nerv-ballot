type JQueryLike = ((selector?: unknown) => any) & {
    fn?: Record<string, unknown>;
};

declare global {
    interface Window {
        jQuery?: JQueryLike;
        Swiper?: new (el: Element | string, options: Record<string, unknown>) => any;
        WOW?: new () => { init: () => void };
    }

    interface HTMLElement {
        __templateSwiper?: { destroy: (deleteInstance?: boolean, cleanStyles?: boolean) => void };
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

const createOrReplaceSwiper = (
    element: HTMLElement,
    options: Record<string, unknown>,
    SwiperCtor: new (el: Element, opts: Record<string, unknown>) => any,
) => {
    if (element.__templateSwiper) {
        element.__templateSwiper.destroy(true, true);
    }

    element.__templateSwiper = new SwiperCtor(element, options);
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

const initPreloader = () => {
    const preloader = document.querySelector<HTMLElement>('.preload.preload-container');
    if (!preloader) return;

    window.setTimeout(() => {
        preloader.style.display = 'none';
        preloader.remove();
    }, 100);
};

const runTemplateInit = () => {
    const $ = window.jQuery;
    if (!$) return false;

    $(function () {
        initImageSelect($);
        initGoTop($);
        initPreloader();

        if (window.Swiper) {
            initSlideshow(window.Swiper);
            initCategories(window.Swiper);
            initRecent(window.Swiper);
            initShopGallery(window.Swiper);
            initIconbox(window.Swiper);
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