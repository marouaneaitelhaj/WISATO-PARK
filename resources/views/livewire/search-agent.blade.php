<div>
    <div class=" form-group">
        @if (session()->has('flash_message'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '{{ session('
                flash_message.type ') }}',
                text: '{{ session('
                flash_message.message ') }}'
            });
        </script>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.addEventListener('show-sweet-alert', event => {
                Swal.fire({
                    icon: event.detail.type,
                    text: event.detail.message
                });
            });
        </script>
        <label for="operator">Agent</label>
        <select wire:model="selectedAgent" name="agent_id[]" id="operator" multiple>
            @foreach ($agents as $agent)
            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
        @error('agent_id') <span class="text-danger">{{ $message }}</span> @enderror



    </div>

    <script>
        function MultiSelectTag(e, t = {
            shadow: !1,
            rounded: !0
        }) {
            var n = null,
                d = null,
                l = null,
                a = null,
                s = null,
                i = null,
                o = null,
                c = null,
                r = null,
                u = null,
                p = null,
                v = null,
                m = new DOMParser;

            function h(e = null) {
                for (var t of (v.innerHTML = "", d))
                    if (t.selected) !w(t.value) && f(t);
                    else {
                        const n = document.createElement("li");
                        n.innerHTML = t.label, n.dataset.value = t.value, e && t.label.toLowerCase().startsWith(e.toLowerCase()) ? v.appendChild(n) : e || v.appendChild(n)
                    }
            }

            function f(e) {
                const t = document.createElement("div");
                t.classList.add("item-container");
                const n = document.createElement("div");
                n.classList.add("item-label"), n.innerHTML = e.label, n.dataset.value = e.value;
                const l = (new DOMParser).parseFromString('<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="item-close-svg">\n                <line x1="18" y1="6" x2="6" y2="18"></line>\n                <line x1="6" y1="6" x2="18" y2="18"></line>\n                </svg>', "image/svg+xml").documentElement;
                l.addEventListener("click", (t => {
                    d.find((t => t.value == e.value)).selected = !1, g(e.value), h(), E()
                })), t.appendChild(n), t.appendChild(l), o.append(t)
            }

            function L() {
                for (var e of v.children) e.addEventListener("click", (e => {
                    d.find((t => t.value == e.target.dataset.value)).selected = !0, r.value = null, h(), E(), r.focus()
                }))
            }

            function w(e) {
                for (var t of o.children)
                    if (!t.classList.contains("input-body") && t.firstChild.dataset.value == e) return !0;
                return !1
            }

            function g(e) {
                for (var t of o.children) t.classList.contains("input-body") || t.firstChild.dataset.value != e || o.removeChild(t)
            }

            function E() {
                for (var e = 0; e < d.length; e++) n.options[e].selected = d[e].selected
            }
            n = document.getElementById(e),
                function() {
                    d = [...n.options].map((e => ({
                        value: e.value,
                        label: e.label,
                        selected: e.selected
                    }))), n.classList.add("hidden"), (l = document.createElement("div")).classList.add("mult-select-tag"), (a = document.createElement("div")).classList.add("wrapper"), (i = document.createElement("div")).classList.add("body"), t.shadow && i.classList.add("shadow"), t.rounded && i.classList.add("rounded"), (o = document.createElement("div")).classList.add("input-container"), (r = document.createElement("input")).classList.add("input"), r.placeholder = `${t.placeholder||"Search..."}`, (c = document.createElement("inputBody")).classList.add("input-body"), c.append(r), i.append(o), (s = document.createElement("div")).classList.add("btn-container"), (u = document.createElement("button")).type = "button", s.append(u);
                    const e = m.parseFromString('<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">\n            <polyline points="18 15 12 21 6 15"></polyline></svg>', "image/svg+xml").documentElement;
                    u.append(e), i.append(s), a.append(i), (p = document.createElement("div")).classList.add("drawer", "hidden"), t.shadow && p.classList.add("shadow"), t.rounded && p.classList.add("rounded"), p.append(c), v = document.createElement("ul"), p.appendChild(v), l.appendChild(a), l.appendChild(p), n.nextSibling ? n.parentNode.insertBefore(l, n.nextSibling) : n.parentNode.appendChild(l)
                }(), h(), L(), E(), u.addEventListener("click", (() => {
                    p.classList.contains("hidden") && (h(), L(), p.classList.remove("hidden"), r.focus())
                })),
                document.querySelector("body > div > div > div > div > div > div > div > div > div.card-body > form > div > div.col-md-12.w-100 > div > div > div > div.wrapper > div > div.input-container").addEventListener("click", (() => {
                    p.classList.contains("hidden") && (h(), L(), p.classList.remove("hidden"), r.focus())   
                })),
                 r.addEventListener("keyup", (e => {
                    h(e.target.value), L()
                })), r.addEventListener("keydown", (e => {
                    if ("Backspace" === e.key && !e.target.value && o.childElementCount > 1) {
                        const e = i.children[o.childElementCount - 2].firstChild;
                        d.find((t => t.value == e.dataset.value)).selected = !1, g(e.dataset.value), E()
                    }
                })), window.addEventListener("click", (e => {
                    l.contains(e.target) || p.classList.add("hidden")
                }))
        }
    </script>
    <script>
        new MultiSelectTag('operator'); // id
    </script>

</div>