window.addEventListener('load', function () {
    const loader = document.getElementById('site-loader')
    const page = document.getElementById('page')

    if (loader && page) {
        window.setTimeout(function () {
            loader.classList.add('opacity-0')
            page.classList.remove('opacity-0')
            page.classList.add('opacity-100')

            window.setTimeout(function () {
                loader.classList.add('pointer-events-none', 'hidden')
            }, 750)
        }, 420)
    } else if (page) {
        page.classList.remove('opacity-0')
        page.classList.add('opacity-100')
    }

    const menuToggle = document.getElementById('site-menu-toggle')
    const menuClose = document.getElementById('site-menu-close')
    const menuOverlay = document.getElementById('site-menu-overlay')

    if (!menuToggle || !menuOverlay) {
        return
    }

    const openClasses = ['translate-y-0', 'opacity-100', 'pointer-events-auto']
    const closedClasses = ['-translate-y-8', 'opacity-0', 'pointer-events-none']

    function openMenu() {
        menuOverlay.classList.remove(...closedClasses)
        menuOverlay.classList.add(...openClasses)
        menuToggle.setAttribute('aria-expanded', 'true')
        document.body.classList.add('overflow-hidden')
    }

    function closeMenu() {
        menuOverlay.classList.remove(...openClasses)
        menuOverlay.classList.add(...closedClasses)
        menuToggle.setAttribute('aria-expanded', 'false')
        document.body.classList.remove('overflow-hidden')
    }

    menuToggle.addEventListener('click', function (e) {
        e.preventDefault()
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true'
        if (isOpen) {
            closeMenu()
            return
        }
        openMenu()
    })

    if (menuClose) {
        menuClose.addEventListener('click', function () {
            closeMenu()
        })
    }

    menuOverlay.addEventListener('click', function (e) {
        if (e.target === menuOverlay) {
            closeMenu()
        }
    })

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMenu()
        }
    })

    initStudioScrollSpy()
})

function initStudioScrollSpy() {
    const links = Array.from(document.querySelectorAll('.studio-nav-link'))
    if (!links.length) {
        return
    }

    const items = links
        .map(function (link) {
            const href = link.getAttribute('href') || ''
            if (!href.startsWith('#')) {
                return null
            }

            const section = document.querySelector(href)
            if (!section) {
                return null
            }

            return { link, section }
        })
        .filter(Boolean)

    if (!items.length) {
        return
    }

    function setActive(activeLink) {
        links.forEach(function (link) {
            const dot = link.querySelector('.studio-nav-dot')
            const isActive = link === activeLink
            link.classList.toggle('font-semibold', isActive)
            link.classList.toggle('text-[#242424]', isActive)
            link.classList.toggle('text-[rgba(30,30,30,0.48)]', !isActive)
            if (dot) {
                dot.classList.toggle('opacity-0', !isActive)
            }
        })
    }

    function updateActiveFromScroll() {
        const triggerLine = window.innerHeight * 0.28
        let current = items[0]

        items.forEach(function (item) {
            const top = item.section.getBoundingClientRect().top
            if (top <= triggerLine) {
                current = item
            }
        })

        if (current) {
            setActive(current.link)
        }
    }

    window.addEventListener('scroll', updateActiveFromScroll, { passive: true })
    window.addEventListener('resize', updateActiveFromScroll)
    updateActiveFromScroll()
}

function initArtiWayAccordion($) {
    const $accordion = $('.arti-way-accordion')
    if (!$accordion.length) {
        return
    }

    const activeRowClasses = [
        'bg-cover',
        'bg-center',
        'bg-no-repeat',
        'bg-blend-multiply',
        'bg-[rgba(109,85,80,0.58)]'
    ].join(' ')

    function closeItem($item) {
        const $trigger = $item.find('.arti-way-trigger')
        $trigger.removeClass(activeRowClasses)
        $trigger.css('background-image', '')
        $trigger.attr('aria-expanded', 'false')
        $trigger.find('.arti-way-number, .arti-way-label, .arti-way-title').removeClass('!text-[#D4CFC7]')
        $item.find('.arti-way-panel').stop(true, true).slideUp(220).addClass('hidden')
    }

    function openItem($item) {
        const image = $item.data('bg')
        const $trigger = $item.find('.arti-way-trigger')
        $trigger.addClass(activeRowClasses)

        if (image) {
            $trigger.css('background-image', 'linear-gradient(rgba(109,85,80,0.58), rgba(109,85,80,0.58)), url(' + image + ')')
        }

        $trigger.attr('aria-expanded', 'true')
        $trigger.find('.arti-way-number, .arti-way-label, .arti-way-title').addClass('!text-[#D4CFC7]')
        $item.find('.arti-way-panel').removeClass('hidden').stop(true, true).slideDown(220)
    }

    $accordion.find('.arti-way-item').each(function (index) {
        const $item = $(this)
        if (index !== 0) {
            closeItem($item)
        }
    })

    openItem($accordion.find('.arti-way-item').first())

    $accordion.on('click', '.arti-way-trigger', function () {
        const $current = $(this).closest('.arti-way-item')
        const isOpen = $(this).attr('aria-expanded') === 'true'

        $accordion.find('.arti-way-item').not($current).each(function () {
            closeItem($(this))
        })

        if (isOpen) {
            closeItem($current)
            return
        }

        openItem($current)
    })
}

function bootstrapArtiWayAccordion() {
    if (!window.jQuery) {
        window.setTimeout(bootstrapArtiWayAccordion, 60)
        return
    }

    window.jQuery(function ($) {
        initArtiWayAccordion($)
    })
}

bootstrapArtiWayAccordion()
