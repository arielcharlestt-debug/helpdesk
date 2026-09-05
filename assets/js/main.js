document.addEventListener("alpine:init", () => {
  Alpine.store('colorScheme', {
    name: 'light',

    init() {
      const fromStorage = localStorage.getItem('colorScheme');

      // if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      //     this.name = 'dark'
      // }

      if (fromStorage) {
        this.name = fromStorage
      }
    },

    set(value) {
      if (!['light', 'dark'].includes(value)) {
        return
      };

      this.name = value
      localStorage.setItem('colorScheme', this.name);
    },

    toggle() {
      if (this.name == 'light') {
        this.set('dark');
      } else {
        this.set('light');
      }
    }
  });

  Alpine.store('toast', {
    entries: [],
    add(title, message, type, duration = -1) {
      const id = randomId();
      const safeMessage = new DOMParser().parseFromString(message, 'text/html');

      this.entries.push({
        id: id,
        title: title,
        message: message,
        type: type,
      });

      announceToScreenReader(`${title} ${safeMessage.body.textContent.trim()}`);

      if (duration > 0) {
        setTimeout(() => {
          console.log(`removing ${id} after ${duration}ms`);
          this.entries.splice(this.entries.indexOf(id), 1);
        }, duration);
      }

      if (this.entries.length > 5) {
        this.entries.shift();
      }
    },
    dismiss(index) {
      this.entries.splice(index, 1);
    }
  });

  Alpine.data('blank', () => ({}));

  Alpine.data('statusBar', () => ({
    activeIndex: 0,
    interval: null,
    dismissed: Alpine.$persist(false).as('statusBarDismissed'),

    init() {
      const total = parseInt(this.$root.dataset.total);
      const duration = parseInt(this.$root.dataset.duration);

      if (this.dismissed) {
        document.body.dataset.statusBarDismissed = 'true';
        return;
      }

      if (total <= 1 || !duration) {
        return;
      }

      this.interval = setInterval(() => {
        this.activeIndex = (this.activeIndex + 1) % total;
      }, duration);
    },

    pause() {
      if (this.interval) {
        clearInterval(this.interval);
      }
    },

    resume() {
      const total = parseInt(this.$root.dataset.total);
      const duration = parseInt(this.$root.dataset.duration);

      if (total <= 1 || !duration) {
        return;
      }

      this.interval = setInterval(() => {
        this.activeIndex = (this.activeIndex + 1) % total;
      }, duration);
    },

    dismiss() {
      this.dismissed = true;
      document.body.dataset.statusBarDismissed = 'true';
    },

    isNotDismissed() {
      return !this.dismissed;
    },

    isActive() {
      const index = parseInt(this.$el.dataset.index);
      return this.activeIndex === index;
    },

    isDotActive() {
      const index = parseInt(this.$el.dataset.index);
      return this.activeIndex === index ? 'bg-primary-foreground' : 'bg-primary-foreground/30';
    }
  }));

  Alpine.data("toasty", () => ({
    entries: Alpine.store("toast").entries,

    dismiss() {
      Alpine.store("toast").dismiss(parseInt(this.$el.dataset.index));
    },

    hasEntries() {
      return this.entries.length > 0;
    }
  }));

  Alpine.data("page", () => ({
    get colorSchemeName() {
      return Alpine.store('colorScheme').name;
    }
  }));

  Alpine.data("header", () => ({
    scroll: {
      x: 0,
      y: 0,
    },
    showSidebar: false,
    showForm: false,
    historyChangeListener: null,
    pin: false,
    notTop: false,

    show(state) {
      this[state] = true;
    },

    hide(state) {
      this[state] = false;
    },
    init() {
      this.update(this.scroll);

      window.addEventListener(
        "scroll",
        wp_documentation_throttle(() => {
          this.update(this.scroll);
        }, 250)
      );

      this.$root.querySelectorAll('nav.desktop .menu-item-has-children').forEach((item) => {
        const anchor = item.querySelector('& > a');
        const submenu = item.querySelector('& > .sub-menu');

        if (!anchor || !submenu) {
          return;
        }

        window.FloatingUIDOM?.computePosition(anchor, submenu, {
          placement: 'bottom-start',
        }).then(({ x, y }) => {
          Object.assign(submenu.style, {
            right: `${x}px`,
            top: `${y + 10}px`,
          });
        });
      });
    },

    update(prev) {
      this.scroll = {
        y: window.pageYOffset || document.documentElement.scrollTop,
        x: window.pageXOffset || document.documentElement.scrollLeft,
      };

      if (this.scroll.y > 0) {
        this.notTop = true;
      } else {
        this.notTop = false;
      }

      if (this.scroll.y > 100) {
        this.pin = true;
      }

      if (this.scroll.y < prev.y) {
        this.pin = false;
      }
    },

    showSearch() {
      this.$store.searchPanel.show();
    },

    headerClass() {
      return [this.notTop ? '' : ''];
    },

    colorSchemeToggle() {
      this.$store.colorScheme.toggle();
    },

    isLight() {
      return this.$store.colorScheme.name === 'light';
    },

    isDark() {
      return this.$store.colorScheme.name === 'dark';
    },

    handleMenuButtonClick() {
      return this.showSidebar ? this.hide('showSidebar') : this.show('showSidebar')
    },

    isSidebarVisible() {
      return this.showSidebar;
    },

    isSidebarHidden() {
      return !this.showSidebar;
    },

    handleSidebarWindowEscape(e) {
      if (e.key === 'Escape') {
        this.hide('showSidebar');
      }
    }
  }));

  Alpine.data("docsCard", () => ({
    expanded: false,

    get isListItemVisible() {
      return this.expanded || parseInt(this.$el.dataset.index) < 5;
    },

    isExpanded() {
      return this.expanded;
    },

    isNotExpanded() {
      return !this.expanded;
    },

    toggleExpanded() {
      this.expanded = !this.expanded;
    }
  }));

  Alpine.data("docsSidebarItem", () => ({
    expanded: false,

    init() {
      return this.$root.dataset.isCurrent === 'true' ? this.expanded = true : this.expanded = false;
    },

    get liClass() {
      return this.expanded ? 'block' : 'hidden'
    },

    isExpanded() {
      return this.expanded;
    },

    isNotExpanded() {
      return !this.expanded;
    },

    toggleExpanded() {
      this.expanded = !this.expanded;
    }
  }));

  Alpine.data("docsOverlays", () => ({
    showSidebar: false,
    showToc: false,

    toggleSidebar() {
      this.showSidebar = !this.showSidebar;
    },

    toggleToc() {
      this.showToc = !this.showToc;
    },

    hideSidebar() {
      this.showSidebar = false;
    },

    hideToc() {
      this.showToc = false;
    },

    isSidebar() {
      return this.showSidebar;
    },

    isNotSidebar() {
      return !this.showSidebar;
    },

    isToc() {
      return this.showToc;
    },

    isNotToc() {
      return !this.showToc;
    },

    sidebarClass() {
      return { 'translate-x-[22.5rem] z-[1501]': this.showSidebar }
    },

    tocClass() {
      return { '-translate-x-[22.5rem] z-[1501]': this.showToc }
    }
  }));


  Alpine.data("faq", () => ({
    activeIndex: null,

    handleWindowEscape(e) {
      if (e.key === 'ArrowDown') {
        this.activeIndex = (this.activeIndex + 1) % 3;
      } else if (e.key === 'ArrowUp') {
        this.activeIndex = (this.activeIndex + 3 - 1) % 3;
      }
    },

    isActive() {
      return this.activeIndex === parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex);
    },

    isNotActive() {
      return !this.isActive();
    },

    handleClick() {
      this.activeIndex = this.activeIndex === parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex) ? null : parseInt(this.$el.closest('div[data-active-index]').dataset.activeIndex)
    }
  }));

  Alpine.data('tabs', () => ({
    activeTab: '',
    isCopied: false,
    prefix: '',
    init() {
      this.prefix = this.$root.getAttribute('id');
      const windowHash = window.location.hash;

      if (!windowHash || !windowHash.startsWith(`#${this.prefix}`)) {
        this.activeTab = this.$root.dataset.selectedTab || '';
      }

      if (windowHash.startsWith(`#${this.prefix}`)) {
        this.activeTab = windowHash.replace('#', '');
      }
    },
    selectTab() {
      this.activeTab = this.$el.getAttribute('href').replace('#', '');
    },
    get isActive() {
      return this.activeTab === this.$el.dataset.tabId;
    },
    get isNotCopied() {
      return !this.isCopied;
    }
  }));

  Alpine.data('collapse', () => ({
    expanded: false,
    init() {
      this.expanded = this.$root.dataset.defaultState === 'true';
    },
    toggle() {
      this.expanded = !this.expanded;
    },
    isNotExpanded() {
      return !this.expanded;
    }
  }));

  Alpine.data('codeSnippet', () => ({
    preview: false,

    init() {
      if (this.$root.dataset.defaultState === 'preview') {
        this.preview = true;
      }
    },
    togglePreview() {
      this.preview = !this.preview;
    },
    isPreviewing() {
      return this.preview;
    },
    isEditing() {
      return !this.preview
    }
  }));

  Alpine.data('lightbox', () => ({
    images: [],
    activeIndex: 0,
    embla: null,
    isVisible: false,

    init() {
      const images = document.querySelectorAll('.prose img');

      if (images.length < 1) {
        return;
      }

      const emblaElement = this.$el.querySelector('.embla');

      this.embla = EmblaCarousel(emblaElement);

      images.forEach((img, index) => {
        this.images.push({
          src: img.src,
          alt: img.alt || '',
          title: img.title || ''
        });

        img.addEventListener('click', () => {
          this.isVisible = true;
          this.activeIndex = index;
          this.$nextTick(() => {
            this.embla.scrollTo(index, true);
            emblaElement.classList.add('xyz-in');
          });
        });
      });

      this.images = Array.from(images).map(img => ({
        src: img.src,
        alt: img.alt || '',
        title: img.title || ''
      }));

      this.embla.on('select', () => {
        this.activeIndex = this.embla.selectedScrollSnap();
        images[this.activeIndex]?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      });
    },

    get src() {
      return this.images[this.$el.dataset.index]?.src || '';
    },

    get alt() {
      return this.images[this.$el.dataset.index]?.alt || '';
    },

    show() {
      this.isVisible = true;
    },
    hide() {
      this.isVisible = false;
    },

    get isPrevDisabled() {
      return this.activeIndex === 0;
    },

    get isNextDisabled() {
      return this.activeIndex === this.images.length - 1;
    },

    next() {
      if (this.activeIndex < this.images.length - 1) {
        this.activeIndex++;
        this.embla.scrollTo(this.activeIndex);
      }
    },

    prev() {
      if (this.activeIndex > 0) {
        this.activeIndex--;
        this.embla.scrollTo(this.activeIndex);
      }
    }
  }));


  Alpine.data('mermaid', () => ({
    init() {
      this.render();
    },

    async render() {
      if (window.mermaid) {
        const theme = Alpine.store('colorScheme').name === 'dark' ? 'dark' : 'default';

        mermaid.initialize({
          startOnLoad: false,
          theme,
        });

        await mermaid.run({
          nodes: [this.$refs.mermaid]
        });
      };
    },

    zoom() {
      const lightbox = this.$root.nextElementSibling;
      const mermaidClone = this.$refs.mermaid.cloneNode(true);

      if (!lightbox.querySelector('pre')) {
        lightbox.appendChild(mermaidClone);
      }

      lightbox.style.display = 'flex';

      lightbox.querySelector('.close')?.addEventListener('click', () => {
        lightbox.style.display = 'none';
      });
    },

    download() {
      // Find the SVG inside the mermaid ref
      const svg = this.$refs.mermaid.querySelector('svg');
      if (!svg) {
        Alpine.store('toast').add('Error', 'No SVG found to download.', 'error', 3000);
        return;
      }
      // Serialize SVG
      const serializer = new XMLSerializer();
      let svgString = serializer.serializeToString(svg);
      // Add XML declaration for compatibility
      svgString = '<?xml version="1.0" encoding="UTF-8"?>' + svgString;
      // Create Blob and download link
      const blob = new Blob([svgString], { type: 'image/svg+xml' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = this.$root.dataset.id ? `${this.$root.dataset.id}.svg` : 'mermaid-diagram.svg';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
      Alpine.store('toast').add('Success', 'SVG downloaded.', 'success', 3000);
    },
  }));

  Alpine.directive("prose-color", (el, { modifiers }) => {
    const colorName = modifiers[0];       // e.g. "primary", "blue", "gray"
    const availableShades = [0, 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

    const getColor = (ns, shade) => {
      // `primary` is registered as a flat CSS var string ("var(--color-primary)"),
      // not a shade object. Branch to the dedicated primary handler instead.
      if (ns === 'primary') {
        return readResolvedPrimary();
      }
      return twind.presetTailwind_colors?.[ns]?.[shade];
    };

    const findClosestColor = (ns, targetShade) => {
      let closestShade = null;
      let minDiff = Infinity;

      for (const shade of availableShades) {
        const color = getColor(ns, shade);
        if (color) {
          const diff = Math.abs(shade - targetShade);
          if (diff < minDiff) {
            minDiff = diff;
            closestShade = shade;
          }
        }
      }

      return closestShade !== null ? getColor(ns, closestShade) : null;
    };

    const getShadeForMode = (shade, mode) => {
      if (mode === 'light') {
        // Light mode: 0 is lightest, 1000 is darkest
        return shade;
      } else {
        // Dark mode: 0 is darkest, 1000 is lightest
        // Map 0->1000, 50->900, 100->800, etc.
        const index = availableShades.indexOf(shade);
        return availableShades[availableShades.length - 1 - index];
      }
    };

    const readResolvedPrimary = () => {
      // The primary color is registered as "var(--color-primary)" in head.js,
      // so look up the resolved CSS variable from :root instead of the Twind tree.
      const raw = getComputedStyle(document.documentElement)
        .getPropertyValue('--color-primary')
        .trim();
      return raw || null;
    };

    const apply = () => {
      const scheme = document.body.getAttribute("data-color-scheme") || 'light';

      // Set primary color
      const primaryShade = scheme === 'dark' ? 300 : 700;
      const primaryColor = getColor(colorName, primaryShade) || findClosestColor(colorName, primaryShade);
      el.style.setProperty(`--color-primary`, primaryColor);

      // For `primary` we only need to set --color-primary; the bg-primary-* /
      // text-primary-* / border-primary-* Twind classes already resolve to the
      // matching --color-primary-* CSS variables defined in functions.php.
      // Skipping the frost remap avoids overwriting the gray palette that the
      // rest of the page relies on.
      if (colorName === 'primary') {
        return;
      }

      // Set all frost shades (0 to 1000)
      availableShades.forEach((shade) => {
        const targetShade = getShadeForMode(shade, scheme);
        const color = getColor(colorName, targetShade) || findClosestColor(colorName, targetShade);

        if (color) {
          el.style.setProperty(`--color-frost-${shade}`, color);
        } else {
          // If no color found at all, use a fallback (e.g., gray)
          const fallbackColor = getColor('gray', targetShade) || findClosestColor('gray', targetShade);
          el.style.setProperty(`--color-frost-${shade}`, fallbackColor || '#000000');
        }
      });
    };

    // Apply on load
    apply();

    // Watch for attribute changes on <body>
    const observer = new MutationObserver(apply);
    observer.observe(document.body, {
      attributes: true,
      attributeFilter: ["data-color-scheme"],
    });
  });
  Alpine.directive('copy', (el) => {
    // Add Alpine data for copy state if not present
    if (!el._x_dataCopyState) {
      Alpine.bind(el, {
        'x-data'() {
          return {
            copied: false,
            copyTimeout: null,
            get isCopied() {
              return this.copied;
            },
            showCopied() {
              this.copied = true;
              if (this.copyTimeout) clearTimeout(this.copyTimeout);
              this.copyTimeout = setTimeout(() => {
                this.copied = false;
                this.copyTimeout = null;
              }, 2000);
            }
          }
        }
      });
      el._x_dataCopyState = true;
    }
    el.addEventListener('click', async () => {
      const text = el.dataset.copy;
      if (!text) return console.warn('No data-copy attribute found.');

      // Limit the length of the text shown in the toast
      const maxLength = 60;
      let displayText = text;
      if (text.length > maxLength) {
        displayText = text.substring(0, maxLength) + '…';
      }

      try {
        await navigator.clipboard.writeText(text);
        Alpine.store('toast').add('Copied', `Copied: ${displayText}`, 'success', 3000);
        if (el._x_dataCopyState && el.__x) {
          el.__x.$data.showCopied();
        }
      } catch (err) {
        Alpine.store('toast').add('Error', 'Failed to copy to clipboard.', 'error', 3000);
      }
    });
  });

  // Alpine directive: zoom (mouse hover zoom, follows cursor)
  Alpine.directive('zoom', (el, { value, modifiers, expression }, { Alpine }) => {
    // Default scale or from modifier
    const scale = modifiers && modifiers.length ? parseFloat(modifiers[0]) : 1.5;
    const transition = 'transform 0.3s cubic-bezier(0.19,1,0.22,1)';
    el.style.transition = transition;
    el.style.cursor = 'zoom-in';

    // Mouse move: zoom at cursor, update origin as mouse moves
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;
      el.style.transformOrigin = `${x}% ${y}%`;
      el.style.transform = `scale(${scale})`;
    });

    // Mouse leave: reset zoom
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'scale(1)';
      el.style.cursor = 'zoom-in';
    });

    // Optional: on mousedown, set cursor to grabbing
    el.addEventListener('mousedown', () => {
      el.style.cursor = 'zoom-out';
    });

    el.addEventListener('mouseup', () => {
      el.style.cursor = 'zoom-in';
    });
  });

  Alpine.magic('clipboard', () => {
    if (!navigator.clipboard) {
      return
    }

    return subject => {
      navigator.clipboard.writeText(subject)
    }
  });

  Alpine.directive('lazy-src', (el, { value }) => {
    const imgSrc = value;

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting || entry.intersectionRatio > 0) {
            el.setAttribute('src', imgSrc);
            observer.unobserve(el);
          }
        });
      });

      observer.observe(el);
      el.setAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'); // Transparent base64 image
    } else {
      // Fallback for browsers that don't support Intersection Observer
      el.setAttribute('src', imgSrc);
    }
  });

  Alpine.directive('embla', (
    el,
    { value, modifiers, expression },
    { Alpine, effect, cleanup }
  ) => {
    if (!value) {
      Alpine.bind(el, {
        "x-data": () => ({
          embla: null,
          activeIndex: 0,
          canScrollNext: true,
          canScrollPrev: true,
          emblaPrev() {
            this.embla?.scrollPrev();
          },
          emblaNext() {
            this.embla?.scrollNext();
          },
        }),
      });
    } else if (value === 'main') {
      const autplayDelay = modifierValue(modifiers, 'autoplay', false);
      const autoplayOpttions = {
        delay: parseInt(autplayDelay),
      }
      Alpine.bind(el, {
        "x-init"() {
          const handleDisabledState = () => {
            this.canScrollNext = this.embla.canScrollNext();
            this.canScrollPrev = this.embla.canScrollPrev();
          }
          window.addEventListener("load", () => {
            const plugins = [];
            if (autplayDelay) {
              plugins.push(EmblaCarouselAutoplay(autoplayOpttions));
            }
            this.embla = EmblaCarousel(el, {
              loop: modifierValue(modifiers, 'loop', false) === '1' ? true : false,
              align: modifierValue(modifiers, 'align', 'center')
            }, plugins);
            this.embla.on('select', () => {
              this.activeIndex = this.embla.selectedScrollSnap();
            });
            this.embla.on('select', handleDisabledState);
            this.embla.on('settle', handleDisabledState);
            this.embla.on('init', handleDisabledState);
            this.embla.on('scroll', handleDisabledState);
            this.embla.on('resize', handleDisabledState);
            window.addEventListener('keydown', (e) => {
              if (e.key === 'ArrowLeft') {
                this.embla.scrollPrev();
              } else if (e.key === 'ArrowRight') {
                this.embla.scrollNext();
              }
            })
            // Set initial state
            handleDisabledState();
          });
        },
      });
    } else if (value === 'page') {
      Alpine.bind(el, {
        "x-on:click.prevent"() {
          this.embla?.scrollTo(parseInt(expression))
        },
        ":disabled"() {
          return this.activeIndex === parseInt(expression);
        },
        ":class"() {
          return this.activeIndex === parseInt(expression) ? 'is-active' : '';
        }
      });
    } else if (value === 'next') {
      Alpine.bind(el, {
        "x-on:click.prevent"(e) {
          this.embla?.scrollNext();
        },
        ":disabled"() {
          return !this.canScrollNext;
        },
        ":class"() {
          return !this.canScrollNext ? 'is-disabled' : '';
        }
      });
    } else if (value === 'prev') {
      Alpine.bind(el, {
        "x-on:click.prevent"(e) {
          this.embla?.scrollPrev();
        },
        ":disabled"() {
          return !this.canScrollPrev;
        },
        ":class"() {
          return !this.canScrollPrev ? 'is-disabled' : '';
        }
      });
    }
    return () => {
      embla.destroy();
    };
  })
});

jQuery(document).ready(() => {
  const $ = jQuery;
  const isMobile = window.matchMedia("(max-width: 767px)");

  $('#commentform').each((i, form) => {
    $(form).find('input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]):not([style="display: none;"]), select, textarea').each((i, input) => {
      const label = $(form).find(`label[for="${input.getAttribute('id')}"]`);

      input.addEventListener("invalid", function (event) {
        let message = '';

        if (event.target.value.length < 1) {
          message = `${label.text().trim()} is required`;
        } else {
          message = `${label.text().trim()} is invalid`;
        }

        if (isMobile.matches) {
          input.setCustomValidity(message);
          announceToScreenReader(message, 'alert', 100, true);
        } else {
          input.setCustomValidity(message);
        }
      });

      input.addEventListener("input", function (event) {
        input.setCustomValidity("");
      });
    });
  });

  $('.wp_documentation_pagination').each((i, pagination) => {
    $(pagination).find('a.prev.page-numbers').parent().addClass('prev-item');
    $(pagination).find('a.next.page-numbers').parent().addClass('next-item');
  });

  documentationAddHeadingSlugs('.single-docs .entry-content, .single-post .entry-content');

  function handleDocsHeadings() {

    const handleTocAnchor = (entry) => {
      if (entry.target.id) {
        const allElements = document.querySelectorAll(`.wp_documentation_toc a`);
        const targetElements = document.querySelectorAll(`.wp_documentation_toc a[href="#${entry.target.id}"]`);

        if (entry.isIntersecting) {
          allElements.forEach(element => {
            element.parentElement.classList.remove('active');
            element.removeAttribute('aria-current');
          });

          targetElements.forEach(targetElement => {
            targetElement.parentElement.classList.add('active');
            targetElement.setAttribute('aria-current', 'true');
          });
        } else {
         
        }
      }
    };

    const handleIntersection = (entries, observer) => entries.forEach(entry => handleTocAnchor(entry));

    const observer = new IntersectionObserver(handleIntersection, { root: null, rootMargin: '0px 0px -80% 0px', threshold: 0 });

    $('.single-docs .entry-content, .single-post .entry-content').find('h1, h2, h3, h4, h5, h6').each(function (i, heading) {
      if (!heading.hasAttribute('id')) {
        $(heading).attr('id', documentationGenerateSlug(heading.textContent));
      }

      observer.observe(heading)
    });
  }

  $('.comment-content').addClass('prose');

  window.addEventListener("hashchange", () => {
    const hash = window.location.hash;

    if (hash) {
      const element = document.querySelector(hash);
      if (element) {
        element.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    };
  });

  document.querySelectorAll('pre').forEach((el) => {
    if (el.classList.contains('shiki')) {
      return;
    }

    const code = el.querySelector('code');

    if (!code) {
      return;
    }

    hljs.highlightElement(code);
  });

  const el = [...document.querySelectorAll('#content > .docs-sidebar a[aria-current="page"]')].at(-1);
  if (el) {
    const rect = el.getBoundingClientRect();
    const isInView =
      rect.top >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight);

    if (!isInView) {
      el.scrollIntoView({
        block: 'center',
        inline: 'nearest',
        behavior: 'smooth'
      });
    }
  }

  handleDesktopMenu();
  handleDocsHeadings();
});


// Function to convert text into a valid WordPress-compatible slug (similar to wp_sanitize_title)
function documentationGenerateSlug(text) {
  // Remove HTML tags
  text = text.replace(/<[^>]*>/g, '');

  // Convert to lowercase
  text = text.toLowerCase();

  // Replace non-alphanumeric characters (except hyphens) with hyphens
  text = text.replace(/[^a-z0-9-]+/g, '-');

  // Remove leading and trailing hyphens
  text = text.replace(/^-+|-+$/g, '');

  // If the slug starts with a number, prepend 'id-' to make it valid
  if (/^[0-9]/.test(text)) {
    text = 'id-' + text;
  }

  return text;
}

// Function to add generated slugs to all headings inside a container
function documentationAddHeadingSlugs(selector) {
  const container = document.querySelector(selector);

  if (container) {
    // Find all headings (h1-h2-h3-h4-h5-h6) inside the container
    const headings = container.querySelectorAll('h1, h2, h3, h4, h5, h6');

    headings.forEach(heading => {
      // Generate a valid slug based on the heading text
      const headingSlug = documentationGenerateSlug(heading.textContent);

      // Set the ID as an attribute of the heading
      heading.id = headingSlug;
    });
  } else {
    // console.error(`Container with selector "${selector}" not found.`);
  }
}


function handleDesktopMenu() {
  const $ = jQuery;

  const menuItems = document.querySelectorAll('.menu-item');

  if (menuItems.length > 0) {
    menuItems.forEach((item) => {
      handleMenuItem(item);
    });
  }

  function handleMenuItem(item) {
    const anchor = item.querySelector('a');
    const toggle = item.querySelector('.menu-toggle');
    const submenu = item.querySelector('.sub-menu');

    if (!toggle || !submenu || !anchor) {
      return;
    }

    toggle.setAttribute('aria-label', `${anchor.textContent.trim()}`);

    toggle.addEventListener('click', () => {
      item.classList.toggle('toggled');
      toggle.setAttribute('aria-expanded', item.classList.contains('toggled'));
    });

    anchor.addEventListener('keydown', (e) => {
      if (e.key === 'Tab' && e.shiftKey) {
        item.classList.remove('toggled');
      }
    });

    handleSubMenu(item, submenu)
  }

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const item = e.target.closest('.toggled');

      if (!item) {
        return
      }

      const toggle = item.querySelector('.menu-toggle');

      item.classList.remove('toggled');

      if (toggle) {
        toggle.focus();
      }
    }
  });

  function handleSubMenu(item, menu) {
    const items = menu.querySelectorAll('.menu-item');
    const last = items[items.length - 1];
    const lastAnchor = last.querySelector('a');

    if (lastAnchor) {
      lastAnchor.addEventListener('keydown', (e) => {
        if (e.key === 'Tab' && !e.shiftKey) {
          item.classList.remove('toggled');
        }
      });
    }
  }

}


let liveElementTimeout = null;

function announceToScreenReader(text, role, timeout = 1000, once = false) {
  if (once && liveElementTimeout) {
    return;
  }

  const liveElement = document.querySelector(".live-status-region");
  const paraElement = document.createElement("p");
  const textElement = document.createTextNode(text);

  if (!liveElement) {
    return;
  }

  liveElement.setAttribute("role", role === undefined ? "status" : role);
  paraElement.appendChild(textElement);
  liveElement.appendChild(paraElement);

  liveElementTimeout = setTimeout(() => {
    liveElement.innerHTML = "";
    liveElement.setAttribute("role", "status");
    liveElementTimeout = null;
  }, timeout);
}

function wp_documentation_throttle(func) {
  let queued = false;

  return function (...args) {
    if (!queued) {
      queued = true;
      requestAnimationFrame(() => {
        func.apply(this, args);
        queued = false;
      });
    }
  };
}
function modifierValue(modifiers, key, fallback) {
  if (modifiers.indexOf(key) === -1) return fallback;

  const rawValue = modifiers[modifiers.indexOf(key) + 1];

  if (!rawValue) return fallback;

  return rawValue;
}

function randomId(length = 10) {
  const possibleCharacters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  const possibleCharacterArray = Array.from(possibleCharacters);
  const resultArray = [];

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * possibleCharacterArray.length);
    const randomCharacter = possibleCharacterArray[randomIndex];
    resultArray.push(randomCharacter);
  }

  return resultArray.join('');
}

// Skip link focus fix for IE/Edge
(function () {
  if (/trident|msie/i.test(navigator.userAgent) && document.getElementById && window.addEventListener) {
    window.addEventListener("hashchange", function () {
      var id = location.hash.substring(1);
      if (/^[A-z0-9_-]+$/.test(id)) {
        var el = document.getElementById(id);
        if (el) {
          if (!/^(?:a|select|input|button|textarea)$/i.test(el.tagName)) {
            el.tabIndex = -1;
          }
          el.focus();
        }
      }
    }, false);
  }
})();
