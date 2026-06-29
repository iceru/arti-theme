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
    const menuOverlay = document.getElementById('site-menu-overlay')
    initContactTabs()

    if (!menuToggle || !menuOverlay) {
        return
    }

    const openClasses = ['translate-y-0', 'opacity-100', 'pointer-events-auto']
    const closedClasses = ['-translate-y-8', 'opacity-0', 'pointer-events-none']
    let closeMenuTimer = null

    function openMenu() {
        window.clearTimeout(closeMenuTimer)
        document.body.classList.remove('site-menu-closing')
        menuOverlay.classList.remove(...closedClasses)
        menuOverlay.classList.add(...openClasses)
        menuToggle.setAttribute('aria-expanded', 'true')
        menuToggle.setAttribute('aria-label', 'Close menu')
        menuToggle.querySelector('.site-menu-line-top')?.classList.add('translate-y-0', 'rotate-45')
        menuToggle.querySelector('.site-menu-line-top')?.classList.remove('-translate-y-1')
        menuToggle.querySelector('.site-menu-line-bottom')?.classList.add('translate-y-0', '-rotate-45')
        menuToggle.querySelector('.site-menu-line-bottom')?.classList.remove('translate-y-1')
        document.body.classList.add('overflow-hidden')
        document.body.classList.add('site-menu-open')
    }

    function closeMenu() {
        window.clearTimeout(closeMenuTimer)
        document.body.classList.add('site-menu-closing')
        menuOverlay.classList.remove(...openClasses)
        menuOverlay.classList.add(...closedClasses)
        menuToggle.setAttribute('aria-expanded', 'false')
        menuToggle.setAttribute('aria-label', 'Open menu')
        menuToggle.querySelector('.site-menu-line-top')?.classList.remove('translate-y-0', 'rotate-45')
        menuToggle.querySelector('.site-menu-line-top')?.classList.add('-translate-y-1')
        menuToggle.querySelector('.site-menu-line-bottom')?.classList.remove('translate-y-0', '-rotate-45')
        menuToggle.querySelector('.site-menu-line-bottom')?.classList.add('translate-y-1')
        document.body.classList.remove('overflow-hidden')
        document.body.classList.remove('site-menu-open')
        closeMenuTimer = window.setTimeout(function () {
            document.body.classList.remove('site-menu-closing')
        }, 1120)
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
    initHomepageBloat()
})

function initHomepageBloat() {
    const hero = document.querySelector('.homepage-hero')
    if (!hero) {
        return
    }

    const canvas = hero.querySelector('.homepage-hero__canvas')
    if (!canvas) {
        return
    }

    const ctx = canvas.getContext('2d', { willReadFrequently: true })
    if (!ctx) {
        return
    }

    const bgVar = hero.style.getPropertyValue('--hero-bg').trim()
    const imgUrl = bgVar.replace(/^url\(["']?/, '').replace(/["']?\)$/, '')
    if (!imgUrl) {
        return
    }

    const image = new Image()
    image.src = imgUrl

    const baseCanvas = document.createElement('canvas')
    const baseCtx = baseCanvas.getContext('2d', { willReadFrequently: true })
    if (!baseCtx) {
        return
    }

    let hover = false
    let tx = 0
    let ty = 0
    let cx = 0
    let cy = 0
    let rafId = null

    function resizeCanvas() {
        const rect = hero.getBoundingClientRect()
        const width = Math.max(1, Math.floor(rect.width))
        const height = Math.max(1, Math.floor(rect.height))

        if (canvas.width !== width || canvas.height !== height) {
            canvas.width = width
            canvas.height = height
            baseCanvas.width = width
            baseCanvas.height = height
        }

        return { width, height }
    }

    function drawBase(width, height) {
        ctx.clearRect(0, 0, width, height)
        baseCtx.clearRect(0, 0, width, height)

        if (!image.complete || !image.naturalWidth || !image.naturalHeight) {
            return
        }

        const imgRatio = image.naturalWidth / image.naturalHeight
        const boxRatio = width / height
        let drawW = width
        let drawH = height
        let drawX = 0
        let drawY = 0

        if (imgRatio > boxRatio) {
            drawW = height * imgRatio
            drawX = (width - drawW) / 2
        } else {
            drawH = width / imgRatio
            drawY = (height - drawH) / 2
        }

        baseCtx.save()
        baseCtx.globalAlpha = 0.5
        baseCtx.drawImage(image, drawX, drawY, drawW, drawH)
        baseCtx.restore()
        ctx.drawImage(baseCanvas, 0, 0)
    }

    function drawFrame() {
        const size = resizeCanvas()
        const width = size.width
        const height = size.height

        drawBase(width, height)
        if (!image.complete || !image.naturalWidth || !image.naturalHeight) {
            return
        }

        if (!hover) {
            return
        }

        cx += (tx - cx) * 0.18
        cy += (ty - cy) * 0.18

        const radius = 140
        const strength = 0.4
        const baseData = baseCtx.getImageData(0, 0, width, height)
        const output = new ImageData(new Uint8ClampedArray(baseData.data), width, height)
        const src = baseData.data
        const dest = output.data
        const left = Math.max(0, Math.floor(cx - radius))
        const right = Math.min(width - 1, Math.ceil(cx + radius))
        const top = Math.max(0, Math.floor(cy - radius))
        const bottom = Math.min(height - 1, Math.ceil(cy + radius))

        for (let y = top; y <= bottom; y++) {
            for (let x = left; x <= right; x++) {
                const dx = x - cx
                const dy = y - cy
                const distance = Math.sqrt(dx * dx + dy * dy)

                if (distance > radius) {
                    continue
                }

                const edge = distance / radius
                const pull = 1 - strength * Math.pow(1 - edge, 2)
                const sx = Math.max(0, Math.min(width - 1, Math.round(cx + dx * pull)))
                const sy = Math.max(0, Math.min(height - 1, Math.round(cy + dy * pull)))
                const sourceIndex = (sy * width + sx) * 4
                const destIndex = (y * width + x) * 4

                dest[destIndex] = src[sourceIndex]
                dest[destIndex + 1] = src[sourceIndex + 1]
                dest[destIndex + 2] = src[sourceIndex + 2]
                dest[destIndex + 3] = src[sourceIndex + 3]
            }
        }

        ctx.putImageData(output, 0, 0)
    }

    function animateLens() {
        drawFrame()

        rafId = window.requestAnimationFrame(animateLens)
    }

    function ensureAnimation() {
        if (!rafId) {
            rafId = window.requestAnimationFrame(animateLens)
        }
    }

    image.onload = function () {
        drawFrame()
    }

    window.addEventListener('resize', function () {
        drawFrame()
    })

    hero.addEventListener('mousemove', function (e) {
        const rect = hero.getBoundingClientRect()
        tx = e.clientX - rect.left
        ty = e.clientY - rect.top
        if (!hover) {
            cx = tx
            cy = ty
        }
        hover = true
        ensureAnimation()
    })

    hero.addEventListener('mouseenter', function () {
        hover = true
        ensureAnimation()
    })

    hero.addEventListener('mouseleave', function () {
        hover = false
        drawFrame()
        if (rafId) {
            window.cancelAnimationFrame(rafId)
            rafId = null
        }
    })

    drawFrame()
}

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
            link.classList.toggle('opacity-100', isActive)
            link.classList.toggle('opacity-40', !isActive)
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
    items.forEach(function (item) {
        item.link.addEventListener('click', function (event) {
            event.preventDefault()

            const header = document.getElementById('site-header')
            const headerHeight = header ? header.getBoundingClientRect().height : 0
            const targetY = item.section.getBoundingClientRect().top + window.pageYOffset - headerHeight - 24

            window.scrollTo({
                top: Math.max(0, targetY),
                behavior: 'smooth',
            })
        })
    })
    updateActiveFromScroll()
}

function initArtiWayAccordion($) {
    const $accordion = $('.arti-way-accordion')
    if (!$accordion.length) {
        return
    }

    function closeItem($item, instant = false) {
        const $trigger = $item.find('.arti-way-trigger')
        const $panel = $item.find('.arti-way-panel')
        const clearBackground = function () {
            $trigger.css('--arti-way-bg', '')
        }

        $trigger.removeClass('is-bg-visible')
        window.clearTimeout($trigger.data('bgClearTimer'))
        window.clearTimeout($trigger.data('bgShowTimer'))
        $trigger.data('bgToken', ($trigger.data('bgToken') || 0) + 1)
        $trigger.attr('aria-expanded', 'false')
        $trigger.find('.arti-way-number, .arti-way-label, .arti-way-title').removeClass('!text-beige-1')

        $panel.stop(true, true).removeClass('hidden')
        if (instant) {
            clearBackground()
            $panel.hide().addClass('hidden')
            return
        }

        $trigger.data('bgClearTimer', window.setTimeout(clearBackground, 540))
        $panel.slideUp(520, function () {
            $(this).addClass('hidden')
        })
    }

    function openItem($item, instant = false) {
        const image = $item.data('bg')
        const $trigger = $item.find('.arti-way-trigger')
        const $panel = $item.find('.arti-way-panel')

        if (image) {
            const token = ($trigger.data('bgToken') || 0) + 1
            const showBackground = function () {
                if ($trigger.data('bgToken') !== token) {
                    return
                }

                $trigger.css('--arti-way-bg', `url("${image}")`)
                $trigger.data('bgShowTimer', window.setTimeout(function () {
                    if ($trigger.data('bgToken') === token) {
                        $trigger.addClass('is-bg-visible')
                    }
                }, instant ? 0 : 30))
            }

            window.clearTimeout($trigger.data('bgClearTimer'))
            window.clearTimeout($trigger.data('bgShowTimer'))
            $trigger.data('bgToken', token)
            $trigger.removeClass('is-bg-visible')

            const preload = new Image()
            preload.onload = showBackground
            preload.onerror = showBackground
            preload.src = image
        }

        $trigger.attr('aria-expanded', 'true')
        $trigger.find('.arti-way-number, .arti-way-label, .arti-way-title').addClass('!text-beige-1')

        $panel.stop(true, true).removeClass('hidden')
        if (instant) {
            $panel.show()
            return
        }

        $panel.hide().slideDown(520)
    }

    $accordion.find('.arti-way-item').each(function () {
        closeItem($(this), true)
    })

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

function initContactTabs() {
    const tabsRoot = document.querySelector('[data-contact-tabs]')
    if (!tabsRoot) {
        return
    }

    const triggers = Array.from(document.querySelectorAll('[data-tab-trigger]'))
    const panels = Array.from(document.querySelectorAll('[data-tab-panel]'))
    if (!triggers.length || !panels.length) {
        return
    }

    function setActive(tabKey) {
        triggers.forEach(function (trigger) {
            const isActive = trigger.getAttribute('data-tab-trigger') === tabKey
            trigger.setAttribute('aria-selected', isActive ? 'true' : 'false')
            trigger.classList.toggle('border-b-2', isActive)
            trigger.classList.toggle('border-zinc-500', isActive)
            trigger.classList.toggle('text-zinc-700', isActive)
            trigger.classList.toggle('border-b', !isActive)
            trigger.classList.toggle('border-zinc-400/45', !isActive)
            trigger.classList.toggle('text-zinc-700/50', !isActive)
            trigger.classList.toggle('text-zinc-700/75', false)
        })

        panels.forEach(function (panel) {
            const isActive = panel.getAttribute('data-tab-panel') === tabKey
            panel.classList.toggle('hidden', !isActive)

            if (!isActive) {
                panel.classList.remove('is-fading-in')
                return
            }

            panel.classList.remove('is-fading-in')
            window.requestAnimationFrame(function () {
                panel.classList.add('is-fading-in')
            })
        })
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const tabKey = trigger.getAttribute('data-tab-trigger')
            if (!tabKey) {
                return
            }
            setActive(tabKey)
        })
    })

    panels.forEach(function (panel) {
        panel.addEventListener('animationend', function (event) {
            if (event.animationName === 'contact-form-fade-in') {
                panel.classList.remove('is-fading-in')
            }
        })
    })
}
