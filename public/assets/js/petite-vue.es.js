var tt = Object.defineProperty;
var nt = (e, t, n) => t in e ? tt(e, t, { enumerable: !0, configurable: !0, writable: !0, value: n }) : e[t] = n;
var $ = (e, t, n) => (nt(e, typeof t != "symbol" ? t + "" : t, n), n);

function st(e, t) { const n = Object.create(null),
        s = e.split(","); for (let r = 0; r < s.length; r++) n[s[r]] = !0; return t ? r => !!n[r.toLowerCase()] : r => !!n[r]; }

function de(e) { if (y(e)) { const t = {}; for (let n = 0; n < e.length; n++) { const s = e[n],
                r = N(s) ? it(s) : de(s); if (r)
                for (const i in r) t[i] = r[i]; } return t; } else { if (N(e)) return e; if (S(e)) return e; } }
const rt = /;(?![^(]*\))/g,
    ot = /:(.+)/;

function it(e) { const t = {}; return e.split(rt).forEach(n => { if (n) { const s = n.split(ot);
            s.length > 1 && (t[s[0].trim()] = s[1].trim()); } }), t; }

function me(e) { let t = ""; if (N(e)) t = e;
    else if (y(e))
        for (let n = 0; n < e.length; n++) { const s = me(e[n]);
            s && (t += s + " "); } else if (S(e))
            for (const n in e) e[n] && (t += n + " ");
    return t.trim(); }

function ct(e, t) { if (e.length !== t.length) return !1; let n = !0; for (let s = 0; n && s < e.length; s++) n = I(e[s], t[s]); return n; }

function I(e, t) { if (e === t) return !0; let n = ge(e),
        s = ge(t); if (n || s) return n && s ? e.getTime() === t.getTime() : !1; if (n = y(e), s = y(t), n || s) return n && s ? ct(e, t) : !1; if (n = S(e), s = S(t), n || s) { if (!n || !s) return !1; const r = Object.keys(e).length,
            i = Object.keys(t).length; if (r !== i) return !1; for (const c in e) { const o = e.hasOwnProperty(c),
                l = t.hasOwnProperty(c); if (o && !l || !o && l || !I(e[c], t[c])) return !1; } } return String(e) === String(t); }

function G(e, t) { return e.findIndex(n => I(n, t)); }
const lt = Object.assign,
    ft = (e, t) => { const n = e.indexOf(t);
        n > -1 && e.splice(n, 1); },
    at = Object.prototype.hasOwnProperty,
    U = (e, t) => at.call(e, t),
    y = Array.isArray,
    Y = e => ye(e) === "[object Map]",
    ge = e => e instanceof Date,
    N = e => typeof e == "string",
    Q = e => typeof e == "symbol",
    S = e => e !== null && typeof e == "object",
    ut = Object.prototype.toString,
    ye = e => ut.call(e),
    pt = e => ye(e).slice(8, -1),
    X = e => N(e) && e !== "NaN" && e[0] !== "-" && "" + parseInt(e, 10) === e,
    be = e => { const t = Object.create(null); return n => t[n] || (t[n] = e(n)); },
    ht = /-(\w)/g,
    dt = be(e => e.replace(ht, (t, n) => n ? n.toUpperCase() : "")),
    mt = /\B([A-Z])/g,
    xe = be(e => e.replace(mt, "-$1").toLowerCase()),
    gt = (e, t) => !Object.is(e, t),
    ve = e => { const t = parseFloat(e); return isNaN(t) ? e : t; };
let yt;

function we(e, t) { t = t || yt, t && t.active && t.effects.push(e); }
const _e = e => { const t = new Set(e); return t.w = 0, t.n = 0, t; },
    Ee = e => (e.w & O) > 0,
    $e = e => (e.n & O) > 0,
    bt = ({ deps: e }) => { if (e.length)
            for (let t = 0; t < e.length; t++) e[t].w |= O; },
    xt = e => { const { deps: t } = e; if (t.length) { let n = 0; for (let s = 0; s < t.length; s++) { const r = t[s];
                Ee(r) && !$e(r) ? r.delete(e) : t[n++] = r, r.w &= ~O, r.n &= ~O; }
            t.length = n; } },
    ee = new WeakMap();
let B = 0,
    O = 1;
const te = 30,
    z = [];
let C;
const W = Symbol(""),
    Se = Symbol("");
class vt { constructor(t, n = null, s) { this.fn = t, this.scheduler = n, this.active = !0, this.deps = [], we(this, s); }
    run() { if (!this.active) return this.fn(); if (!z.includes(this)) try { return z.push(C = this), $t(), O = 1 << ++B, B <= te ? bt(this) : Oe(this), this.fn(); } finally { B <= te && xt(this), O = 1 << --B, ke(), z.pop(); const t = z.length;
            C = t > 0 ? z[t - 1] : void 0; } }
    stop() { this.active && (Oe(this), this.onStop && this.onStop(), this.active = !1); } }

function Oe(e) { const { deps: t } = e; if (t.length) { for (let n = 0; n < t.length; n++) t[n].delete(e);
        t.length = 0; } }

function wt(e, t) { e.effect && (e = e.effect.fn); const n = new vt(e);
    t && (lt(n, t), t.scope && we(n, t.scope)), (!t || !t.lazy) && n.run(); const s = n.run.bind(n); return s.effect = n, s; }

function _t(e) { e.effect.stop(); }
let K = !0;
const ne = [];

function Et() { ne.push(K), K = !1; }

function $t() { ne.push(K), K = !0; }

function ke() { const e = ne.pop();
    K = e === void 0 ? !0 : e; }

function F(e, t, n) { if (!St()) return; let s = ee.get(e);
    s || ee.set(e, s = new Map()); let r = s.get(n);
    r || s.set(n, r = _e()), Ot(r); }

function St() { return K && C !== void 0; }

function Ot(e, t) { let n = !1;
    B <= te ? $e(e) || (e.n |= O, n = !Ee(e)) : n = !e.has(C), n && (e.add(C), C.deps.push(e)); }

function se(e, t, n, s, r, i) { const c = ee.get(e); if (!c) return; let o = []; if (t === "clear") o = [...c.values()];
    else if (n === "length" && y(e)) c.forEach((l, f) => {
        (f === "length" || f >= s) && o.push(l); });
    else switch (n !== void 0 && o.push(c.get(n)), t) {
        case "add":
            y(e) ? X(n) && o.push(c.get("length")) : (o.push(c.get(W)), Y(e) && o.push(c.get(Se))); break;
        case "delete":
            y(e) || (o.push(c.get(W)), Y(e) && o.push(c.get(Se))); break;
        case "set":
            Y(e) && o.push(c.get(W)); break; }
    if (o.length === 1) o[0] && Te(o[0]);
    else { const l = []; for (const f of o) f && l.push(...f);
        Te(_e(l)); } }

function Te(e, t) { for (const n of y(e) ? e : [...e])(n !== C || n.allowRecurse) && (n.scheduler ? n.scheduler() : n.run()); }
const kt = st("__proto__,__v_isRef,__isVue"),
    Ae = new Set(Object.getOwnPropertyNames(Symbol).map(e => Symbol[e]).filter(Q)),
    Tt = Me(),
    At = Me(!0),
    Re = Rt();

function Rt() { const e = {}; return ["includes", "indexOf", "lastIndexOf"].forEach(t => { e[t] = function(...n) { const s = j(this); for (let i = 0, c = this.length; i < c; i++) F(s, "get", i + ""); const r = s[t](...n); return r === -1 || r === !1 ? s[t](...n.map(j)) : r; }; }), ["push", "pop", "shift", "unshift", "splice"].forEach(t => { e[t] = function(...n) { Et(); const s = j(this)[t].apply(this, n); return ke(), s; }; }), e; }

function Me(e = !1, t = !1) { return function(s, r, i) { if (r === "__v_isReactive") return !e; if (r === "__v_isReadonly") return e; if (r === "__v_raw" && i === (e ? t ? zt : je : t ? Bt : Ce).get(s)) return s; const c = y(s); if (!e && c && U(Re, r)) return Reflect.get(Re, r, i); const o = Reflect.get(s, r, i); return (Q(r) ? Ae.has(r) : kt(r)) || (e || F(s, "get", r), t) ? o : re(o) ? !c || !X(r) ? o.value : o : S(o) ? e ? Ht(o) : D(o) : o; }; }
const Mt = Ct();

function Ct(e = !1) { return function(n, s, r, i) { let c = n[s]; if (!e && !Lt(r) && (r = j(r), c = j(c), !y(n) && re(c) && !re(r))) return c.value = r, !0; const o = y(n) && X(s) ? Number(s) < n.length : U(n, s),
            l = Reflect.set(n, s, r, i); return n === j(i) && (o ? gt(r, c) && se(n, "set", s, r) : se(n, "add", s, r)), l; }; }

function jt(e, t) { const n = U(e, t);
    e[t]; const s = Reflect.deleteProperty(e, t); return s && n && se(e, "delete", t, void 0), s; }

function Pt(e, t) { const n = Reflect.has(e, t); return (!Q(t) || !Ae.has(t)) && F(e, "has", t), n; }

function It(e) { return F(e, "iterate", y(e) ? "length" : W), Reflect.ownKeys(e); }
const Nt = { get: Tt, set: Mt, deleteProperty: jt, has: Pt, ownKeys: It },
    Kt = { get: At, set(e, t) { return !0; }, deleteProperty(e, t) { return !0; } },
    Ce = new WeakMap(),
    Bt = new WeakMap(),
    je = new WeakMap(),
    zt = new WeakMap();

function Dt(e) { switch (e) {
        case "Object":
        case "Array":
            return 1;
        case "Map":
        case "Set":
        case "WeakMap":
        case "WeakSet":
            return 2;
        default:
            return 0; } }

function Vt(e) { return e.__v_skip || !Object.isExtensible(e) ? 0 : Dt(pt(e)); }

function D(e) { return e && e.__v_isReadonly ? e : Pe(e, !1, Nt, null, Ce); }

function Ht(e) { return Pe(e, !0, Kt, null, je); }

function Pe(e, t, n, s, r) { if (!S(e) || e.__v_raw && !(t && e.__v_isReactive)) return e; const i = r.get(e); if (i) return i; const c = Vt(e); if (c === 0) return e; const o = new Proxy(e, c === 2 ? s : n); return r.set(e, o), o; }

function Lt(e) { return !!(e && e.__v_isReadonly); }

function j(e) { const t = e && e.__v_raw; return t ? j(t) : e; }

function re(e) { return Boolean(e && e.__v_isRef === !0); }
Promise.resolve();
let oe = !1;
const q = [],
    Wt = Promise.resolve(),
    V = e => Wt.then(e),
    Ie = e => { q.includes(e) || q.push(e), oe || (oe = !0, V(Ft)); },
    Ft = () => { for (const e of q) e();
        q.length = 0, oe = !1; },
    qt = /^(spellcheck|draggable|form|list|type)$/,
    ie = ({ el: e, get: t, effect: n, arg: s, modifiers: r }) => { let i;
        s === "class" && (e._class = e.className), n(() => { let c = t(); if (s)(r == null ? void 0 : r.camel) && (s = dt(s)), ce(e, s, c, i);
            else { for (const o in c) ce(e, o, c[o], i && i[o]); for (const o in i)(!c || !(o in c)) && ce(e, o, null); }
            i = c; }); },
    ce = (e, t, n, s) => { if (t === "class") e.setAttribute("class", me(e._class ? [e._class, n] : n) || "");
        else if (t === "style") { n = de(n); const { style: r } = e; if (!n) e.removeAttribute("style");
            else if (N(n)) n !== s && (r.cssText = n);
            else { for (const i in n) le(r, i, n[i]); if (s && !N(s))
                    for (const i in s) n[i] == null && le(r, i, ""); } } else !(e instanceof SVGElement) && t in e && !qt.test(t) ? (e[t] = n, t === "value" && (e._value = n)) : t === "true-value" ? e._trueValue = n : t === "false-value" ? e._falseValue = n : n != null ? e.setAttribute(t, n) : e.removeAttribute(t); },
    Ne = /\s*!important$/,
    le = (e, t, n) => { y(n) ? n.forEach(s => le(e, t, s)) : t.startsWith("--") ? e.setProperty(t, n) : Ne.test(n) ? e.setProperty(xe(t), n.replace(Ne, ""), "important") : e[t] = n; },
    k = (e, t) => { const n = e.getAttribute(t); return n != null && e.removeAttribute(t), n; },
    T = (e, t, n, s) => { e.addEventListener(t, n, s); },
    Jt = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/,
    Zt = ["ctrl", "shift", "alt", "meta"],
    Gt = { stop: e => e.stopPropagation(), prevent: e => e.preventDefault(), self: e => e.target !== e.currentTarget, ctrl: e => !e.ctrlKey, shift: e => !e.shiftKey, alt: e => !e.altKey, meta: e => !e.metaKey, left: e => "button" in e && e.button !== 0, middle: e => "button" in e && e.button !== 1, right: e => "button" in e && e.button !== 2, exact: (e, t) => Zt.some(n => e[`${n}Key`] && !t[n]) },
    Ke = ({ el: e, get: t, exp: n, arg: s, modifiers: r }) => { if (!s) return; let i = Jt.test(n) ? t(`(e => ${n}(e))`) : t(`($event => { ${n} })`); if (s === "vue:mounted") { V(i); return; } else if (s === "vue:unmounted") return () => i(); if (r) { s === "click" && (r.right && (s = "contextmenu"), r.middle && (s = "mouseup")); const c = i;
            i = o => { if (!("key" in o && !(xe(o.key) in r))) { for (const l in r) { const f = Gt[l]; if (f && f(o, r)) return; } return c(o); } }; }
        T(e, s, i, r); },
    Ut = ({ el: e, get: t, effect: n }) => { const s = e.style.display;
        n(() => { e.style.display = t() ? s : "none"; }); },
    Be = ({ el: e, get: t, effect: n }) => { n(() => { e.textContent = ze(t()); }); },
    ze = e => e == null ? "" : S(e) ? JSON.stringify(e, null, 2) : String(e),
    Yt = ({ el: e, get: t, effect: n }) => { n(() => { e.innerHTML = t(); }); },
    Qt = ({ el: e, exp: t, get: n, effect: s, modifiers: r }) => { const i = e.type,
            c = n(`(val) => { ${t} = val }`),
            { trim: o, number: l = i === "number" } = r || {}; if (e.tagName === "SELECT") { const f = e;
            T(e, "change", () => { const a = Array.prototype.filter.call(f.options, u => u.selected).map(u => l ? ve(A(u)) : A(u));
                c(f.multiple ? a : a[0]); }), s(() => { const a = n(),
                    u = f.multiple; for (let p = 0, x = f.options.length; p < x; p++) { const b = f.options[p],
                        v = A(b); if (u) y(a) ? b.selected = G(a, v) > -1 : b.selected = a.has(v);
                    else if (I(A(b), a)) { f.selectedIndex !== p && (f.selectedIndex = p); return; } }!u && f.selectedIndex !== -1 && (f.selectedIndex = -1); }); } else if (i === "checkbox") { T(e, "change", () => { const a = n(),
                    u = e.checked; if (y(a)) { const p = A(e),
                        x = G(a, p),
                        b = x !== -1; if (u && !b) c(a.concat(p));
                    else if (!u && b) { const v = [...a];
                        v.splice(x, 1), c(v); } } else c(De(e, u)); }); let f;
            s(() => { const a = n();
                y(a) ? e.checked = G(a, A(e)) > -1 : a !== f && (e.checked = I(a, De(e, !0))), f = a; }); } else if (i === "radio") { T(e, "change", () => { c(A(e)); }); let f;
            s(() => { const a = n();
                a !== f && (e.checked = I(a, A(e))); }); } else { const f = a => o ? a.trim() : l ? ve(a) : a;
            T(e, "compositionstart", Xt), T(e, "compositionend", en), T(e, (r == null ? void 0 : r.lazy) ? "change" : "input", () => { e.composing || c(f(e.value)); }), o && T(e, "change", () => { e.value = e.value.trim(); }), s(() => { if (e.composing) return; const a = e.value,
                    u = n();
                document.activeElement === e && f(a) === u || a !== u && (e.value = u); }); } },
    A = e => "_value" in e ? e._value : e.value,
    De = (e, t) => { const n = t ? "_trueValue" : "_falseValue"; return n in e ? e[n] : t; },
    Xt = e => { e.target.composing = !0; },
    en = e => { const t = e.target;
        t.composing && (t.composing = !1, tn(t, "input")); },
    tn = (e, t) => { const n = document.createEvent("HTMLEvents");
        n.initEvent(t, !0, !0), e.dispatchEvent(n); },
    Ve = Object.create(null),
    H = (e, t, n) => He(e, `return(${t})`, n),
    He = (e, t, n) => { const s = Ve[t] || (Ve[t] = nn(t)); try { return s(e, n); } catch (r) { console.error(r); } },
    nn = e => { try { return new Function("$data", "$el", `with($data){${e}}`); } catch (t) { return console.error(`${t.message} in expression: ${e}`), () => {}; } },
    sn = ({ el: e, ctx: t, exp: n, effect: s }) => { V(() => s(() => He(t.scope, n, e))); },
    rn = { bind: ie, on: Ke, show: Ut, text: Be, html: Yt, model: Qt, effect: sn },
    on = (e, t, n) => { const s = e.parentElement,
            r = new Comment("v-if");
        s.insertBefore(r, e); const i = [{ exp: t, el: e }]; let c, o; for (;
            (c = e.nextElementSibling) && (o = null, k(c, "v-else") === "" || (o = k(c, "v-else-if")));) s.removeChild(c), i.push({ exp: o, el: c }); const l = e.nextSibling;
        s.removeChild(e); let f, a = -1; const u = () => { f && (s.insertBefore(r, f.el), f.remove(), f = void 0); }; return n.effect(() => { for (let p = 0; p < i.length; p++) { const { exp: x, el: b } = i[p]; if (!x || H(n.scope, x)) { p !== a && (u(), f = new ue(b, n), f.insert(s, r), s.removeChild(r), a = p); return; } }
            a = -1, u(); }), l; },
    cn = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,
    Le = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/,
    ln = /^\(|\)$/g,
    fn = /^[{[]\s*((?:[\w_$]+\s*,?\s*)+)[\]}]$/,
    an = (e, t, n) => { const s = t.match(cn); if (!s) return; const r = e.nextSibling,
            i = e.parentElement,
            c = new Text("");
        i.insertBefore(c, e), i.removeChild(e); const o = s[2].trim(); let l = s[1].trim().replace(ln, "").trim(),
            f, a = !1,
            u, p, x = "key",
            b = e.getAttribute(x) || e.getAttribute(x = ":key") || e.getAttribute(x = "v-bind:key");
        b && (e.removeAttribute(x), x === "key" && (b = JSON.stringify(b))); let v;
        (v = l.match(Le)) && (l = l.replace(Le, "").trim(), u = v[1].trim(), v[2] && (p = v[2].trim())), (v = l.match(fn)) && (f = v[1].split(",").map(m => m.trim()), a = l[0] === "["); let pe = !1,
            R, L, J; const et = m => { const w = new Map(),
                    h = []; if (y(m))
                    for (let d = 0; d < m.length; d++) h.push(Z(w, m[d], d));
                else if (typeof m == "number")
                    for (let d = 0; d < m; d++) h.push(Z(w, d + 1, d));
                else if (S(m)) { let d = 0; for (const g in m) h.push(Z(w, m[g], d++, g)); } return [h, w]; },
            Z = (m, w, h, d) => { const g = {};
                f ? f.forEach((M, E) => g[M] = w[a ? E : M]) : g[l] = w, d ? (u && (g[u] = d), p && (g[p] = h)) : u && (g[u] = h); const P = Ge(n, g),
                    _ = b ? H(P.scope, b) : h; return m.set(_, h), P.key = _, P; },
            he = (m, w) => { const h = new ue(e, m); return h.key = m.key, h.insert(i, w), h; }; return n.effect(() => { const m = H(n.scope, o),
                w = J; if ([L, J] = et(m), !pe) R = L.map(h => he(h, c)), pe = !0;
            else { for (let _ = 0; _ < R.length; _++) J.has(R[_].key) || R[_].remove(); const h = []; let d = L.length,
                    g, P; for (; d--;) { const _ = L[d],
                        M = w.get(_.key); let E;
                    M == null ? E = he(_, g ? g.el : c) : (E = R[M], Object.assign(E.ctx.scope, _.scope), M !== d && (R[M + 1] !== g || P === g) && (P = E, E.insert(i, g ? g.el : c))), h.unshift(g = E); }
                R = h; } }), r; },
    We = ({ el: e, ctx: { scope: { $refs: t } }, get: n, effect: s }) => { let r; return s(() => { const i = n();
            t[i] = e, r && i !== r && delete t[r], r = i; }), () => { r && delete t[r]; }; },
    un = /^(?:v-|:|@)/,
    pn = /\.([\w-]+)/g;
let fe = !1;
const Fe = (e, t) => { const n = e.nodeType; if (n === 1) { const s = e; if (s.hasAttribute("v-pre")) return;
            k(s, "v-cloak"); let r; if (r = k(s, "v-if")) return on(s, r, t); if (r = k(s, "v-for")) return an(s, r, t); if ((r = k(s, "v-scope")) || r === "") { const o = r ? H(t.scope, r) : {};
                t = Ge(t, o), o.$template && hn(s, o.$template); } const i = k(s, "v-once") != null;
            i && (fe = !0), (r = k(s, "ref")) && ae(s, We, `"${r}"`, t), qe(s, t); const c = []; for (const { name: o, value: l }
                of[...s.attributes]) un.test(o) && o !== "v-cloak" && (o === "v-model" ? c.unshift([o, l]) : o[0] === "@" || /^v-on\b/.test(o) ? c.push([o, l]) : Je(s, o, l, t)); for (const [o, l] of c) Je(s, o, l, t);
            i && (fe = !1); } else if (n === 3) { const s = e.data; if (s.includes(t.delimiters[0])) { let r = [],
                    i = 0,
                    c; for (; c = t.delimitersRE.exec(s);) { const o = s.slice(i, c.index);
                    o && r.push(JSON.stringify(o)), r.push(`$s(${c[1]})`), i = c.index + c[0].length; }
                i < s.length && r.push(JSON.stringify(s.slice(i))), ae(e, Be, r.join("+"), t); } } else n === 11 && qe(e, t); },
    qe = (e, t) => { let n = e.firstChild; for (; n;) n = Fe(n, t) || n.nextSibling; },
    Je = (e, t, n, s) => { let r, i, c; if (t = t.replace(pn, (o, l) => ((c || (c = {}))[l] = !0, "")), t[0] === ":") r = ie, i = t.slice(1);
        else if (t[0] === "@") r = Ke, i = t.slice(1);
        else { const o = t.indexOf(":"),
                l = o > 0 ? t.slice(2, o) : t.slice(2);
            r = rn[l] || s.dirs[l], i = o > 0 ? t.slice(o + 1) : void 0; }
        r && (r === ie && i === "ref" && (r = We), ae(e, r, n, s, i, c), e.removeAttribute(t)); },
    ae = (e, t, n, s, r, i) => { const c = t({ el: e, get: (o = n) => H(s.scope, o, e), effect: s.effect, ctx: s, exp: n, arg: r, modifiers: i });
        c && s.cleanups.push(c); },
    hn = (e, t) => { if (t[0] === "#") { const n = document.querySelector(t);
            e.appendChild(n.content.cloneNode(!0)); return; }
        e.innerHTML = t; },
    Ze = e => { const t = { delimiters: ["{{", "}}"], delimitersRE: /\{\{([^]+?)\}\}/g, ...e, scope: e ? e.scope : D({}), dirs: e ? e.dirs : {}, effects: [], blocks: [], cleanups: [], effect: n => { if (fe) return Ie(n), n; const s = wt(n, { scheduler: () => Ie(s) }); return t.effects.push(s), s; } }; return t; },
    Ge = (e, t = {}) => { const n = e.scope,
            s = Object.create(n);
        Object.defineProperties(s, Object.getOwnPropertyDescriptors(t)), s.$refs = Object.create(n.$refs); const r = D(new Proxy(s, {set(i, c, o, l) { return l === r && !i.hasOwnProperty(c) ? Reflect.set(n, c, o) : Reflect.set(i, c, o, l); } })); return Ue(r), {...e, scope: r }; },
    Ue = e => { for (const t of Object.keys(e)) typeof e[t] == "function" && (e[t] = e[t].bind(e)); };
class ue { constructor(t, n, s = !1) { $(this, "template");
        $(this, "ctx");
        $(this, "key");
        $(this, "parentCtx");
        $(this, "isFragment");
        $(this, "start");
        $(this, "end");
        this.isFragment = t instanceof HTMLTemplateElement, s ? this.template = t : this.isFragment ? this.template = t.content.cloneNode(!0) : this.template = t.cloneNode(!0), s ? this.ctx = n : (this.parentCtx = n, n.blocks.push(this), this.ctx = Ze(n)), Fe(this.template, this.ctx); }
    get el() { return this.start || this.template; }
    insert(t, n = null) { if (this.isFragment) { if (this.start) { let s = this.start,
                    r; for (; s && (r = s.nextSibling, t.insertBefore(s, n), s !== this.end);) s = r; } else this.start = new Text(""), this.end = new Text(""), t.insertBefore(this.end, n), t.insertBefore(this.start, this.end), t.insertBefore(this.template, this.end); } else t.insertBefore(this.template, n); }
    remove() { if (this.parentCtx && ft(this.parentCtx.blocks, this), this.start) { const t = this.start.parentNode; let n = this.start,
                s; for (; n && (s = n.nextSibling, t.removeChild(n), n !== this.end);) n = s; } else this.template.parentNode.removeChild(this.template);
        this.teardown(); }
    teardown() { this.ctx.blocks.forEach(t => { t.teardown(); }), this.ctx.effects.forEach(_t), this.ctx.cleanups.forEach(t => t()); } }
const Ye = e => e.replace(/[-.*+?^${}()|[\]\/\\]/g, "\\$&"),
    Qe = e => { const t = Ze(); if (e && (t.scope = D(e), Ue(t.scope), e.$delimiters)) { const [s, r] = t.delimiters = e.$delimiters;
            t.delimitersRE = new RegExp(Ye(s) + "([^]+?)" + Ye(r), "g"); }
        t.scope.$s = ze, t.scope.$nextTick = V, t.scope.$refs = Object.create(null); let n; return { directive(s, r) { return r ? (t.dirs[s] = r, this) : t.dirs[s]; }, mount(s) { if (typeof s == "string" && (s = document.querySelector(s), !s)) return;
                s = s || document.documentElement; let r; return s.hasAttribute("v-scope") ? r = [s] : r = [...s.querySelectorAll("[v-scope]")].filter(i => !i.matches("[v-scope] [v-scope]")), r.length || (r = [s]), n = r.map(i => new ue(i, t, !0)), this; }, unmount() { n.forEach(s => s.teardown()); } }; },
    Xe = document.currentScript;
Xe && Xe.hasAttribute("init") && Qe().mount();
export { Qe as createApp, V as nextTick, D as reactive };