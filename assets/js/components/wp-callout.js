(function () {
  const TYPE_CONFIG = {
    note:   { color: 'gray',   icon: 'note' },
    tip:    { color: 'green',  icon: 'bulb-filled' },
    info:   { color: 'blue',   icon: 'info-circle-filled' },
    warning:{ color: 'orange', icon: 'alert-triangle-filled' },
    danger: { color: 'red',    icon: 'alert-circle-filled' },
  };

  class WpCallout extends HTMLElement {
    static get observedAttributes() {
      return ['type', 'title', 'collapsed', 'link-url', 'link-title', 'link-target'];
    }

    constructor() {
      super();
      this._expanded = true;
    }

    connectedCallback() {
      this._expanded = !this.hasAttribute('collapsed');
      this.render();
    }

    attributeChangedCallback(name, oldVal, newVal) {
      if (oldVal !== newVal && this.isConnected) {
        if (name === 'collapsed') {
          this._expanded = !this.hasAttribute('collapsed');
          this._applyExpanded();
        } else {
          this.render();
        }
      }
    }

    get _type() { return this.getAttribute('type') || 'note'; }
    get _title() { return this.getAttribute('title') || 'Note'; }
    get _linkUrl() { return this.getAttribute('link-url') || ''; }
    get _linkTitle() { return this.getAttribute('link-title') || ''; }
    get _linkTarget() { return this.getAttribute('link-target') || '_self'; }

    _toggle() {
      this._expanded = !this._expanded;
      this._applyExpanded();
    }

    _applyExpanded() {
      const body = this.querySelector('[data-callout-body]');
      const btn = this.querySelector('[data-callout-btn]');
      const cd = this.querySelector('[data-callout-chevron-down]');
      const cu = this.querySelector('[data-callout-chevron-up]');
      if (body) body.style.display = this._expanded ? 'block' : 'none';
      if (btn) btn.setAttribute('aria-expanded', String(this._expanded));
      if (cd) cd.style.display = this._expanded ? 'none' : 'inline-flex';
      if (cu) cu.style.display = this._expanded ? 'inline-flex' : 'none';
    }

    render() {
      const cfg = TYPE_CONFIG[this._type] || TYPE_CONFIG.note;
      const c = cfg.color;

      const existingProse = this.querySelector('[data-callout-prose]');
      let contentNodes;
      if (existingProse) {
        contentNodes = [...existingProse.childNodes];
      } else {
        contentNodes = [...this.childNodes];
      }

      const iconSvg = this._icon(cfg.icon);
      const downSvg = this._icon('chevron-down');
      const upSvg = this._icon('chevron-up');

      let linkHtml = '';
      if (this._linkUrl) {
        linkHtml = `<div class="my-4"><a href="${this._esc(this._linkUrl)}" class="inline-flex justify-center items-center !text-${c}-600 !dark:text-${c}-50 text-sm underline font-semibold transition duration-200 ease-in-out" target="${this._esc(this._linkTarget)}">${this._esc(this._linkTitle)}</a></div>`;
      }

      const tmp = document.createElement('div');
      tmp.innerHTML =
`<div class="bg-${c}-50 border-2 border-solid border-${c}-700 mt-6 mb-8 dark:bg-${c}-900 dark:border-${c}-500 x-rounded-lg overflow-hidden">
  <button type="button" data-callout-btn aria-expanded="${this._expanded}" class="w-full flex justify-between items-center gap-1.5 shrink-0 px-4 py-2.5 border-b-2 border-${c}-700 bg-${c}-700 dark:bg-${c}-500 dark:border-${c}-500 text-left focus:outline-none">
    <span class="flex items-center gap-1.5 min-w-0">
      <span class="w-4 h-auto shrink-0 inline-flex justify-center items-center text-white">${iconSvg}</span>
      <span class="text-sm font-semibold m-0 text-white truncate">${this._esc(this._title)}</span>
    </span>
    <span data-callout-chevron-down class="shrink-0 w-4 h-4 inline-flex justify-center items-center text-white" style="display:${this._expanded ? 'none' : 'inline-flex'}">${downSvg}</span>
    <span data-callout-chevron-up class="shrink-0 w-4 h-4 inline-flex justify-center items-center text-white" style="display:${this._expanded ? 'inline-flex' : 'none'}">${upSvg}</span>
  </button>
  <div data-callout-body class="px-4 py-2" style="display:${this._expanded ? 'block' : 'none'}">
    <div data-callout-prose x-prose-color.${c}>
    </div>
    ${linkHtml}
  </div>
</div>`;

      this.textContent = '';
      while (tmp.firstChild) this.appendChild(tmp.firstChild);

      const proseDiv = this.querySelector('[data-callout-prose]');
      for (const child of contentNodes) proseDiv.appendChild(child);

      this.querySelector('[data-callout-btn]').addEventListener('click', () => this._toggle());

      if (typeof Alpine !== 'undefined') {
        Alpine.initTree(proseDiv);
      }
    }

    _icon(name) {
      return typeof WP_ICONS !== 'undefined' && WP_ICONS[name] ? WP_ICONS[name] : '';
    }

    _esc(s) {
      const el = document.createElement('div');
      el.textContent = s;
      return el.innerHTML;
    }
  }

  if (!customElements.get('wp-callout')) {
    customElements.define('wp-callout', WpCallout);
  }
})();
