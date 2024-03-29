(() => {
    var Ps = Object.create;
    var te = Object.defineProperty;
    var Os = Object.getOwnPropertyDescriptor;
    var Fs = Object.getOwnPropertyNames;
    var Is = Object.getPrototypeOf,
        Ds = Object.prototype.hasOwnProperty;
    var Bs = (i, e, t) =>
        e in i
            ? te(i, e, {
                  enumerable: !0,
                  configurable: !0,
                  writable: !0,
                  value: t,
              })
            : (i[e] = t);
    var qs = (i) => te(i, "__esModule", { value: !0 });
    var D = (i, e) => () => (i && (e = i((i = 0))), e);
    var Xe = (i, e) => () => (
            e || i((e = { exports: {} }).exports, e), e.exports
        ),
        Ns = (i, e) => {
            for (var t in e) te(i, t, { get: e[t], enumerable: !0 });
        },
        Hs = (i, e, t, s) => {
            if ((e && typeof e == "object") || typeof e == "function")
                for (let r of Fs(e))
                    !Ds.call(i, r) &&
                        (t || r !== "default") &&
                        te(i, r, {
                            get: () => e[r],
                            enumerable: !(s = Os(e, r)) || s.enumerable,
                        });
            return i;
        },
        It = (i, e) =>
            Hs(
                qs(
                    te(
                        i != null ? Ps(Is(i)) : {},
                        "default",
                        !e && i && i.__esModule
                            ? { get: () => i.default, enumerable: !0 }
                            : { value: i, enumerable: !0 }
                    )
                ),
                i
            );
    var T = (i, e, t) => (Bs(i, typeof e != "symbol" ? e + "" : e, t), t);
    var U,
        Ae = D(() => {
            U = { logger: self.console, WebSocket: self.WebSocket };
        });
    var A,
        ke = D(() => {
            Ae();
            A = {
                log(...i) {
                    this.enabled &&
                        (i.push(Date.now()),
                        U.logger.log("[ActionCable]", ...i));
                },
            };
        });
    var ne,
        at,
        Pr,
        Le,
        xe,
        ct = D(() => {
            ke();
            (ne = () => new Date().getTime()),
                (at = (i) => (ne() - i) / 1e3),
                (Pr = (i, e, t) => Math.max(e, Math.min(t, i))),
                (Le = class {
                    constructor(e) {
                        (this.visibilityDidChange =
                            this.visibilityDidChange.bind(this)),
                            (this.connection = e),
                            (this.reconnectAttempts = 0);
                    }
                    start() {
                        this.isRunning() ||
                            ((this.startedAt = ne()),
                            delete this.stoppedAt,
                            this.startPolling(),
                            addEventListener(
                                "visibilitychange",
                                this.visibilityDidChange
                            ),
                            A.log(
                                `ConnectionMonitor started. pollInterval = ${this.getPollInterval()} ms`
                            ));
                    }
                    stop() {
                        this.isRunning() &&
                            ((this.stoppedAt = ne()),
                            this.stopPolling(),
                            removeEventListener(
                                "visibilitychange",
                                this.visibilityDidChange
                            ),
                            A.log("ConnectionMonitor stopped"));
                    }
                    isRunning() {
                        return this.startedAt && !this.stoppedAt;
                    }
                    recordPing() {
                        this.pingedAt = ne();
                    }
                    recordConnect() {
                        (this.reconnectAttempts = 0),
                            this.recordPing(),
                            delete this.disconnectedAt,
                            A.log("ConnectionMonitor recorded connect");
                    }
                    recordDisconnect() {
                        (this.disconnectedAt = ne()),
                            A.log("ConnectionMonitor recorded disconnect");
                    }
                    startPolling() {
                        this.stopPolling(), this.poll();
                    }
                    stopPolling() {
                        clearTimeout(this.pollTimeout);
                    }
                    poll() {
                        this.pollTimeout = setTimeout(() => {
                            this.reconnectIfStale(), this.poll();
                        }, this.getPollInterval());
                    }
                    getPollInterval() {
                        let {
                                min: e,
                                max: t,
                                multiplier: s,
                            } = this.constructor.pollInterval,
                            r = s * Math.log(this.reconnectAttempts + 1);
                        return Math.round(Pr(r, e, t) * 1e3);
                    }
                    reconnectIfStale() {
                        this.connectionIsStale() &&
                            (A.log(
                                `ConnectionMonitor detected stale connection. reconnectAttempts = ${
                                    this.reconnectAttempts
                                }, pollInterval = ${this.getPollInterval()} ms, time disconnected = ${at(
                                    this.disconnectedAt
                                )} s, stale threshold = ${
                                    this.constructor.staleThreshold
                                } s`
                            ),
                            this.reconnectAttempts++,
                            this.disconnectedRecently()
                                ? A.log(
                                      "ConnectionMonitor skipping reopening recent disconnect"
                                  )
                                : (A.log("ConnectionMonitor reopening"),
                                  this.connection.reopen()));
                    }
                    connectionIsStale() {
                        return (
                            at(this.pingedAt ? this.pingedAt : this.startedAt) >
                            this.constructor.staleThreshold
                        );
                    }
                    disconnectedRecently() {
                        return (
                            this.disconnectedAt &&
                            at(this.disconnectedAt) <
                                this.constructor.staleThreshold
                        );
                    }
                    visibilityDidChange() {
                        document.visibilityState === "visible" &&
                            setTimeout(() => {
                                (this.connectionIsStale() ||
                                    !this.connection.isOpen()) &&
                                    (A.log(
                                        `ConnectionMonitor reopening stale connection on visibilitychange. visibilityState = ${document.visibilityState}`
                                    ),
                                    this.connection.reopen());
                            }, 200);
                    }
                });
            Le.pollInterval = { min: 3, max: 30, multiplier: 5 };
            Le.staleThreshold = 6;
            xe = Le;
        });
    var oe,
        lt = D(() => {
            oe = {
                message_types: {
                    welcome: "welcome",
                    disconnect: "disconnect",
                    ping: "ping",
                    confirmation: "confirm_subscription",
                    rejection: "reject_subscription",
                },
                disconnect_reasons: {
                    unauthorized: "unauthorized",
                    invalid_request: "invalid_request",
                    server_restart: "server_restart",
                },
                default_mount_path: "/cable",
                protocols: ["actioncable-v1-json", "actioncable-unsupported"],
            };
        });
    var ae,
        Re,
        Or,
        fi,
        Me,
        Pe,
        ht = D(() => {
            Ae();
            ct();
            lt();
            ke();
            ({ message_types: ae, protocols: Re } = oe),
                (Or = Re.slice(0, Re.length - 1)),
                (fi = [].indexOf),
                (Me = class {
                    constructor(e) {
                        (this.open = this.open.bind(this)),
                            (this.consumer = e),
                            (this.subscriptions = this.consumer.subscriptions),
                            (this.monitor = new xe(this)),
                            (this.disconnected = !0);
                    }
                    send(e) {
                        return this.isOpen()
                            ? (this.webSocket.send(JSON.stringify(e)), !0)
                            : !1;
                    }
                    open() {
                        return this.isActive()
                            ? (A.log(
                                  `Attempted to open WebSocket, but existing socket is ${this.getState()}`
                              ),
                              !1)
                            : (A.log(
                                  `Opening WebSocket, current state is ${this.getState()}, subprotocols: ${Re}`
                              ),
                              this.webSocket && this.uninstallEventHandlers(),
                              (this.webSocket = new U.WebSocket(
                                  this.consumer.url,
                                  Re
                              )),
                              this.installEventHandlers(),
                              this.monitor.start(),
                              !0);
                    }
                    close({ allowReconnect: e } = { allowReconnect: !0 }) {
                        if ((e || this.monitor.stop(), this.isActive()))
                            return this.webSocket.close();
                    }
                    reopen() {
                        if (
                            (A.log(
                                `Reopening WebSocket, current state is ${this.getState()}`
                            ),
                            this.isActive())
                        )
                            try {
                                return this.close();
                            } catch (e) {
                                A.log("Failed to reopen WebSocket", e);
                            } finally {
                                A.log(
                                    `Reopening WebSocket in ${this.constructor.reopenDelay}ms`
                                ),
                                    setTimeout(
                                        this.open,
                                        this.constructor.reopenDelay
                                    );
                            }
                        else return this.open();
                    }
                    getProtocol() {
                        if (this.webSocket) return this.webSocket.protocol;
                    }
                    isOpen() {
                        return this.isState("open");
                    }
                    isActive() {
                        return this.isState("open", "connecting");
                    }
                    isProtocolSupported() {
                        return fi.call(Or, this.getProtocol()) >= 0;
                    }
                    isState(...e) {
                        return fi.call(e, this.getState()) >= 0;
                    }
                    getState() {
                        if (this.webSocket) {
                            for (let e in U.WebSocket)
                                if (
                                    U.WebSocket[e] === this.webSocket.readyState
                                )
                                    return e.toLowerCase();
                        }
                        return null;
                    }
                    installEventHandlers() {
                        for (let e in this.events) {
                            let t = this.events[e].bind(this);
                            this.webSocket[`on${e}`] = t;
                        }
                    }
                    uninstallEventHandlers() {
                        for (let e in this.events)
                            this.webSocket[`on${e}`] = function () {};
                    }
                });
            Me.reopenDelay = 500;
            Me.prototype.events = {
                message(i) {
                    if (!this.isProtocolSupported()) return;
                    let {
                        identifier: e,
                        message: t,
                        reason: s,
                        reconnect: r,
                        type: o,
                    } = JSON.parse(i.data);
                    switch (o) {
                        case ae.welcome:
                            return (
                                this.monitor.recordConnect(),
                                this.subscriptions.reload()
                            );
                        case ae.disconnect:
                            return (
                                A.log(`Disconnecting. Reason: ${s}`),
                                this.close({ allowReconnect: r })
                            );
                        case ae.ping:
                            return this.monitor.recordPing();
                        case ae.confirmation:
                            return this.subscriptions.notify(e, "connected");
                        case ae.rejection:
                            return this.subscriptions.reject(e);
                        default:
                            return this.subscriptions.notify(e, "received", t);
                    }
                },
                open() {
                    if (
                        (A.log(
                            `WebSocket onopen event, using '${this.getProtocol()}' subprotocol`
                        ),
                        (this.disconnected = !1),
                        !this.isProtocolSupported())
                    )
                        return (
                            A.log(
                                "Protocol is unsupported. Stopping monitor and disconnecting."
                            ),
                            this.close({ allowReconnect: !1 })
                        );
                },
                close(i) {
                    if ((A.log("WebSocket onclose event"), !this.disconnected))
                        return (
                            (this.disconnected = !0),
                            this.monitor.recordDisconnect(),
                            this.subscriptions.notifyAll("disconnected", {
                                willAttemptReconnect: this.monitor.isRunning(),
                            })
                        );
                },
                error() {
                    A.log("WebSocket onerror event");
                },
            };
            Pe = Me;
        });
    var Fr,
        Y,
        ut = D(() => {
            (Fr = function (i, e) {
                if (e != null)
                    for (let t in e) {
                        let s = e[t];
                        i[t] = s;
                    }
                return i;
            }),
                (Y = class {
                    constructor(e, t = {}, s) {
                        (this.consumer = e),
                            (this.identifier = JSON.stringify(t)),
                            Fr(this, s);
                    }
                    perform(e, t = {}) {
                        return (t.action = e), this.send(t);
                    }
                    send(e) {
                        return this.consumer.send({
                            command: "message",
                            identifier: this.identifier,
                            data: JSON.stringify(e),
                        });
                    }
                    unsubscribe() {
                        return this.consumer.subscriptions.remove(this);
                    }
                });
        });
    var Z,
        dt = D(() => {
            ut();
            Z = class {
                constructor(e) {
                    (this.consumer = e), (this.subscriptions = []);
                }
                create(e, t) {
                    let s = e,
                        r = typeof s == "object" ? s : { channel: s },
                        o = new Y(this.consumer, r, t);
                    return this.add(o);
                }
                add(e) {
                    return (
                        this.subscriptions.push(e),
                        this.consumer.ensureActiveConnection(),
                        this.notify(e, "initialized"),
                        this.sendCommand(e, "subscribe"),
                        e
                    );
                }
                remove(e) {
                    return (
                        this.forget(e),
                        this.findAll(e.identifier).length ||
                            this.sendCommand(e, "unsubscribe"),
                        e
                    );
                }
                reject(e) {
                    return this.findAll(e).map(
                        (t) => (this.forget(t), this.notify(t, "rejected"), t)
                    );
                }
                forget(e) {
                    return (
                        (this.subscriptions = this.subscriptions.filter(
                            (t) => t !== e
                        )),
                        e
                    );
                }
                findAll(e) {
                    return this.subscriptions.filter((t) => t.identifier === e);
                }
                reload() {
                    return this.subscriptions.map((e) =>
                        this.sendCommand(e, "subscribe")
                    );
                }
                notifyAll(e, ...t) {
                    return this.subscriptions.map((s) =>
                        this.notify(s, e, ...t)
                    );
                }
                notify(e, t, ...s) {
                    let r;
                    return (
                        typeof e == "string"
                            ? (r = this.findAll(e))
                            : (r = [e]),
                        r.map((o) =>
                            typeof o[t] == "function" ? o[t](...s) : void 0
                        )
                    );
                }
                sendCommand(e, t) {
                    let { identifier: s } = e;
                    return this.consumer.send({ command: t, identifier: s });
                }
            };
        });
    function ft(i) {
        if ((typeof i == "function" && (i = i()), i && !/^wss?:/i.test(i))) {
            let e = document.createElement("a");
            return (
                (e.href = i),
                (e.href = e.href),
                (e.protocol = e.protocol.replace("http", "ws")),
                e.href
            );
        } else return i;
    }
    var ce,
        pi = D(() => {
            ht();
            dt();
            ce = class {
                constructor(e) {
                    (this._url = e),
                        (this.subscriptions = new Z(this)),
                        (this.connection = new Pe(this));
                }
                get url() {
                    return ft(this._url);
                }
                send(e) {
                    return this.connection.send(e);
                }
                connect() {
                    return this.connection.open();
                }
                disconnect() {
                    return this.connection.close({ allowReconnect: !1 });
                }
                ensureActiveConnection() {
                    if (!this.connection.isActive())
                        return this.connection.open();
                }
            };
        });
    var gi = {};
    Ns(gi, {
        Connection: () => Pe,
        ConnectionMonitor: () => xe,
        Consumer: () => ce,
        INTERNAL: () => oe,
        Subscription: () => Y,
        Subscriptions: () => Z,
        adapters: () => U,
        createConsumer: () => Ir,
        createWebSocketURL: () => ft,
        getConfig: () => mi,
        logger: () => A,
    });
    function Ir(i = mi("url") || oe.default_mount_path) {
        return new ce(i);
    }
    function mi(i) {
        let e = document.head.querySelector(`meta[name='action-cable-${i}']`);
        if (e) return e.getAttribute("content");
    }
    var bi = D(() => {
        ht();
        ct();
        pi();
        lt();
        ut();
        dt();
        Ae();
        ke();
    });
    var Ct = Xe((us, Ne) => {
        (function () {
            var i = this;
            (function () {
                (function () {
                    this.Rails = {
                        linkClickSelector:
                            "a[data-confirm], a[data-method], a[data-remote]:not([disabled]), a[data-disable-with], a[data-disable]",
                        buttonClickSelector: {
                            selector:
                                "button[data-remote]:not([form]), button[data-confirm]:not([form])",
                            exclude: "form button",
                        },
                        inputChangeSelector:
                            "select[data-remote], input[data-remote], textarea[data-remote]",
                        formSubmitSelector: "form:not([data-turbo=true])",
                        formInputClickSelector:
                            "form:not([data-turbo=true]) input[type=submit], form:not([data-turbo=true]) input[type=image], form:not([data-turbo=true]) button[type=submit], form:not([data-turbo=true]) button:not([type]), input[type=submit][form], input[type=image][form], button[type=submit][form], button[form]:not([type])",
                        formDisableSelector:
                            "input[data-disable-with]:enabled, button[data-disable-with]:enabled, textarea[data-disable-with]:enabled, input[data-disable]:enabled, button[data-disable]:enabled, textarea[data-disable]:enabled",
                        formEnableSelector:
                            "input[data-disable-with]:disabled, button[data-disable-with]:disabled, textarea[data-disable-with]:disabled, input[data-disable]:disabled, button[data-disable]:disabled, textarea[data-disable]:disabled",
                        fileInputSelector:
                            "input[name][type=file]:not([disabled])",
                        linkDisableSelector:
                            "a[data-disable-with], a[data-disable]",
                        buttonDisableSelector:
                            "button[data-remote][data-disable-with], button[data-remote][data-disable]",
                    };
                }.call(this));
            }.call(i));
            var e = i.Rails;
            (function () {
                (function () {
                    var t;
                    (t = null),
                        (e.loadCSPNonce = function () {
                            var s;
                            return (t =
                                (s = document.querySelector(
                                    "meta[name=csp-nonce]"
                                )) != null
                                    ? s.content
                                    : void 0);
                        }),
                        (e.cspNonce = function () {
                            return t ?? e.loadCSPNonce();
                        });
                }.call(this),
                    function () {
                        var t, s;
                        (s =
                            Element.prototype.matches ||
                            Element.prototype.matchesSelector ||
                            Element.prototype.mozMatchesSelector ||
                            Element.prototype.msMatchesSelector ||
                            Element.prototype.oMatchesSelector ||
                            Element.prototype.webkitMatchesSelector),
                            (e.matches = function (r, o) {
                                return o.exclude != null
                                    ? s.call(r, o.selector) &&
                                          !s.call(r, o.exclude)
                                    : s.call(r, o);
                            }),
                            (t = "_ujsData"),
                            (e.getData = function (r, o) {
                                var h;
                                return (h = r[t]) != null ? h[o] : void 0;
                            }),
                            (e.setData = function (r, o, h) {
                                return (
                                    r[t] == null && (r[t] = {}), (r[t][o] = h)
                                );
                            }),
                            (e.$ = function (r) {
                                return Array.prototype.slice.call(
                                    document.querySelectorAll(r)
                                );
                            });
                    }.call(this),
                    function () {
                        var t, s, r;
                        (t = e.$),
                            (r = e.csrfToken =
                                function () {
                                    var o;
                                    return (
                                        (o = document.querySelector(
                                            "meta[name=csrf-token]"
                                        )),
                                        o && o.content
                                    );
                                }),
                            (s = e.csrfParam =
                                function () {
                                    var o;
                                    return (
                                        (o = document.querySelector(
                                            "meta[name=csrf-param]"
                                        )),
                                        o && o.content
                                    );
                                }),
                            (e.CSRFProtection = function (o) {
                                var h;
                                if (((h = r()), h != null))
                                    return o.setRequestHeader(
                                        "X-CSRF-Token",
                                        h
                                    );
                            }),
                            (e.refreshCSRFTokens = function () {
                                var o, h;
                                if (
                                    ((h = r()),
                                    (o = s()),
                                    h != null && o != null)
                                )
                                    return t(
                                        'form input[name="' + o + '"]'
                                    ).forEach(function (p) {
                                        return (p.value = h);
                                    });
                            });
                    }.call(this),
                    function () {
                        var t, s, r, o;
                        (r = e.matches),
                            (t = window.CustomEvent),
                            typeof t != "function" &&
                                ((t = function (h, p) {
                                    var b;
                                    return (
                                        (b =
                                            document.createEvent(
                                                "CustomEvent"
                                            )),
                                        b.initCustomEvent(
                                            h,
                                            p.bubbles,
                                            p.cancelable,
                                            p.detail
                                        ),
                                        b
                                    );
                                }),
                                (t.prototype = window.Event.prototype),
                                (o = t.prototype.preventDefault),
                                (t.prototype.preventDefault = function () {
                                    var h;
                                    return (
                                        (h = o.call(this)),
                                        this.cancelable &&
                                            !this.defaultPrevented &&
                                            Object.defineProperty(
                                                this,
                                                "defaultPrevented",
                                                {
                                                    get: function () {
                                                        return !0;
                                                    },
                                                }
                                            ),
                                        h
                                    );
                                })),
                            (s = e.fire =
                                function (h, p, b) {
                                    var f;
                                    return (
                                        (f = new t(p, {
                                            bubbles: !0,
                                            cancelable: !0,
                                            detail: b,
                                        })),
                                        h.dispatchEvent(f),
                                        !f.defaultPrevented
                                    );
                                }),
                            (e.stopEverything = function (h) {
                                return (
                                    s(h.target, "ujs:everythingStopped"),
                                    h.preventDefault(),
                                    h.stopPropagation(),
                                    h.stopImmediatePropagation()
                                );
                            }),
                            (e.delegate = function (h, p, b, f) {
                                return h.addEventListener(b, function (w) {
                                    var v;
                                    for (
                                        v = w.target;
                                        !(!(v instanceof Element) || r(v, p));

                                    )
                                        v = v.parentNode;
                                    if (
                                        v instanceof Element &&
                                        f.call(v, w) === !1
                                    )
                                        return (
                                            w.preventDefault(),
                                            w.stopPropagation()
                                        );
                                });
                            });
                    }.call(this),
                    function () {
                        var t, s, r, o, h, p, b;
                        (o = e.cspNonce),
                            (s = e.CSRFProtection),
                            (h = e.fire),
                            (t = {
                                "*": "*/*",
                                text: "text/plain",
                                html: "text/html",
                                xml: "application/xml, text/xml",
                                json: "application/json, text/javascript",
                                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript",
                            }),
                            (e.ajax = function (f) {
                                var w;
                                if (
                                    ((f = p(f)),
                                    (w = r(f, function () {
                                        var v, E;
                                        return (
                                            (E = b(
                                                (v = w.response) != null
                                                    ? v
                                                    : w.responseText,
                                                w.getResponseHeader(
                                                    "Content-Type"
                                                )
                                            )),
                                            Math.floor(w.status / 100) === 2
                                                ? typeof f.success ==
                                                      "function" &&
                                                  f.success(E, w.statusText, w)
                                                : typeof f.error ==
                                                      "function" &&
                                                  f.error(E, w.statusText, w),
                                            typeof f.complete == "function"
                                                ? f.complete(w, w.statusText)
                                                : void 0
                                        );
                                    })),
                                    f.beforeSend != null && !f.beforeSend(w, f))
                                )
                                    return !1;
                                if (w.readyState === XMLHttpRequest.OPENED)
                                    return w.send(f.data);
                            }),
                            (p = function (f) {
                                return (
                                    (f.url = f.url || location.href),
                                    (f.type = f.type.toUpperCase()),
                                    f.type === "GET" &&
                                        f.data &&
                                        (f.url.indexOf("?") < 0
                                            ? (f.url += "?" + f.data)
                                            : (f.url += "&" + f.data)),
                                    t[f.dataType] == null && (f.dataType = "*"),
                                    (f.accept = t[f.dataType]),
                                    f.dataType !== "*" &&
                                        (f.accept += ", */*; q=0.01"),
                                    f
                                );
                            }),
                            (r = function (f, w) {
                                var v;
                                return (
                                    (v = new XMLHttpRequest()),
                                    v.open(f.type, f.url, !0),
                                    v.setRequestHeader("Accept", f.accept),
                                    typeof f.data == "string" &&
                                        v.setRequestHeader(
                                            "Content-Type",
                                            "application/x-www-form-urlencoded; charset=UTF-8"
                                        ),
                                    f.crossDomain ||
                                        (v.setRequestHeader(
                                            "X-Requested-With",
                                            "XMLHttpRequest"
                                        ),
                                        s(v)),
                                    (v.withCredentials = !!f.withCredentials),
                                    (v.onreadystatechange = function () {
                                        if (
                                            v.readyState === XMLHttpRequest.DONE
                                        )
                                            return w(v);
                                    }),
                                    v
                                );
                            }),
                            (b = function (f, w) {
                                var v, E;
                                if (
                                    typeof f == "string" &&
                                    typeof w == "string"
                                ) {
                                    if (w.match(/\bjson\b/))
                                        try {
                                            f = JSON.parse(f);
                                        } catch {}
                                    else if (w.match(/\b(?:java|ecma)script\b/))
                                        (E = document.createElement("script")),
                                            E.setAttribute("nonce", o()),
                                            (E.text = f),
                                            document.head
                                                .appendChild(E)
                                                .parentNode.removeChild(E);
                                    else if (w.match(/\b(xml|html|svg)\b/)) {
                                        (v = new DOMParser()),
                                            (w = w.replace(/;.+/, ""));
                                        try {
                                            f = v.parseFromString(f, w);
                                        } catch {}
                                    }
                                }
                                return f;
                            }),
                            (e.href = function (f) {
                                return f.href;
                            }),
                            (e.isCrossDomain = function (f) {
                                var w, v, E;
                                (v = document.createElement("a")),
                                    (v.href = location.href),
                                    (E = document.createElement("a"));
                                try {
                                    return (
                                        (E.href = f),
                                        !(
                                            ((!E.protocol ||
                                                E.protocol === ":") &&
                                                !E.host) ||
                                            v.protocol + "//" + v.host ==
                                                E.protocol + "//" + E.host
                                        )
                                    );
                                } catch (S) {
                                    return (w = S), !0;
                                }
                            });
                    }.call(this),
                    function () {
                        var t, s;
                        (t = e.matches),
                            (s = function (r) {
                                return Array.prototype.slice.call(r);
                            }),
                            (e.serializeElement = function (r, o) {
                                var h, p;
                                return (
                                    (h = [r]),
                                    t(r, "form") && (h = s(r.elements)),
                                    (p = []),
                                    h.forEach(function (b) {
                                        if (
                                            !(!b.name || b.disabled) &&
                                            !t(b, "fieldset[disabled] *")
                                        ) {
                                            if (t(b, "select"))
                                                return s(b.options).forEach(
                                                    function (f) {
                                                        if (f.selected)
                                                            return p.push({
                                                                name: b.name,
                                                                value: f.value,
                                                            });
                                                    }
                                                );
                                            if (
                                                b.checked ||
                                                [
                                                    "radio",
                                                    "checkbox",
                                                    "submit",
                                                ].indexOf(b.type) === -1
                                            )
                                                return p.push({
                                                    name: b.name,
                                                    value: b.value,
                                                });
                                        }
                                    }),
                                    o && p.push(o),
                                    p
                                        .map(function (b) {
                                            return b.name != null
                                                ? encodeURIComponent(b.name) +
                                                      "=" +
                                                      encodeURIComponent(
                                                          b.value
                                                      )
                                                : b;
                                        })
                                        .join("&")
                                );
                            }),
                            (e.formElements = function (r, o) {
                                return t(r, "form")
                                    ? s(r.elements).filter(function (h) {
                                          return t(h, o);
                                      })
                                    : s(r.querySelectorAll(o));
                            });
                    }.call(this),
                    function () {
                        var t, s, r;
                        (s = e.fire),
                            (r = e.stopEverything),
                            (e.handleConfirm = function (o) {
                                if (!t(this)) return r(o);
                            }),
                            (e.confirm = function (o, h) {
                                return confirm(o);
                            }),
                            (t = function (o) {
                                var h, p, b;
                                if (((b = o.getAttribute("data-confirm")), !b))
                                    return !0;
                                if (((h = !1), s(o, "confirm"))) {
                                    try {
                                        h = e.confirm(b, o);
                                    } catch {}
                                    p = s(o, "confirm:complete", [h]);
                                }
                                return h && p;
                            });
                    }.call(this),
                    function () {
                        var t, s, r, o, h, p, b, f, w, v, E, S;
                        (v = e.matches),
                            (f = e.getData),
                            (E = e.setData),
                            (S = e.stopEverything),
                            (b = e.formElements),
                            (e.handleDisabledElement = function (m) {
                                var y;
                                if (((y = this), y.disabled)) return S(m);
                            }),
                            (e.enableElement = function (m) {
                                var y;
                                if (m instanceof Event) {
                                    if (w(m)) return;
                                    y = m.target;
                                } else y = m;
                                if (v(y, e.linkDisableSelector)) return p(y);
                                if (
                                    v(y, e.buttonDisableSelector) ||
                                    v(y, e.formEnableSelector)
                                )
                                    return o(y);
                                if (v(y, e.formSubmitSelector)) return h(y);
                            }),
                            (e.disableElement = function (m) {
                                var y;
                                if (
                                    ((y = m instanceof Event ? m.target : m),
                                    v(y, e.linkDisableSelector))
                                )
                                    return r(y);
                                if (
                                    v(y, e.buttonDisableSelector) ||
                                    v(y, e.formDisableSelector)
                                )
                                    return t(y);
                                if (v(y, e.formSubmitSelector)) return s(y);
                            }),
                            (r = function (m) {
                                var y;
                                if (!f(m, "ujs:disabled"))
                                    return (
                                        (y =
                                            m.getAttribute(
                                                "data-disable-with"
                                            )),
                                        y != null &&
                                            (E(
                                                m,
                                                "ujs:enable-with",
                                                m.innerHTML
                                            ),
                                            (m.innerHTML = y)),
                                        m.addEventListener("click", S),
                                        E(m, "ujs:disabled", !0)
                                    );
                            }),
                            (p = function (m) {
                                var y;
                                return (
                                    (y = f(m, "ujs:enable-with")),
                                    y != null &&
                                        ((m.innerHTML = y),
                                        E(m, "ujs:enable-with", null)),
                                    m.removeEventListener("click", S),
                                    E(m, "ujs:disabled", null)
                                );
                            }),
                            (s = function (m) {
                                return b(m, e.formDisableSelector).forEach(t);
                            }),
                            (t = function (m) {
                                var y;
                                if (!f(m, "ujs:disabled"))
                                    return (
                                        (y =
                                            m.getAttribute(
                                                "data-disable-with"
                                            )),
                                        y != null &&
                                            (v(m, "button")
                                                ? (E(
                                                      m,
                                                      "ujs:enable-with",
                                                      m.innerHTML
                                                  ),
                                                  (m.innerHTML = y))
                                                : (E(
                                                      m,
                                                      "ujs:enable-with",
                                                      m.value
                                                  ),
                                                  (m.value = y))),
                                        (m.disabled = !0),
                                        E(m, "ujs:disabled", !0)
                                    );
                            }),
                            (h = function (m) {
                                return b(m, e.formEnableSelector).forEach(o);
                            }),
                            (o = function (m) {
                                var y;
                                return (
                                    (y = f(m, "ujs:enable-with")),
                                    y != null &&
                                        (v(m, "button")
                                            ? (m.innerHTML = y)
                                            : (m.value = y),
                                        E(m, "ujs:enable-with", null)),
                                    (m.disabled = !1),
                                    E(m, "ujs:disabled", null)
                                );
                            }),
                            (w = function (m) {
                                var y, g;
                                return (
                                    (g =
                                        (y = m.detail) != null ? y[0] : void 0),
                                    (g != null
                                        ? g.getResponseHeader("X-Xhr-Redirect")
                                        : void 0) != null
                                );
                            });
                    }.call(this),
                    function () {
                        var t;
                        (t = e.stopEverything),
                            (e.handleMethod = function (s) {
                                var r, o, h, p, b, f, w;
                                if (
                                    ((f = this),
                                    (w = f.getAttribute("data-method")),
                                    !!w)
                                )
                                    return (
                                        (b = e.href(f)),
                                        (o = e.csrfToken()),
                                        (r = e.csrfParam()),
                                        (h = document.createElement("form")),
                                        (p =
                                            "<input name='_method' value='" +
                                            w +
                                            "' type='hidden' />"),
                                        r != null &&
                                            o != null &&
                                            !e.isCrossDomain(b) &&
                                            (p +=
                                                "<input name='" +
                                                r +
                                                "' value='" +
                                                o +
                                                "' type='hidden' />"),
                                        (p += '<input type="submit" />'),
                                        (h.method = "post"),
                                        (h.action = b),
                                        (h.target = f.target),
                                        (h.innerHTML = p),
                                        (h.style.display = "none"),
                                        document.body.appendChild(h),
                                        h
                                            .querySelector('[type="submit"]')
                                            .click(),
                                        t(s)
                                    );
                            });
                    }.call(this),
                    function () {
                        var t,
                            s,
                            r,
                            o,
                            h,
                            p,
                            b,
                            f,
                            w,
                            v = [].slice;
                        (p = e.matches),
                            (r = e.getData),
                            (f = e.setData),
                            (s = e.fire),
                            (w = e.stopEverything),
                            (t = e.ajax),
                            (o = e.isCrossDomain),
                            (b = e.serializeElement),
                            (h = function (E) {
                                var S;
                                return (
                                    (S = E.getAttribute("data-remote")),
                                    S != null && S !== "false"
                                );
                            }),
                            (e.handleRemote = function (E) {
                                var S, m, y, g, d, u, a;
                                return (
                                    (g = this),
                                    h(g)
                                        ? s(g, "ajax:before")
                                            ? ((a = g.getAttribute(
                                                  "data-with-credentials"
                                              )),
                                              (y =
                                                  g.getAttribute("data-type") ||
                                                  "script"),
                                              p(g, e.formSubmitSelector)
                                                  ? ((S = r(
                                                        g,
                                                        "ujs:submit-button"
                                                    )),
                                                    (d =
                                                        r(
                                                            g,
                                                            "ujs:submit-button-formmethod"
                                                        ) || g.method),
                                                    (u =
                                                        r(
                                                            g,
                                                            "ujs:submit-button-formaction"
                                                        ) ||
                                                        g.getAttribute(
                                                            "action"
                                                        ) ||
                                                        location.href),
                                                    d.toUpperCase() === "GET" &&
                                                        (u = u.replace(
                                                            /\?.*$/,
                                                            ""
                                                        )),
                                                    g.enctype ===
                                                    "multipart/form-data"
                                                        ? ((m = new FormData(
                                                              g
                                                          )),
                                                          S != null &&
                                                              m.append(
                                                                  S.name,
                                                                  S.value
                                                              ))
                                                        : (m = b(g, S)),
                                                    f(
                                                        g,
                                                        "ujs:submit-button",
                                                        null
                                                    ),
                                                    f(
                                                        g,
                                                        "ujs:submit-button-formmethod",
                                                        null
                                                    ),
                                                    f(
                                                        g,
                                                        "ujs:submit-button-formaction",
                                                        null
                                                    ))
                                                  : p(
                                                        g,
                                                        e.buttonClickSelector
                                                    ) ||
                                                    p(g, e.inputChangeSelector)
                                                  ? ((d =
                                                        g.getAttribute(
                                                            "data-method"
                                                        )),
                                                    (u =
                                                        g.getAttribute(
                                                            "data-url"
                                                        )),
                                                    (m = b(
                                                        g,
                                                        g.getAttribute(
                                                            "data-params"
                                                        )
                                                    )))
                                                  : ((d =
                                                        g.getAttribute(
                                                            "data-method"
                                                        )),
                                                    (u = e.href(g)),
                                                    (m =
                                                        g.getAttribute(
                                                            "data-params"
                                                        ))),
                                              t({
                                                  type: d || "GET",
                                                  url: u,
                                                  data: m,
                                                  dataType: y,
                                                  beforeSend: function (n, l) {
                                                      return s(
                                                          g,
                                                          "ajax:beforeSend",
                                                          [n, l]
                                                      )
                                                          ? s(g, "ajax:send", [
                                                                n,
                                                            ])
                                                          : (s(
                                                                g,
                                                                "ajax:stopped"
                                                            ),
                                                            !1);
                                                  },
                                                  success: function () {
                                                      var n;
                                                      return (
                                                          (n =
                                                              1 <=
                                                              arguments.length
                                                                  ? v.call(
                                                                        arguments,
                                                                        0
                                                                    )
                                                                  : []),
                                                          s(
                                                              g,
                                                              "ajax:success",
                                                              n
                                                          )
                                                      );
                                                  },
                                                  error: function () {
                                                      var n;
                                                      return (
                                                          (n =
                                                              1 <=
                                                              arguments.length
                                                                  ? v.call(
                                                                        arguments,
                                                                        0
                                                                    )
                                                                  : []),
                                                          s(g, "ajax:error", n)
                                                      );
                                                  },
                                                  complete: function () {
                                                      var n;
                                                      return (
                                                          (n =
                                                              1 <=
                                                              arguments.length
                                                                  ? v.call(
                                                                        arguments,
                                                                        0
                                                                    )
                                                                  : []),
                                                          s(
                                                              g,
                                                              "ajax:complete",
                                                              n
                                                          )
                                                      );
                                                  },
                                                  crossDomain: o(u),
                                                  withCredentials:
                                                      a != null &&
                                                      a !== "false",
                                              }),
                                              w(E))
                                            : (s(g, "ajax:stopped"), !1)
                                        : !0
                                );
                            }),
                            (e.formSubmitButtonClick = function (E) {
                                var S, m;
                                if (((S = this), (m = S.form), !!m))
                                    return (
                                        S.name &&
                                            f(m, "ujs:submit-button", {
                                                name: S.name,
                                                value: S.value,
                                            }),
                                        f(
                                            m,
                                            "ujs:formnovalidate-button",
                                            S.formNoValidate
                                        ),
                                        f(
                                            m,
                                            "ujs:submit-button-formaction",
                                            S.getAttribute("formaction")
                                        ),
                                        f(
                                            m,
                                            "ujs:submit-button-formmethod",
                                            S.getAttribute("formmethod")
                                        )
                                    );
                            }),
                            (e.preventInsignificantClick = function (E) {
                                var S, m, y, g, d, u;
                                if (
                                    ((y = this),
                                    (d = (
                                        y.getAttribute("data-method") || "GET"
                                    ).toUpperCase()),
                                    (S = y.getAttribute("data-params")),
                                    (g = E.metaKey || E.ctrlKey),
                                    (m = g && d === "GET" && !S),
                                    (u = E.button != null && E.button !== 0),
                                    u || m)
                                )
                                    return E.stopImmediatePropagation();
                            });
                    }.call(this),
                    function () {
                        var t, s, r, o, h, p, b, f, w, v, E, S, m, y, g;
                        if (
                            ((p = e.fire),
                            (r = e.delegate),
                            (f = e.getData),
                            (t = e.$),
                            (g = e.refreshCSRFTokens),
                            (s = e.CSRFProtection),
                            (m = e.loadCSPNonce),
                            (h = e.enableElement),
                            (o = e.disableElement),
                            (v = e.handleDisabledElement),
                            (w = e.handleConfirm),
                            (y = e.preventInsignificantClick),
                            (S = e.handleRemote),
                            (b = e.formSubmitButtonClick),
                            (E = e.handleMethod),
                            typeof jQuery != "undefined" &&
                                jQuery !== null &&
                                jQuery.ajax != null)
                        ) {
                            if (jQuery.rails)
                                throw new Error(
                                    "If you load both jquery_ujs and rails-ujs, use rails-ujs only."
                                );
                            (jQuery.rails = e),
                                jQuery.ajaxPrefilter(function (d, u, a) {
                                    if (!d.crossDomain) return s(a);
                                });
                        }
                        (e.start = function () {
                            if (window._rails_loaded)
                                throw new Error(
                                    "rails-ujs has already been loaded!"
                                );
                            return (
                                window.addEventListener(
                                    "pageshow",
                                    function () {
                                        return (
                                            t(e.formEnableSelector).forEach(
                                                function (d) {
                                                    if (f(d, "ujs:disabled"))
                                                        return h(d);
                                                }
                                            ),
                                            t(e.linkDisableSelector).forEach(
                                                function (d) {
                                                    if (f(d, "ujs:disabled"))
                                                        return h(d);
                                                }
                                            )
                                        );
                                    }
                                ),
                                r(
                                    document,
                                    e.linkDisableSelector,
                                    "ajax:complete",
                                    h
                                ),
                                r(
                                    document,
                                    e.linkDisableSelector,
                                    "ajax:stopped",
                                    h
                                ),
                                r(
                                    document,
                                    e.buttonDisableSelector,
                                    "ajax:complete",
                                    h
                                ),
                                r(
                                    document,
                                    e.buttonDisableSelector,
                                    "ajax:stopped",
                                    h
                                ),
                                r(document, e.linkClickSelector, "click", y),
                                r(document, e.linkClickSelector, "click", v),
                                r(document, e.linkClickSelector, "click", w),
                                r(document, e.linkClickSelector, "click", o),
                                r(document, e.linkClickSelector, "click", S),
                                r(document, e.linkClickSelector, "click", E),
                                r(document, e.buttonClickSelector, "click", y),
                                r(document, e.buttonClickSelector, "click", v),
                                r(document, e.buttonClickSelector, "click", w),
                                r(document, e.buttonClickSelector, "click", o),
                                r(document, e.buttonClickSelector, "click", S),
                                r(document, e.inputChangeSelector, "change", v),
                                r(document, e.inputChangeSelector, "change", w),
                                r(document, e.inputChangeSelector, "change", S),
                                r(document, e.formSubmitSelector, "submit", v),
                                r(document, e.formSubmitSelector, "submit", w),
                                r(document, e.formSubmitSelector, "submit", S),
                                r(
                                    document,
                                    e.formSubmitSelector,
                                    "submit",
                                    function (d) {
                                        return setTimeout(function () {
                                            return o(d);
                                        }, 13);
                                    }
                                ),
                                r(
                                    document,
                                    e.formSubmitSelector,
                                    "ajax:send",
                                    o
                                ),
                                r(
                                    document,
                                    e.formSubmitSelector,
                                    "ajax:complete",
                                    h
                                ),
                                r(
                                    document,
                                    e.formInputClickSelector,
                                    "click",
                                    y
                                ),
                                r(
                                    document,
                                    e.formInputClickSelector,
                                    "click",
                                    v
                                ),
                                r(
                                    document,
                                    e.formInputClickSelector,
                                    "click",
                                    w
                                ),
                                r(
                                    document,
                                    e.formInputClickSelector,
                                    "click",
                                    b
                                ),
                                document.addEventListener(
                                    "DOMContentLoaded",
                                    g
                                ),
                                document.addEventListener(
                                    "DOMContentLoaded",
                                    m
                                ),
                                (window._rails_loaded = !0)
                            );
                        }),
                            window.Rails === e &&
                                p(document, "rails:attachBindings") &&
                                e.start();
                    }.call(this));
            }.call(this),
                typeof Ne == "object" && Ne.exports
                    ? (Ne.exports = e)
                    : typeof define == "function" && define.amd && define(e));
        }.call(us));
    });
    var vs = Xe((At, bs) => {
        function Un(i, e) {
            if (!(i instanceof e))
                throw new TypeError("Cannot call a class as a function");
        }
        function gs(i, e) {
            for (var t = 0; t < e.length; t++) {
                var s = e[t];
                (s.enumerable = s.enumerable || !1),
                    (s.configurable = !0),
                    "value" in s && (s.writable = !0),
                    Object.defineProperty(i, s.key, s);
            }
        }
        function Wn(i, e, t) {
            return e && gs(i.prototype, e), t && gs(i, t), i;
        }
        var zn = (function () {
            function i() {
                var e =
                        arguments.length > 0 && arguments[0] !== void 0
                            ? arguments[0]
                            : "",
                    t =
                        arguments.length > 1 && arguments[1] !== void 0
                            ? arguments[1]
                            : {};
                Un(this, i),
                    (this.selector = e),
                    (this.elements = []),
                    (this.version = "1.3.0"),
                    (this.vp = this.getViewportSize()),
                    (this.body = document.querySelector("body")),
                    (this.options = {
                        wrap: t.wrap || !1,
                        wrapWith: t.wrapWith || "<span></span>",
                        marginTop: t.marginTop || 0,
                        marginBottom: t.marginBottom || 0,
                        stickyFor: t.stickyFor || 0,
                        stickyClass: t.stickyClass || null,
                        stickyContainer: t.stickyContainer || "body",
                    }),
                    (this.updateScrollTopPosition =
                        this.updateScrollTopPosition.bind(this)),
                    this.updateScrollTopPosition(),
                    window.addEventListener(
                        "load",
                        this.updateScrollTopPosition
                    ),
                    window.addEventListener(
                        "scroll",
                        this.updateScrollTopPosition
                    ),
                    this.run();
            }
            return (
                Wn(i, [
                    {
                        key: "run",
                        value: function () {
                            var t = this,
                                s = setInterval(function () {
                                    if (document.readyState === "complete") {
                                        clearInterval(s);
                                        var r = document.querySelectorAll(
                                            t.selector
                                        );
                                        t.forEach(r, function (o) {
                                            return t.renderElement(o);
                                        });
                                    }
                                }, 10);
                        },
                    },
                    {
                        key: "renderElement",
                        value: function (t) {
                            var s = this;
                            (t.sticky = {}),
                                (t.sticky.active = !1),
                                (t.sticky.marginTop =
                                    parseInt(
                                        t.getAttribute("data-margin-top")
                                    ) || this.options.marginTop),
                                (t.sticky.marginBottom =
                                    parseInt(
                                        t.getAttribute("data-margin-bottom")
                                    ) || this.options.marginBottom),
                                (t.sticky.stickyFor =
                                    parseInt(
                                        t.getAttribute("data-sticky-for")
                                    ) || this.options.stickyFor),
                                (t.sticky.stickyClass =
                                    t.getAttribute("data-sticky-class") ||
                                    this.options.stickyClass),
                                (t.sticky.wrap = t.hasAttribute(
                                    "data-sticky-wrap"
                                )
                                    ? !0
                                    : this.options.wrap),
                                (t.sticky.stickyContainer =
                                    this.options.stickyContainer),
                                (t.sticky.container =
                                    this.getStickyContainer(t)),
                                (t.sticky.container.rect = this.getRectangle(
                                    t.sticky.container
                                )),
                                (t.sticky.rect = this.getRectangle(t)),
                                t.tagName.toLowerCase() === "img" &&
                                    (t.onload = function () {
                                        return (t.sticky.rect =
                                            s.getRectangle(t));
                                    }),
                                t.sticky.wrap && this.wrapElement(t),
                                this.activate(t);
                        },
                    },
                    {
                        key: "wrapElement",
                        value: function (t) {
                            t.insertAdjacentHTML(
                                "beforebegin",
                                t.getAttribute("data-sticky-wrapWith") ||
                                    this.options.wrapWith
                            ),
                                t.previousSibling.appendChild(t);
                        },
                    },
                    {
                        key: "activate",
                        value: function (t) {
                            t.sticky.rect.top + t.sticky.rect.height <
                                t.sticky.container.rect.top +
                                    t.sticky.container.rect.height &&
                                t.sticky.stickyFor < this.vp.width &&
                                !t.sticky.active &&
                                (t.sticky.active = !0),
                                this.elements.indexOf(t) < 0 &&
                                    this.elements.push(t),
                                t.sticky.resizeEvent ||
                                    (this.initResizeEvents(t),
                                    (t.sticky.resizeEvent = !0)),
                                t.sticky.scrollEvent ||
                                    (this.initScrollEvents(t),
                                    (t.sticky.scrollEvent = !0)),
                                this.setPosition(t);
                        },
                    },
                    {
                        key: "initResizeEvents",
                        value: function (t) {
                            var s = this;
                            (t.sticky.resizeListener = function () {
                                return s.onResizeEvents(t);
                            }),
                                window.addEventListener(
                                    "resize",
                                    t.sticky.resizeListener
                                );
                        },
                    },
                    {
                        key: "destroyResizeEvents",
                        value: function (t) {
                            window.removeEventListener(
                                "resize",
                                t.sticky.resizeListener
                            );
                        },
                    },
                    {
                        key: "onResizeEvents",
                        value: function (t) {
                            (this.vp = this.getViewportSize()),
                                (t.sticky.rect = this.getRectangle(t)),
                                (t.sticky.container.rect = this.getRectangle(
                                    t.sticky.container
                                )),
                                t.sticky.rect.top + t.sticky.rect.height <
                                    t.sticky.container.rect.top +
                                        t.sticky.container.rect.height &&
                                t.sticky.stickyFor < this.vp.width &&
                                !t.sticky.active
                                    ? (t.sticky.active = !0)
                                    : (t.sticky.rect.top +
                                          t.sticky.rect.height >=
                                          t.sticky.container.rect.top +
                                              t.sticky.container.rect.height ||
                                          (t.sticky.stickyFor >=
                                              this.vp.width &&
                                              t.sticky.active)) &&
                                      (t.sticky.active = !1),
                                this.setPosition(t);
                        },
                    },
                    {
                        key: "initScrollEvents",
                        value: function (t) {
                            var s = this;
                            (t.sticky.scrollListener = function () {
                                return s.onScrollEvents(t);
                            }),
                                window.addEventListener(
                                    "scroll",
                                    t.sticky.scrollListener
                                );
                        },
                    },
                    {
                        key: "destroyScrollEvents",
                        value: function (t) {
                            window.removeEventListener(
                                "scroll",
                                t.sticky.scrollListener
                            );
                        },
                    },
                    {
                        key: "onScrollEvents",
                        value: function (t) {
                            t.sticky && t.sticky.active && this.setPosition(t);
                        },
                    },
                    {
                        key: "setPosition",
                        value: function (t) {
                            this.css(t, {
                                position: "",
                                width: "",
                                top: "",
                                left: "",
                            }),
                                !(
                                    this.vp.height < t.sticky.rect.height ||
                                    !t.sticky.active
                                ) &&
                                    (t.sticky.rect.width ||
                                        (t.sticky.rect = this.getRectangle(t)),
                                    t.sticky.wrap &&
                                        this.css(t.parentNode, {
                                            display: "block",
                                            width: t.sticky.rect.width + "px",
                                            height: t.sticky.rect.height + "px",
                                        }),
                                    t.sticky.rect.top === 0 &&
                                    t.sticky.container === this.body
                                        ? (this.css(t, {
                                              position: "fixed",
                                              top: t.sticky.rect.top + "px",
                                              left: t.sticky.rect.left + "px",
                                              width: t.sticky.rect.width + "px",
                                          }),
                                          t.sticky.stickyClass &&
                                              t.classList.add(
                                                  t.sticky.stickyClass
                                              ))
                                        : this.scrollTop >
                                          t.sticky.rect.top - t.sticky.marginTop
                                        ? (this.css(t, {
                                              position: "fixed",
                                              width: t.sticky.rect.width + "px",
                                              left: t.sticky.rect.left + "px",
                                          }),
                                          this.scrollTop +
                                              t.sticky.rect.height +
                                              t.sticky.marginTop >
                                          t.sticky.container.rect.top +
                                              t.sticky.container.offsetHeight -
                                              t.sticky.marginBottom
                                              ? (t.sticky.stickyClass &&
                                                    t.classList.remove(
                                                        t.sticky.stickyClass
                                                    ),
                                                this.css(t, {
                                                    top:
                                                        t.sticky.container.rect
                                                            .top +
                                                        t.sticky.container
                                                            .offsetHeight -
                                                        (this.scrollTop +
                                                            t.sticky.rect
                                                                .height +
                                                            t.sticky
                                                                .marginBottom) +
                                                        "px",
                                                }))
                                              : (t.sticky.stickyClass &&
                                                    t.classList.add(
                                                        t.sticky.stickyClass
                                                    ),
                                                this.css(t, {
                                                    top:
                                                        t.sticky.marginTop +
                                                        "px",
                                                })))
                                        : (t.sticky.stickyClass &&
                                              t.classList.remove(
                                                  t.sticky.stickyClass
                                              ),
                                          this.css(t, {
                                              position: "",
                                              width: "",
                                              top: "",
                                              left: "",
                                          }),
                                          t.sticky.wrap &&
                                              this.css(t.parentNode, {
                                                  display: "",
                                                  width: "",
                                                  height: "",
                                              })));
                        },
                    },
                    {
                        key: "update",
                        value: function () {
                            var t = this;
                            this.forEach(this.elements, function (s) {
                                (s.sticky.rect = t.getRectangle(s)),
                                    (s.sticky.container.rect = t.getRectangle(
                                        s.sticky.container
                                    )),
                                    t.activate(s),
                                    t.setPosition(s);
                            });
                        },
                    },
                    {
                        key: "destroy",
                        value: function () {
                            var t = this;
                            window.removeEventListener(
                                "load",
                                this.updateScrollTopPosition
                            ),
                                window.removeEventListener(
                                    "scroll",
                                    this.updateScrollTopPosition
                                ),
                                this.forEach(this.elements, function (s) {
                                    t.destroyResizeEvents(s),
                                        t.destroyScrollEvents(s),
                                        delete s.sticky;
                                });
                        },
                    },
                    {
                        key: "getStickyContainer",
                        value: function (t) {
                            for (
                                var s = t.parentNode;
                                !s.hasAttribute("data-sticky-container") &&
                                !s.parentNode.querySelector(
                                    t.sticky.stickyContainer
                                ) &&
                                s !== this.body;

                            )
                                s = s.parentNode;
                            return s;
                        },
                    },
                    {
                        key: "getRectangle",
                        value: function (t) {
                            this.css(t, {
                                position: "",
                                width: "",
                                top: "",
                                left: "",
                            });
                            var s = Math.max(
                                    t.offsetWidth,
                                    t.clientWidth,
                                    t.scrollWidth
                                ),
                                r = Math.max(
                                    t.offsetHeight,
                                    t.clientHeight,
                                    t.scrollHeight
                                ),
                                o = 0,
                                h = 0;
                            do
                                (o += t.offsetTop || 0),
                                    (h += t.offsetLeft || 0),
                                    (t = t.offsetParent);
                            while (t);
                            return { top: o, left: h, width: s, height: r };
                        },
                    },
                    {
                        key: "getViewportSize",
                        value: function () {
                            return {
                                width: Math.max(
                                    document.documentElement.clientWidth,
                                    window.innerWidth || 0
                                ),
                                height: Math.max(
                                    document.documentElement.clientHeight,
                                    window.innerHeight || 0
                                ),
                            };
                        },
                    },
                    {
                        key: "updateScrollTopPosition",
                        value: function () {
                            this.scrollTop =
                                (window.pageYOffset || document.scrollTop) -
                                    (document.clientTop || 0) || 0;
                        },
                    },
                    {
                        key: "forEach",
                        value: function (t, s) {
                            for (var r = 0, o = t.length; r < o; r++) s(t[r]);
                        },
                    },
                    {
                        key: "css",
                        value: function (t, s) {
                            for (var r in s)
                                s.hasOwnProperty(r) && (t.style[r] = s[r]);
                        },
                    },
                ]),
                i
            );
        })();
        (function (i, e) {
            typeof At != "undefined"
                ? (bs.exports = e)
                : typeof define == "function" && define.amd
                ? define([], function () {
                      return e;
                  })
                : (i.Sticky = e);
        })(At, zn);
    });
    var ws = Xe((ka, ys) => {
        var Kn = vs();
        ys.exports = Kn;
    });
    (function () {
        if (
            window.Reflect === void 0 ||
            window.customElements === void 0 ||
            window.customElements.polyfillWrapFlushCallback
        )
            return;
        let i = HTMLElement,
            e = {
                HTMLElement: function () {
                    return Reflect.construct(i, [], this.constructor);
                },
            };
        (window.HTMLElement = e.HTMLElement),
            (HTMLElement.prototype = i.prototype),
            (HTMLElement.prototype.constructor = HTMLElement),
            Object.setPrototypeOf(HTMLElement, i);
    })();
    (function (i) {
        if (typeof i.requestSubmit == "function") return;
        i.requestSubmit = function (s) {
            s
                ? (e(s, this), s.click())
                : ((s = document.createElement("input")),
                  (s.type = "submit"),
                  (s.hidden = !0),
                  this.appendChild(s),
                  s.click(),
                  this.removeChild(s));
        };
        function e(s, r) {
            s instanceof HTMLElement ||
                t(TypeError, "parameter 1 is not of type 'HTMLElement'"),
                s.type == "submit" ||
                    t(
                        TypeError,
                        "The specified element is not a submit button"
                    ),
                s.form == r ||
                    t(
                        DOMException,
                        "The specified element is not owned by this form element",
                        "NotFoundError"
                    );
        }
        function t(s, r, o) {
            throw new s(
                "Failed to execute 'requestSubmit' on 'HTMLFormElement': " +
                    r +
                    ".",
                o
            );
        }
    })(HTMLFormElement.prototype);
    var Dt = new WeakMap();
    function js(i) {
        let e =
                i instanceof Element
                    ? i
                    : i instanceof Node
                    ? i.parentElement
                    : null,
            t = e ? e.closest("input, button") : null;
        return (t == null ? void 0 : t.type) == "submit" ? t : null;
    }
    function $s(i) {
        let e = js(i.target);
        e && e.form && Dt.set(e.form, e);
    }
    (function () {
        if ("submitter" in Event.prototype) return;
        let i;
        if ("SubmitEvent" in window && /Apple Computer/.test(navigator.vendor))
            i = window.SubmitEvent.prototype;
        else {
            if ("SubmitEvent" in window) return;
            i = window.Event.prototype;
        }
        addEventListener("click", $s, !0),
            Object.defineProperty(i, "submitter", {
                get() {
                    if (
                        this.type == "submit" &&
                        this.target instanceof HTMLFormElement
                    )
                        return Dt.get(this.target);
                },
            });
    })();
    var j;
    (function (i) {
        (i.eager = "eager"), (i.lazy = "lazy");
    })(j || (j = {}));
    var B = class extends HTMLElement {
        constructor() {
            super();
            (this.loaded = Promise.resolve()),
                (this.delegate = new B.delegateConstructor(this));
        }
        static get observedAttributes() {
            return ["disabled", "loading", "src"];
        }
        connectedCallback() {
            this.delegate.connect();
        }
        disconnectedCallback() {
            this.delegate.disconnect();
        }
        reload() {
            let { src: e } = this;
            (this.src = null), (this.src = e);
        }
        attributeChangedCallback(e) {
            e == "loading"
                ? this.delegate.loadingStyleChanged()
                : e == "src"
                ? this.delegate.sourceURLChanged()
                : this.delegate.disabledChanged();
        }
        get src() {
            return this.getAttribute("src");
        }
        set src(e) {
            e ? this.setAttribute("src", e) : this.removeAttribute("src");
        }
        get loading() {
            return Vs(this.getAttribute("loading") || "");
        }
        set loading(e) {
            e
                ? this.setAttribute("loading", e)
                : this.removeAttribute("loading");
        }
        get disabled() {
            return this.hasAttribute("disabled");
        }
        set disabled(e) {
            e
                ? this.setAttribute("disabled", "")
                : this.removeAttribute("disabled");
        }
        get autoscroll() {
            return this.hasAttribute("autoscroll");
        }
        set autoscroll(e) {
            e
                ? this.setAttribute("autoscroll", "")
                : this.removeAttribute("autoscroll");
        }
        get complete() {
            return !this.delegate.isLoading;
        }
        get isActive() {
            return this.ownerDocument === document && !this.isPreview;
        }
        get isPreview() {
            var e, t;
            return (t =
                (e = this.ownerDocument) === null || e === void 0
                    ? void 0
                    : e.documentElement) === null || t === void 0
                ? void 0
                : t.hasAttribute("data-turbo-preview");
        }
    };
    function Vs(i) {
        switch (i.toLowerCase()) {
            case "lazy":
                return j.lazy;
            default:
                return j.eager;
        }
    }
    function x(i) {
        return new URL(i.toString(), document.baseURI);
    }
    function W(i) {
        let e;
        if (i.hash) return i.hash.slice(1);
        if ((e = i.href.match(/#(.*)$/))) return e[1];
    }
    function Je(i, e) {
        let t =
            (e == null ? void 0 : e.getAttribute("formaction")) ||
            i.getAttribute("action") ||
            i.action;
        return x(t);
    }
    function _s(i) {
        return (Xs(i).match(/\.[^.]*$/) || [])[0] || "";
    }
    function Us(i) {
        return !!_s(i).match(/^(?:|\.(?:htm|html|xhtml))$/);
    }
    function Ws(i, e) {
        let t = Js(e);
        return i.href === x(t).href || i.href.startsWith(t);
    }
    function ie(i, e) {
        return Ws(i, e) && Us(i);
    }
    function Ge(i) {
        let e = W(i);
        return e != null ? i.href.slice(0, -(e.length + 1)) : i.href;
    }
    function we(i) {
        return Ge(i);
    }
    function zs(i, e) {
        return x(i).href == x(e).href;
    }
    function Ks(i) {
        return i.pathname.split("/").slice(1);
    }
    function Xs(i) {
        return Ks(i).slice(-1)[0];
    }
    function Js(i) {
        return Gs(i.origin + i.pathname);
    }
    function Gs(i) {
        return i.endsWith("/") ? i : i + "/";
    }
    var Qe = class {
        constructor(e) {
            this.response = e;
        }
        get succeeded() {
            return this.response.ok;
        }
        get failed() {
            return !this.succeeded;
        }
        get clientError() {
            return this.statusCode >= 400 && this.statusCode <= 499;
        }
        get serverError() {
            return this.statusCode >= 500 && this.statusCode <= 599;
        }
        get redirected() {
            return this.response.redirected;
        }
        get location() {
            return x(this.response.url);
        }
        get isHTML() {
            return (
                this.contentType &&
                this.contentType.match(
                    /^(?:text\/([^\s;,]+\b)?html|application\/xhtml\+xml)\b/
                )
            );
        }
        get statusCode() {
            return this.response.status;
        }
        get contentType() {
            return this.header("Content-Type");
        }
        get responseText() {
            return this.response.clone().text();
        }
        get responseHTML() {
            return this.isHTML
                ? this.response.clone().text()
                : Promise.resolve(void 0);
        }
        header(e) {
            return this.response.headers.get(e);
        }
    };
    function P(i, { target: e, cancelable: t, detail: s } = {}) {
        let r = new CustomEvent(i, { cancelable: t, bubbles: !0, detail: s });
        return (
            e && e.isConnected
                ? e.dispatchEvent(r)
                : document.documentElement.dispatchEvent(r),
            r
        );
    }
    function Ee() {
        return new Promise((i) => requestAnimationFrame(() => i()));
    }
    function Qs() {
        return new Promise((i) => setTimeout(() => i(), 0));
    }
    function Ys() {
        return Promise.resolve();
    }
    function Bt(i = "") {
        return new DOMParser().parseFromString(i, "text/html");
    }
    function qt(i, ...e) {
        let t = Zs(i, e).replace(/^\n/, "").split(`
`),
            s = t[0].match(/^\s+/),
            r = s ? s[0].length : 0;
        return t.map((o) => o.slice(r)).join(`
`);
    }
    function Zs(i, e) {
        return i.reduce((t, s, r) => {
            let o = e[r] == null ? "" : e[r];
            return t + s + o;
        }, "");
    }
    function se() {
        return Array.apply(null, { length: 36 })
            .map((i, e) =>
                e == 8 || e == 13 || e == 18 || e == 23
                    ? "-"
                    : e == 14
                    ? "4"
                    : e == 19
                    ? (Math.floor(Math.random() * 4) + 8).toString(16)
                    : Math.floor(Math.random() * 15).toString(16)
            )
            .join("");
    }
    function Se(i, ...e) {
        for (let t of e.map((s) => (s == null ? void 0 : s.getAttribute(i))))
            if (typeof t == "string") return t;
        return null;
    }
    function Ye(...i) {
        for (let e of i)
            e.localName == "turbo-frame" && e.setAttribute("busy", ""),
                e.setAttribute("aria-busy", "true");
    }
    function Ze(...i) {
        for (let e of i)
            e.localName == "turbo-frame" && e.removeAttribute("busy"),
                e.removeAttribute("aria-busy");
    }
    var R;
    (function (i) {
        (i[(i.get = 0)] = "get"),
            (i[(i.post = 1)] = "post"),
            (i[(i.put = 2)] = "put"),
            (i[(i.patch = 3)] = "patch"),
            (i[(i.delete = 4)] = "delete");
    })(R || (R = {}));
    function er(i) {
        switch (i.toLowerCase()) {
            case "get":
                return R.get;
            case "post":
                return R.post;
            case "put":
                return R.put;
            case "patch":
                return R.patch;
            case "delete":
                return R.delete;
        }
    }
    var Ce = class {
            constructor(e, t, s, r = new URLSearchParams(), o = null) {
                (this.abortController = new AbortController()),
                    (this.resolveRequestPromise = (h) => {}),
                    (this.delegate = e),
                    (this.method = t),
                    (this.headers = this.defaultHeaders),
                    (this.body = r),
                    (this.url = s),
                    (this.target = o);
            }
            get location() {
                return this.url;
            }
            get params() {
                return this.url.searchParams;
            }
            get entries() {
                return this.body ? Array.from(this.body.entries()) : [];
            }
            cancel() {
                this.abortController.abort();
            }
            async perform() {
                var e, t;
                let { fetchOptions: s } = this;
                (t = (e = this.delegate).prepareHeadersForRequest) === null ||
                    t === void 0 ||
                    t.call(e, this.headers, this),
                    await this.allowRequestToBeIntercepted(s);
                try {
                    this.delegate.requestStarted(this);
                    let r = await fetch(this.url.href, s);
                    return await this.receive(r);
                } catch (r) {
                    if (r.name !== "AbortError")
                        throw (this.delegate.requestErrored(this, r), r);
                } finally {
                    this.delegate.requestFinished(this);
                }
            }
            async receive(e) {
                let t = new Qe(e);
                return (
                    P("turbo:before-fetch-response", {
                        cancelable: !0,
                        detail: { fetchResponse: t },
                        target: this.target,
                    }).defaultPrevented
                        ? this.delegate.requestPreventedHandlingResponse(
                              this,
                              t
                          )
                        : t.succeeded
                        ? this.delegate.requestSucceededWithResponse(this, t)
                        : this.delegate.requestFailedWithResponse(this, t),
                    t
                );
            }
            get fetchOptions() {
                var e;
                return {
                    method: R[this.method].toUpperCase(),
                    credentials: "same-origin",
                    headers: this.headers,
                    redirect: "follow",
                    body: this.isIdempotent ? null : this.body,
                    signal: this.abortSignal,
                    referrer:
                        (e = this.delegate.referrer) === null || e === void 0
                            ? void 0
                            : e.href,
                };
            }
            get defaultHeaders() {
                return { Accept: "text/html, application/xhtml+xml" };
            }
            get isIdempotent() {
                return this.method == R.get;
            }
            get abortSignal() {
                return this.abortController.signal;
            }
            async allowRequestToBeIntercepted(e) {
                let t = new Promise((r) => (this.resolveRequestPromise = r));
                P("turbo:before-fetch-request", {
                    cancelable: !0,
                    detail: {
                        fetchOptions: e,
                        url: this.url,
                        resume: this.resolveRequestPromise,
                    },
                    target: this.target,
                }).defaultPrevented && (await t);
            }
        },
        Nt = class {
            constructor(e, t) {
                (this.started = !1),
                    (this.intersect = (s) => {
                        let r = s.slice(-1)[0];
                        (r == null ? void 0 : r.isIntersecting) &&
                            this.delegate.elementAppearedInViewport(
                                this.element
                            );
                    }),
                    (this.delegate = e),
                    (this.element = t),
                    (this.intersectionObserver = new IntersectionObserver(
                        this.intersect
                    ));
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    this.intersectionObserver.observe(this.element));
            }
            stop() {
                this.started &&
                    ((this.started = !1),
                    this.intersectionObserver.unobserve(this.element));
            }
        },
        J = class {
            constructor(e) {
                (this.templateElement = document.createElement("template")),
                    (this.templateElement.innerHTML = e);
            }
            static wrap(e) {
                return typeof e == "string" ? new this(e) : e;
            }
            get fragment() {
                let e = document.createDocumentFragment();
                for (let t of this.foreignElements)
                    e.appendChild(document.importNode(t, !0));
                return e;
            }
            get foreignElements() {
                return this.templateChildren.reduce(
                    (e, t) =>
                        t.tagName.toLowerCase() == "turbo-stream"
                            ? [...e, t]
                            : e,
                    []
                );
            }
            get templateChildren() {
                return Array.from(this.templateElement.content.children);
            }
        };
    J.contentType = "text/vnd.turbo-stream.html";
    var $;
    (function (i) {
        (i[(i.initialized = 0)] = "initialized"),
            (i[(i.requesting = 1)] = "requesting"),
            (i[(i.waiting = 2)] = "waiting"),
            (i[(i.receiving = 3)] = "receiving"),
            (i[(i.stopping = 4)] = "stopping"),
            (i[(i.stopped = 5)] = "stopped");
    })($ || ($ = {}));
    var V;
    (function (i) {
        (i.urlEncoded = "application/x-www-form-urlencoded"),
            (i.multipart = "multipart/form-data"),
            (i.plain = "text/plain");
    })(V || (V = {}));
    function tr(i) {
        switch (i.toLowerCase()) {
            case V.multipart:
                return V.multipart;
            case V.plain:
                return V.plain;
            default:
                return V.urlEncoded;
        }
    }
    var G = class {
        constructor(e, t, s, r = !1) {
            (this.state = $.initialized),
                (this.delegate = e),
                (this.formElement = t),
                (this.submitter = s),
                (this.formData = ir(t, s)),
                (this.location = x(this.action)),
                this.method == R.get &&
                    nr(this.location, [...this.body.entries()]),
                (this.fetchRequest = new Ce(
                    this,
                    this.method,
                    this.location,
                    this.body,
                    this.formElement
                )),
                (this.mustRedirect = r);
        }
        static confirmMethod(e, t) {
            return confirm(e);
        }
        get method() {
            var e;
            let t =
                ((e = this.submitter) === null || e === void 0
                    ? void 0
                    : e.getAttribute("formmethod")) ||
                this.formElement.getAttribute("method") ||
                "";
            return er(t.toLowerCase()) || R.get;
        }
        get action() {
            var e;
            let t =
                typeof this.formElement.action == "string"
                    ? this.formElement.action
                    : null;
            return (
                ((e = this.submitter) === null || e === void 0
                    ? void 0
                    : e.getAttribute("formaction")) ||
                this.formElement.getAttribute("action") ||
                t ||
                ""
            );
        }
        get body() {
            return this.enctype == V.urlEncoded || this.method == R.get
                ? new URLSearchParams(this.stringFormData)
                : this.formData;
        }
        get enctype() {
            var e;
            return tr(
                ((e = this.submitter) === null || e === void 0
                    ? void 0
                    : e.getAttribute("formenctype")) || this.formElement.enctype
            );
        }
        get isIdempotent() {
            return this.fetchRequest.isIdempotent;
        }
        get stringFormData() {
            return [...this.formData].reduce(
                (e, [t, s]) => e.concat(typeof s == "string" ? [[t, s]] : []),
                []
            );
        }
        get confirmationMessage() {
            return this.formElement.getAttribute("data-turbo-confirm");
        }
        get needsConfirmation() {
            return this.confirmationMessage !== null;
        }
        async start() {
            let { initialized: e, requesting: t } = $;
            if (
                !(
                    this.needsConfirmation &&
                    !G.confirmMethod(this.confirmationMessage, this.formElement)
                ) &&
                this.state == e
            )
                return (this.state = t), this.fetchRequest.perform();
        }
        stop() {
            let { stopping: e, stopped: t } = $;
            if (this.state != e && this.state != t)
                return (this.state = e), this.fetchRequest.cancel(), !0;
        }
        prepareHeadersForRequest(e, t) {
            if (!t.isIdempotent) {
                let s = sr(Ht("csrf-param")) || Ht("csrf-token");
                s && (e["X-CSRF-Token"] = s),
                    (e.Accept = [J.contentType, e.Accept].join(", "));
            }
        }
        requestStarted(e) {
            var t;
            (this.state = $.waiting),
                (t = this.submitter) === null ||
                    t === void 0 ||
                    t.setAttribute("disabled", ""),
                P("turbo:submit-start", {
                    target: this.formElement,
                    detail: { formSubmission: this },
                }),
                this.delegate.formSubmissionStarted(this);
        }
        requestPreventedHandlingResponse(e, t) {
            this.result = { success: t.succeeded, fetchResponse: t };
        }
        requestSucceededWithResponse(e, t) {
            if (t.clientError || t.serverError)
                this.delegate.formSubmissionFailedWithResponse(this, t);
            else if (this.requestMustRedirect(e) && rr(t)) {
                let s = new Error(
                    "Form responses must redirect to another location"
                );
                this.delegate.formSubmissionErrored(this, s);
            } else
                (this.state = $.receiving),
                    (this.result = { success: !0, fetchResponse: t }),
                    this.delegate.formSubmissionSucceededWithResponse(this, t);
        }
        requestFailedWithResponse(e, t) {
            (this.result = { success: !1, fetchResponse: t }),
                this.delegate.formSubmissionFailedWithResponse(this, t);
        }
        requestErrored(e, t) {
            (this.result = { success: !1, error: t }),
                this.delegate.formSubmissionErrored(this, t);
        }
        requestFinished(e) {
            var t;
            (this.state = $.stopped),
                (t = this.submitter) === null ||
                    t === void 0 ||
                    t.removeAttribute("disabled"),
                P("turbo:submit-end", {
                    target: this.formElement,
                    detail: Object.assign(
                        { formSubmission: this },
                        this.result
                    ),
                }),
                this.delegate.formSubmissionFinished(this);
        }
        requestMustRedirect(e) {
            return !e.isIdempotent && this.mustRedirect;
        }
    };
    function ir(i, e) {
        let t = new FormData(i),
            s = e == null ? void 0 : e.getAttribute("name"),
            r = e == null ? void 0 : e.getAttribute("value");
        return s && r != null && t.get(s) != r && t.append(s, r), t;
    }
    function sr(i) {
        if (i != null) {
            let t = (document.cookie ? document.cookie.split("; ") : []).find(
                (s) => s.startsWith(i)
            );
            if (t) {
                let s = t.split("=").slice(1).join("=");
                return s ? decodeURIComponent(s) : void 0;
            }
        }
    }
    function Ht(i) {
        let e = document.querySelector(`meta[name="${i}"]`);
        return e && e.content;
    }
    function rr(i) {
        return i.statusCode == 200 && !i.redirected;
    }
    function nr(i, e) {
        let t = new URLSearchParams();
        for (let [s, r] of e) r instanceof File || t.append(s, r);
        return (i.search = t.toString()), i;
    }
    var re = class {
            constructor(e) {
                this.element = e;
            }
            get children() {
                return [...this.element.children];
            }
            hasAnchor(e) {
                return this.getElementForAnchor(e) != null;
            }
            getElementForAnchor(e) {
                return e
                    ? this.element.querySelector(`[id='${e}'], a[name='${e}']`)
                    : null;
            }
            get isConnected() {
                return this.element.isConnected;
            }
            get firstAutofocusableElement() {
                return this.element.querySelector("[autofocus]");
            }
            get permanentElements() {
                return [
                    ...this.element.querySelectorAll(
                        "[id][data-turbo-permanent]"
                    ),
                ];
            }
            getPermanentElementById(e) {
                return this.element.querySelector(
                    `#${e}[data-turbo-permanent]`
                );
            }
            getPermanentElementMapForSnapshot(e) {
                let t = {};
                for (let s of this.permanentElements) {
                    let { id: r } = s,
                        o = e.getPermanentElementById(r);
                    o && (t[r] = [s, o]);
                }
                return t;
            }
        },
        et = class {
            constructor(e, t) {
                (this.submitBubbled = (s) => {
                    let r = s.target;
                    if (
                        !s.defaultPrevented &&
                        r instanceof HTMLFormElement &&
                        r.closest("turbo-frame, html") == this.element
                    ) {
                        let o = s.submitter || void 0;
                        ((o == null ? void 0 : o.getAttribute("formmethod")) ||
                            r.method) != "dialog" &&
                            this.delegate.shouldInterceptFormSubmission(r, o) &&
                            (s.preventDefault(),
                            s.stopImmediatePropagation(),
                            this.delegate.formSubmissionIntercepted(r, o));
                    }
                }),
                    (this.delegate = e),
                    (this.element = t);
            }
            start() {
                this.element.addEventListener("submit", this.submitBubbled);
            }
            stop() {
                this.element.removeEventListener("submit", this.submitBubbled);
            }
        },
        tt = class {
            constructor(e, t) {
                (this.resolveRenderPromise = (s) => {}),
                    (this.resolveInterceptionPromise = (s) => {}),
                    (this.delegate = e),
                    (this.element = t);
            }
            scrollToAnchor(e) {
                let t = this.snapshot.getElementForAnchor(e);
                t
                    ? (this.scrollToElement(t), this.focusElement(t))
                    : this.scrollToPosition({ x: 0, y: 0 });
            }
            scrollToAnchorFromLocation(e) {
                this.scrollToAnchor(W(e));
            }
            scrollToElement(e) {
                e.scrollIntoView();
            }
            focusElement(e) {
                e instanceof HTMLElement &&
                    (e.hasAttribute("tabindex")
                        ? e.focus()
                        : (e.setAttribute("tabindex", "-1"),
                          e.focus(),
                          e.removeAttribute("tabindex")));
            }
            scrollToPosition({ x: e, y: t }) {
                this.scrollRoot.scrollTo(e, t);
            }
            scrollToTop() {
                this.scrollToPosition({ x: 0, y: 0 });
            }
            get scrollRoot() {
                return window;
            }
            async render(e) {
                let { isPreview: t, shouldRender: s, newSnapshot: r } = e;
                if (s)
                    try {
                        (this.renderPromise = new Promise(
                            (p) => (this.resolveRenderPromise = p)
                        )),
                            (this.renderer = e),
                            this.prepareToRenderSnapshot(e);
                        let o = new Promise(
                            (p) => (this.resolveInterceptionPromise = p)
                        );
                        this.delegate.allowsImmediateRender(
                            r,
                            this.resolveInterceptionPromise
                        ) || (await o),
                            await this.renderSnapshot(e),
                            this.delegate.viewRenderedSnapshot(r, t),
                            this.finishRenderingSnapshot(e);
                    } finally {
                        delete this.renderer,
                            this.resolveRenderPromise(void 0),
                            delete this.renderPromise;
                    }
                else this.invalidate();
            }
            invalidate() {
                this.delegate.viewInvalidated();
            }
            prepareToRenderSnapshot(e) {
                this.markAsPreview(e.isPreview), e.prepareToRender();
            }
            markAsPreview(e) {
                e
                    ? this.element.setAttribute("data-turbo-preview", "")
                    : this.element.removeAttribute("data-turbo-preview");
            }
            async renderSnapshot(e) {
                await e.render();
            }
            finishRenderingSnapshot(e) {
                e.finishRendering();
            }
        },
        jt = class extends tt {
            invalidate() {
                this.element.innerHTML = "";
            }
            get snapshot() {
                return new re(this.element);
            }
        },
        it = class {
            constructor(e, t) {
                (this.clickBubbled = (s) => {
                    this.respondsToEventTarget(s.target)
                        ? (this.clickEvent = s)
                        : delete this.clickEvent;
                }),
                    (this.linkClicked = (s) => {
                        this.clickEvent &&
                            this.respondsToEventTarget(s.target) &&
                            s.target instanceof Element &&
                            this.delegate.shouldInterceptLinkClick(
                                s.target,
                                s.detail.url
                            ) &&
                            (this.clickEvent.preventDefault(),
                            s.preventDefault(),
                            this.delegate.linkClickIntercepted(
                                s.target,
                                s.detail.url
                            )),
                            delete this.clickEvent;
                    }),
                    (this.willVisit = () => {
                        delete this.clickEvent;
                    }),
                    (this.delegate = e),
                    (this.element = t);
            }
            start() {
                this.element.addEventListener("click", this.clickBubbled),
                    document.addEventListener("turbo:click", this.linkClicked),
                    document.addEventListener(
                        "turbo:before-visit",
                        this.willVisit
                    );
            }
            stop() {
                this.element.removeEventListener("click", this.clickBubbled),
                    document.removeEventListener(
                        "turbo:click",
                        this.linkClicked
                    ),
                    document.removeEventListener(
                        "turbo:before-visit",
                        this.willVisit
                    );
            }
            respondsToEventTarget(e) {
                let t =
                    e instanceof Element
                        ? e
                        : e instanceof Node
                        ? e.parentElement
                        : null;
                return t && t.closest("turbo-frame, html") == this.element;
            }
        },
        $t = class {
            constructor(e) {
                this.permanentElementMap = e;
            }
            static preservingPermanentElements(e, t) {
                let s = new this(e);
                s.enter(), t(), s.leave();
            }
            enter() {
                for (let e in this.permanentElementMap) {
                    let [, t] = this.permanentElementMap[e];
                    this.replaceNewPermanentElementWithPlaceholder(t);
                }
            }
            leave() {
                for (let e in this.permanentElementMap) {
                    let [t] = this.permanentElementMap[e];
                    this.replaceCurrentPermanentElementWithClone(t),
                        this.replacePlaceholderWithPermanentElement(t);
                }
            }
            replaceNewPermanentElementWithPlaceholder(e) {
                let t = or(e);
                e.replaceWith(t);
            }
            replaceCurrentPermanentElementWithClone(e) {
                let t = e.cloneNode(!0);
                e.replaceWith(t);
            }
            replacePlaceholderWithPermanentElement(e) {
                let t = this.getPlaceholderById(e.id);
                t == null || t.replaceWith(e);
            }
            getPlaceholderById(e) {
                return this.placeholders.find((t) => t.content == e);
            }
            get placeholders() {
                return [
                    ...document.querySelectorAll(
                        "meta[name=turbo-permanent-placeholder][content]"
                    ),
                ];
            }
        };
    function or(i) {
        let e = document.createElement("meta");
        return (
            e.setAttribute("name", "turbo-permanent-placeholder"),
            e.setAttribute("content", i.id),
            e
        );
    }
    var Te = class {
        constructor(e, t, s, r = !0) {
            (this.currentSnapshot = e),
                (this.newSnapshot = t),
                (this.isPreview = s),
                (this.willRender = r),
                (this.promise = new Promise(
                    (o, h) =>
                        (this.resolvingFunctions = { resolve: o, reject: h })
                ));
        }
        get shouldRender() {
            return !0;
        }
        prepareToRender() {}
        finishRendering() {
            this.resolvingFunctions &&
                (this.resolvingFunctions.resolve(),
                delete this.resolvingFunctions);
        }
        createScriptElement(e) {
            if (e.getAttribute("data-turbo-eval") == "false") return e;
            {
                let t = document.createElement("script");
                return (
                    this.cspNonce && (t.nonce = this.cspNonce),
                    (t.textContent = e.textContent),
                    (t.async = !1),
                    ar(t, e),
                    t
                );
            }
        }
        preservingPermanentElements(e) {
            $t.preservingPermanentElements(this.permanentElementMap, e);
        }
        focusFirstAutofocusableElement() {
            let e = this.connectedSnapshot.firstAutofocusableElement;
            cr(e) && e.focus();
        }
        get connectedSnapshot() {
            return this.newSnapshot.isConnected
                ? this.newSnapshot
                : this.currentSnapshot;
        }
        get currentElement() {
            return this.currentSnapshot.element;
        }
        get newElement() {
            return this.newSnapshot.element;
        }
        get permanentElementMap() {
            return this.currentSnapshot.getPermanentElementMapForSnapshot(
                this.newSnapshot
            );
        }
        get cspNonce() {
            var e;
            return (e = document.head.querySelector(
                'meta[name="csp-nonce"]'
            )) === null || e === void 0
                ? void 0
                : e.getAttribute("content");
        }
    };
    function ar(i, e) {
        for (let { name: t, value: s } of [...e.attributes])
            i.setAttribute(t, s);
    }
    function cr(i) {
        return i && typeof i.focus == "function";
    }
    var Vt = class extends Te {
        get shouldRender() {
            return !0;
        }
        async render() {
            await Ee(),
                this.preservingPermanentElements(() => {
                    this.loadFrameElement();
                }),
                this.scrollFrameIntoView(),
                await Ee(),
                this.focusFirstAutofocusableElement(),
                await Ee(),
                this.activateScriptElements();
        }
        loadFrameElement() {
            var e;
            let t = document.createRange();
            t.selectNodeContents(this.currentElement), t.deleteContents();
            let s = this.newElement,
                r =
                    (e = s.ownerDocument) === null || e === void 0
                        ? void 0
                        : e.createRange();
            r &&
                (r.selectNodeContents(s),
                this.currentElement.appendChild(r.extractContents()));
        }
        scrollFrameIntoView() {
            if (this.currentElement.autoscroll || this.newElement.autoscroll) {
                let e = this.currentElement.firstElementChild,
                    t = lr(
                        this.currentElement.getAttribute(
                            "data-autoscroll-block"
                        ),
                        "end"
                    );
                if (e) return e.scrollIntoView({ block: t }), !0;
            }
            return !1;
        }
        activateScriptElements() {
            for (let e of this.newScriptElements) {
                let t = this.createScriptElement(e);
                e.replaceWith(t);
            }
        }
        get newScriptElements() {
            return this.currentElement.querySelectorAll("script");
        }
    };
    function lr(i, e) {
        return i == "end" || i == "start" || i == "center" || i == "nearest"
            ? i
            : e;
    }
    var F = class {
        constructor() {
            (this.hiding = !1),
                (this.value = 0),
                (this.visible = !1),
                (this.trickle = () => {
                    this.setValue(this.value + Math.random() / 100);
                }),
                (this.stylesheetElement = this.createStylesheetElement()),
                (this.progressElement = this.createProgressElement()),
                this.installStylesheetElement(),
                this.setValue(0);
        }
        static get defaultCSS() {
            return qt`
      .turbo-progress-bar {
        position: fixed;
        display: block;
        top: 0;
        left: 0;
        height: 3px;
        background: #0076ff;
        z-index: 9999;
        transition:
          width ${F.animationDuration}ms ease-out,
          opacity ${F.animationDuration / 2}ms ${
                F.animationDuration / 2
            }ms ease-in;
        transform: translate3d(0, 0, 0);
      }
    `;
        }
        show() {
            this.visible ||
                ((this.visible = !0),
                this.installProgressElement(),
                this.startTrickling());
        }
        hide() {
            this.visible &&
                !this.hiding &&
                ((this.hiding = !0),
                this.fadeProgressElement(() => {
                    this.uninstallProgressElement(),
                        this.stopTrickling(),
                        (this.visible = !1),
                        (this.hiding = !1);
                }));
        }
        setValue(e) {
            (this.value = e), this.refresh();
        }
        installStylesheetElement() {
            document.head.insertBefore(
                this.stylesheetElement,
                document.head.firstChild
            );
        }
        installProgressElement() {
            (this.progressElement.style.width = "0"),
                (this.progressElement.style.opacity = "1"),
                document.documentElement.insertBefore(
                    this.progressElement,
                    document.body
                ),
                this.refresh();
        }
        fadeProgressElement(e) {
            (this.progressElement.style.opacity = "0"),
                setTimeout(e, F.animationDuration * 1.5);
        }
        uninstallProgressElement() {
            this.progressElement.parentNode &&
                document.documentElement.removeChild(this.progressElement);
        }
        startTrickling() {
            this.trickleInterval ||
                (this.trickleInterval = window.setInterval(
                    this.trickle,
                    F.animationDuration
                ));
        }
        stopTrickling() {
            window.clearInterval(this.trickleInterval),
                delete this.trickleInterval;
        }
        refresh() {
            requestAnimationFrame(() => {
                this.progressElement.style.width = `${10 + this.value * 90}%`;
            });
        }
        createStylesheetElement() {
            let e = document.createElement("style");
            return (e.type = "text/css"), (e.textContent = F.defaultCSS), e;
        }
        createProgressElement() {
            let e = document.createElement("div");
            return (e.className = "turbo-progress-bar"), e;
        }
    };
    F.animationDuration = 300;
    var _t = class extends re {
        constructor() {
            super(...arguments);
            this.detailsByOuterHTML = this.children
                .filter((e) => !fr(e))
                .map((e) => gr(e))
                .reduce((e, t) => {
                    let { outerHTML: s } = t,
                        r =
                            s in e
                                ? e[s]
                                : { type: hr(t), tracked: ur(t), elements: [] };
                    return Object.assign(Object.assign({}, e), {
                        [s]: Object.assign(Object.assign({}, r), {
                            elements: [...r.elements, t],
                        }),
                    });
                }, {});
        }
        get trackedElementSignature() {
            return Object.keys(this.detailsByOuterHTML)
                .filter((e) => this.detailsByOuterHTML[e].tracked)
                .join("");
        }
        getScriptElementsNotInSnapshot(e) {
            return this.getElementsMatchingTypeNotInSnapshot("script", e);
        }
        getStylesheetElementsNotInSnapshot(e) {
            return this.getElementsMatchingTypeNotInSnapshot("stylesheet", e);
        }
        getElementsMatchingTypeNotInSnapshot(e, t) {
            return Object.keys(this.detailsByOuterHTML)
                .filter((s) => !(s in t.detailsByOuterHTML))
                .map((s) => this.detailsByOuterHTML[s])
                .filter(({ type: s }) => s == e)
                .map(({ elements: [s] }) => s);
        }
        get provisionalElements() {
            return Object.keys(this.detailsByOuterHTML).reduce((e, t) => {
                let {
                    type: s,
                    tracked: r,
                    elements: o,
                } = this.detailsByOuterHTML[t];
                return s == null && !r
                    ? [...e, ...o]
                    : o.length > 1
                    ? [...e, ...o.slice(1)]
                    : e;
            }, []);
        }
        getMetaValue(e) {
            let t = this.findMetaElementByName(e);
            return t ? t.getAttribute("content") : null;
        }
        findMetaElementByName(e) {
            return Object.keys(this.detailsByOuterHTML).reduce((t, s) => {
                let {
                    elements: [r],
                } = this.detailsByOuterHTML[s];
                return mr(r, e) ? r : t;
            }, void 0);
        }
    };
    function hr(i) {
        if (dr(i)) return "script";
        if (pr(i)) return "stylesheet";
    }
    function ur(i) {
        return i.getAttribute("data-turbo-track") == "reload";
    }
    function dr(i) {
        return i.tagName.toLowerCase() == "script";
    }
    function fr(i) {
        return i.tagName.toLowerCase() == "noscript";
    }
    function pr(i) {
        let e = i.tagName.toLowerCase();
        return (
            e == "style" ||
            (e == "link" && i.getAttribute("rel") == "stylesheet")
        );
    }
    function mr(i, e) {
        return i.tagName.toLowerCase() == "meta" && i.getAttribute("name") == e;
    }
    function gr(i) {
        return i.hasAttribute("nonce") && i.setAttribute("nonce", ""), i;
    }
    var q = class extends re {
            constructor(e, t) {
                super(e);
                this.headSnapshot = t;
            }
            static fromHTMLString(e = "") {
                return this.fromDocument(Bt(e));
            }
            static fromElement(e) {
                return this.fromDocument(e.ownerDocument);
            }
            static fromDocument({ head: e, body: t }) {
                return new this(t, new _t(e));
            }
            clone() {
                return new q(this.element.cloneNode(!0), this.headSnapshot);
            }
            get headElement() {
                return this.headSnapshot.element;
            }
            get rootLocation() {
                var e;
                let t =
                    (e = this.getSetting("root")) !== null && e !== void 0
                        ? e
                        : "/";
                return x(t);
            }
            get cacheControlValue() {
                return this.getSetting("cache-control");
            }
            get isPreviewable() {
                return this.cacheControlValue != "no-preview";
            }
            get isCacheable() {
                return this.cacheControlValue != "no-cache";
            }
            get isVisitable() {
                return this.getSetting("visit-control") != "reload";
            }
            getSetting(e) {
                return this.headSnapshot.getMetaValue(`turbo-${e}`);
            }
        },
        Q;
    (function (i) {
        (i.visitStart = "visitStart"),
            (i.requestStart = "requestStart"),
            (i.requestEnd = "requestEnd"),
            (i.visitEnd = "visitEnd");
    })(Q || (Q = {}));
    var O;
    (function (i) {
        (i.initialized = "initialized"),
            (i.started = "started"),
            (i.canceled = "canceled"),
            (i.failed = "failed"),
            (i.completed = "completed");
    })(O || (O = {}));
    var br = {
            action: "advance",
            historyChanged: !1,
            visitCachedSnapshot: () => {},
            willRender: !0,
        },
        _;
    (function (i) {
        (i[(i.networkFailure = 0)] = "networkFailure"),
            (i[(i.timeoutFailure = -1)] = "timeoutFailure"),
            (i[(i.contentTypeMismatch = -2)] = "contentTypeMismatch");
    })(_ || (_ = {}));
    var Ut = class {
        constructor(e, t, s, r = {}) {
            (this.identifier = se()),
                (this.timingMetrics = {}),
                (this.followedRedirect = !1),
                (this.historyChanged = !1),
                (this.scrolled = !1),
                (this.snapshotCached = !1),
                (this.state = O.initialized),
                (this.delegate = e),
                (this.location = t),
                (this.restorationIdentifier = s || se());
            let {
                action: o,
                historyChanged: h,
                referrer: p,
                snapshotHTML: b,
                response: f,
                visitCachedSnapshot: w,
                willRender: v,
            } = Object.assign(Object.assign({}, br), r);
            (this.action = o),
                (this.historyChanged = h),
                (this.referrer = p),
                (this.snapshotHTML = b),
                (this.response = f),
                (this.isSamePage = this.delegate.locationWithActionIsSamePage(
                    this.location,
                    this.action
                )),
                (this.visitCachedSnapshot = w),
                (this.willRender = v),
                (this.scrolled = !v);
        }
        get adapter() {
            return this.delegate.adapter;
        }
        get view() {
            return this.delegate.view;
        }
        get history() {
            return this.delegate.history;
        }
        get restorationData() {
            return this.history.getRestorationDataForIdentifier(
                this.restorationIdentifier
            );
        }
        get silent() {
            return this.isSamePage;
        }
        start() {
            this.state == O.initialized &&
                (this.recordTimingMetric(Q.visitStart),
                (this.state = O.started),
                this.adapter.visitStarted(this),
                this.delegate.visitStarted(this));
        }
        cancel() {
            this.state == O.started &&
                (this.request && this.request.cancel(),
                this.cancelRender(),
                (this.state = O.canceled));
        }
        complete() {
            this.state == O.started &&
                (this.recordTimingMetric(Q.visitEnd),
                (this.state = O.completed),
                this.adapter.visitCompleted(this),
                this.delegate.visitCompleted(this),
                this.followRedirect());
        }
        fail() {
            this.state == O.started &&
                ((this.state = O.failed), this.adapter.visitFailed(this));
        }
        changeHistory() {
            var e;
            if (!this.historyChanged) {
                let t =
                        this.location.href ===
                        ((e = this.referrer) === null || e === void 0
                            ? void 0
                            : e.href)
                            ? "replace"
                            : this.action,
                    s = this.getHistoryMethodForAction(t);
                this.history.update(
                    s,
                    this.location,
                    this.restorationIdentifier
                ),
                    (this.historyChanged = !0);
            }
        }
        issueRequest() {
            this.hasPreloadedResponse()
                ? this.simulateRequest()
                : this.shouldIssueRequest() &&
                  !this.request &&
                  ((this.request = new Ce(this, R.get, this.location)),
                  this.request.perform());
        }
        simulateRequest() {
            this.response &&
                (this.startRequest(),
                this.recordResponse(),
                this.finishRequest());
        }
        startRequest() {
            this.recordTimingMetric(Q.requestStart),
                this.adapter.visitRequestStarted(this);
        }
        recordResponse(e = this.response) {
            if (((this.response = e), e)) {
                let { statusCode: t } = e;
                Wt(t)
                    ? this.adapter.visitRequestCompleted(this)
                    : this.adapter.visitRequestFailedWithStatusCode(this, t);
            }
        }
        finishRequest() {
            this.recordTimingMetric(Q.requestEnd),
                this.adapter.visitRequestFinished(this);
        }
        loadResponse() {
            if (this.response) {
                let { statusCode: e, responseHTML: t } = this.response;
                this.render(async () => {
                    this.cacheSnapshot(),
                        this.view.renderPromise &&
                            (await this.view.renderPromise),
                        Wt(e) && t != null
                            ? (await this.view.renderPage(
                                  q.fromHTMLString(t),
                                  !1,
                                  this.willRender
                              ),
                              this.adapter.visitRendered(this),
                              this.complete())
                            : (await this.view.renderError(q.fromHTMLString(t)),
                              this.adapter.visitRendered(this),
                              this.fail());
                });
            }
        }
        getCachedSnapshot() {
            let e =
                this.view.getCachedSnapshotForLocation(this.location) ||
                this.getPreloadedSnapshot();
            if (
                e &&
                (!W(this.location) || e.hasAnchor(W(this.location))) &&
                (this.action == "restore" || e.isPreviewable)
            )
                return e;
        }
        getPreloadedSnapshot() {
            if (this.snapshotHTML) return q.fromHTMLString(this.snapshotHTML);
        }
        hasCachedSnapshot() {
            return this.getCachedSnapshot() != null;
        }
        loadCachedSnapshot() {
            let e = this.getCachedSnapshot();
            if (e) {
                let t = this.shouldIssueRequest();
                this.render(async () => {
                    this.cacheSnapshot(),
                        this.isSamePage
                            ? this.adapter.visitRendered(this)
                            : (this.view.renderPromise &&
                                  (await this.view.renderPromise),
                              await this.view.renderPage(e, t, this.willRender),
                              this.adapter.visitRendered(this),
                              t || this.complete());
                });
            }
        }
        followRedirect() {
            var e;
            this.redirectedToLocation &&
                !this.followedRedirect &&
                ((e = this.response) === null || e === void 0
                    ? void 0
                    : e.redirected) &&
                (this.adapter.visitProposedToLocation(
                    this.redirectedToLocation,
                    { action: "replace", response: this.response }
                ),
                (this.followedRedirect = !0));
        }
        goToSamePageAnchor() {
            this.isSamePage &&
                this.render(async () => {
                    this.cacheSnapshot(), this.adapter.visitRendered(this);
                });
        }
        requestStarted() {
            this.startRequest();
        }
        requestPreventedHandlingResponse(e, t) {}
        async requestSucceededWithResponse(e, t) {
            let s = await t.responseHTML,
                { redirected: r, statusCode: o } = t;
            s == null
                ? this.recordResponse({
                      statusCode: _.contentTypeMismatch,
                      redirected: r,
                  })
                : ((this.redirectedToLocation = t.redirected
                      ? t.location
                      : void 0),
                  this.recordResponse({
                      statusCode: o,
                      responseHTML: s,
                      redirected: r,
                  }));
        }
        async requestFailedWithResponse(e, t) {
            let s = await t.responseHTML,
                { redirected: r, statusCode: o } = t;
            s == null
                ? this.recordResponse({
                      statusCode: _.contentTypeMismatch,
                      redirected: r,
                  })
                : this.recordResponse({
                      statusCode: o,
                      responseHTML: s,
                      redirected: r,
                  });
        }
        requestErrored(e, t) {
            this.recordResponse({
                statusCode: _.networkFailure,
                redirected: !1,
            });
        }
        requestFinished() {
            this.finishRequest();
        }
        performScroll() {
            this.scrolled ||
                (this.action == "restore"
                    ? this.scrollToRestoredPosition() ||
                      this.scrollToAnchor() ||
                      this.view.scrollToTop()
                    : this.scrollToAnchor() || this.view.scrollToTop(),
                this.isSamePage &&
                    this.delegate.visitScrolledToSamePageLocation(
                        this.view.lastRenderedLocation,
                        this.location
                    ),
                (this.scrolled = !0));
        }
        scrollToRestoredPosition() {
            let { scrollPosition: e } = this.restorationData;
            if (e) return this.view.scrollToPosition(e), !0;
        }
        scrollToAnchor() {
            let e = W(this.location);
            if (e != null) return this.view.scrollToAnchor(e), !0;
        }
        recordTimingMetric(e) {
            this.timingMetrics[e] = new Date().getTime();
        }
        getTimingMetrics() {
            return Object.assign({}, this.timingMetrics);
        }
        getHistoryMethodForAction(e) {
            switch (e) {
                case "replace":
                    return history.replaceState;
                case "advance":
                case "restore":
                    return history.pushState;
            }
        }
        hasPreloadedResponse() {
            return typeof this.response == "object";
        }
        shouldIssueRequest() {
            return this.isSamePage
                ? !1
                : this.action == "restore"
                ? !this.hasCachedSnapshot()
                : this.willRender;
        }
        cacheSnapshot() {
            this.snapshotCached ||
                (this.view
                    .cacheSnapshot()
                    .then((e) => e && this.visitCachedSnapshot(e)),
                (this.snapshotCached = !0));
        }
        async render(e) {
            this.cancelRender(),
                await new Promise((t) => {
                    this.frame = requestAnimationFrame(() => t());
                }),
                await e(),
                delete this.frame,
                this.performScroll();
        }
        cancelRender() {
            this.frame && (cancelAnimationFrame(this.frame), delete this.frame);
        }
    };
    function Wt(i) {
        return i >= 200 && i < 300;
    }
    var zt = class {
            constructor(e) {
                (this.progressBar = new F()),
                    (this.showProgressBar = () => {
                        this.progressBar.show();
                    }),
                    (this.session = e);
            }
            visitProposedToLocation(e, t) {
                this.navigator.startVisit(e, se(), t);
            }
            visitStarted(e) {
                e.loadCachedSnapshot(),
                    e.issueRequest(),
                    e.changeHistory(),
                    e.goToSamePageAnchor();
            }
            visitRequestStarted(e) {
                this.progressBar.setValue(0),
                    e.hasCachedSnapshot() || e.action != "restore"
                        ? this.showVisitProgressBarAfterDelay()
                        : this.showProgressBar();
            }
            visitRequestCompleted(e) {
                e.loadResponse();
            }
            visitRequestFailedWithStatusCode(e, t) {
                switch (t) {
                    case _.networkFailure:
                    case _.timeoutFailure:
                    case _.contentTypeMismatch:
                        return this.reload();
                    default:
                        return e.loadResponse();
                }
            }
            visitRequestFinished(e) {
                this.progressBar.setValue(1), this.hideVisitProgressBar();
            }
            visitCompleted(e) {}
            pageInvalidated() {
                this.reload();
            }
            visitFailed(e) {}
            visitRendered(e) {}
            formSubmissionStarted(e) {
                this.progressBar.setValue(0),
                    this.showFormProgressBarAfterDelay();
            }
            formSubmissionFinished(e) {
                this.progressBar.setValue(1), this.hideFormProgressBar();
            }
            showVisitProgressBarAfterDelay() {
                this.visitProgressBarTimeout = window.setTimeout(
                    this.showProgressBar,
                    this.session.progressBarDelay
                );
            }
            hideVisitProgressBar() {
                this.progressBar.hide(),
                    this.visitProgressBarTimeout != null &&
                        (window.clearTimeout(this.visitProgressBarTimeout),
                        delete this.visitProgressBarTimeout);
            }
            showFormProgressBarAfterDelay() {
                this.formProgressBarTimeout == null &&
                    (this.formProgressBarTimeout = window.setTimeout(
                        this.showProgressBar,
                        this.session.progressBarDelay
                    ));
            }
            hideFormProgressBar() {
                this.progressBar.hide(),
                    this.formProgressBarTimeout != null &&
                        (window.clearTimeout(this.formProgressBarTimeout),
                        delete this.formProgressBarTimeout);
            }
            reload() {
                window.location.reload();
            }
            get navigator() {
                return this.session.navigator;
            }
        },
        Kt = class {
            constructor() {
                this.started = !1;
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    addEventListener(
                        "turbo:before-cache",
                        this.removeStaleElements,
                        !1
                    ));
            }
            stop() {
                this.started &&
                    ((this.started = !1),
                    removeEventListener(
                        "turbo:before-cache",
                        this.removeStaleElements,
                        !1
                    ));
            }
            removeStaleElements() {
                let e = [
                    ...document.querySelectorAll('[data-turbo-cache="false"]'),
                ];
                for (let t of e) t.remove();
            }
        },
        Xt = class {
            constructor(e) {
                (this.started = !1),
                    (this.submitCaptured = () => {
                        removeEventListener("submit", this.submitBubbled, !1),
                            addEventListener("submit", this.submitBubbled, !1);
                    }),
                    (this.submitBubbled = (t) => {
                        if (!t.defaultPrevented) {
                            let s =
                                    t.target instanceof HTMLFormElement
                                        ? t.target
                                        : void 0,
                                r = t.submitter || void 0;
                            s &&
                                ((r == null
                                    ? void 0
                                    : r.getAttribute("formmethod")) ||
                                    s.getAttribute("method")) != "dialog" &&
                                this.delegate.willSubmitForm(s, r) &&
                                (t.preventDefault(),
                                this.delegate.formSubmitted(s, r));
                        }
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    (addEventListener("submit", this.submitCaptured, !0),
                    (this.started = !0));
            }
            stop() {
                this.started &&
                    (removeEventListener("submit", this.submitCaptured, !0),
                    (this.started = !1));
            }
        },
        Jt = class {
            constructor(e) {
                (this.element = e),
                    (this.linkInterceptor = new it(this, e)),
                    (this.formInterceptor = new et(this, e));
            }
            start() {
                this.linkInterceptor.start(), this.formInterceptor.start();
            }
            stop() {
                this.linkInterceptor.stop(), this.formInterceptor.stop();
            }
            shouldInterceptLinkClick(e, t) {
                return this.shouldRedirect(e);
            }
            linkClickIntercepted(e, t) {
                let s = this.findFrameElement(e);
                s && s.delegate.linkClickIntercepted(e, t);
            }
            shouldInterceptFormSubmission(e, t) {
                return this.shouldSubmit(e, t);
            }
            formSubmissionIntercepted(e, t) {
                let s = this.findFrameElement(e, t);
                s &&
                    (s.removeAttribute("reloadable"),
                    s.delegate.formSubmissionIntercepted(e, t));
            }
            shouldSubmit(e, t) {
                var s;
                let r = Je(e, t),
                    o = this.element.ownerDocument.querySelector(
                        'meta[name="turbo-root"]'
                    ),
                    h = x(
                        (s = o == null ? void 0 : o.content) !== null &&
                            s !== void 0
                            ? s
                            : "/"
                    );
                return this.shouldRedirect(e, t) && ie(r, h);
            }
            shouldRedirect(e, t) {
                let s = this.findFrameElement(e, t);
                return s ? s != e.closest("turbo-frame") : !1;
            }
            findFrameElement(e, t) {
                let s =
                    (t == null ? void 0 : t.getAttribute("data-turbo-frame")) ||
                    e.getAttribute("data-turbo-frame");
                if (s && s != "_top") {
                    let r = this.element.querySelector(`#${s}:not([disabled])`);
                    if (r instanceof B) return r;
                }
            }
        },
        Gt = class {
            constructor(e) {
                (this.restorationIdentifier = se()),
                    (this.restorationData = {}),
                    (this.started = !1),
                    (this.pageLoaded = !1),
                    (this.onPopState = (t) => {
                        if (this.shouldHandlePopState()) {
                            let { turbo: s } = t.state || {};
                            if (s) {
                                this.location = new URL(window.location.href);
                                let { restorationIdentifier: r } = s;
                                (this.restorationIdentifier = r),
                                    this.delegate.historyPoppedToLocationWithRestorationIdentifier(
                                        this.location,
                                        r
                                    );
                            }
                        }
                    }),
                    (this.onPageLoad = async (t) => {
                        await Ys(), (this.pageLoaded = !0);
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    (addEventListener("popstate", this.onPopState, !1),
                    addEventListener("load", this.onPageLoad, !1),
                    (this.started = !0),
                    this.replace(new URL(window.location.href)));
            }
            stop() {
                this.started &&
                    (removeEventListener("popstate", this.onPopState, !1),
                    removeEventListener("load", this.onPageLoad, !1),
                    (this.started = !1));
            }
            push(e, t) {
                this.update(history.pushState, e, t);
            }
            replace(e, t) {
                this.update(history.replaceState, e, t);
            }
            update(e, t, s = se()) {
                let r = { turbo: { restorationIdentifier: s } };
                e.call(history, r, "", t.href),
                    (this.location = t),
                    (this.restorationIdentifier = s);
            }
            getRestorationDataForIdentifier(e) {
                return this.restorationData[e] || {};
            }
            updateRestorationData(e) {
                let { restorationIdentifier: t } = this,
                    s = this.restorationData[t];
                this.restorationData[t] = Object.assign(
                    Object.assign({}, s),
                    e
                );
            }
            assumeControlOfScrollRestoration() {
                var e;
                this.previousScrollRestoration ||
                    ((this.previousScrollRestoration =
                        (e = history.scrollRestoration) !== null && e !== void 0
                            ? e
                            : "auto"),
                    (history.scrollRestoration = "manual"));
            }
            relinquishControlOfScrollRestoration() {
                this.previousScrollRestoration &&
                    ((history.scrollRestoration =
                        this.previousScrollRestoration),
                    delete this.previousScrollRestoration);
            }
            shouldHandlePopState() {
                return this.pageIsLoaded();
            }
            pageIsLoaded() {
                return this.pageLoaded || document.readyState == "complete";
            }
        },
        Qt = class {
            constructor(e) {
                (this.started = !1),
                    (this.clickCaptured = () => {
                        removeEventListener("click", this.clickBubbled, !1),
                            addEventListener("click", this.clickBubbled, !1);
                    }),
                    (this.clickBubbled = (t) => {
                        if (this.clickEventIsSignificant(t)) {
                            let s =
                                    (t.composedPath && t.composedPath()[0]) ||
                                    t.target,
                                r = this.findLinkFromClickTarget(s);
                            if (r) {
                                let o = this.getLocationForLink(r);
                                this.delegate.willFollowLinkToLocation(r, o) &&
                                    (t.preventDefault(),
                                    this.delegate.followedLinkToLocation(r, o));
                            }
                        }
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    (addEventListener("click", this.clickCaptured, !0),
                    (this.started = !0));
            }
            stop() {
                this.started &&
                    (removeEventListener("click", this.clickCaptured, !0),
                    (this.started = !1));
            }
            clickEventIsSignificant(e) {
                return !(
                    (e.target && e.target.isContentEditable) ||
                    e.defaultPrevented ||
                    e.which > 1 ||
                    e.altKey ||
                    e.ctrlKey ||
                    e.metaKey ||
                    e.shiftKey
                );
            }
            findLinkFromClickTarget(e) {
                if (e instanceof Element)
                    return e.closest(
                        "a[href]:not([target^=_]):not([download])"
                    );
            }
            getLocationForLink(e) {
                return x(e.getAttribute("href") || "");
            }
        };
    function st(i) {
        return i == "advance" || i == "replace" || i == "restore";
    }
    var Yt = class {
            constructor(e) {
                this.delegate = e;
            }
            proposeVisit(e, t = {}) {
                this.delegate.allowsVisitingLocationWithAction(e, t.action) &&
                    (ie(e, this.view.snapshot.rootLocation)
                        ? this.delegate.visitProposedToLocation(e, t)
                        : (window.location.href = e.toString()));
            }
            startVisit(e, t, s = {}) {
                this.stop(),
                    (this.currentVisit = new Ut(
                        this,
                        x(e),
                        t,
                        Object.assign({ referrer: this.location }, s)
                    )),
                    this.currentVisit.start();
            }
            submitForm(e, t) {
                this.stop(),
                    (this.formSubmission = new G(this, e, t, !0)),
                    this.formSubmission.start();
            }
            stop() {
                this.formSubmission &&
                    (this.formSubmission.stop(), delete this.formSubmission),
                    this.currentVisit &&
                        (this.currentVisit.cancel(), delete this.currentVisit);
            }
            get adapter() {
                return this.delegate.adapter;
            }
            get view() {
                return this.delegate.view;
            }
            get history() {
                return this.delegate.history;
            }
            formSubmissionStarted(e) {
                typeof this.adapter.formSubmissionStarted == "function" &&
                    this.adapter.formSubmissionStarted(e);
            }
            async formSubmissionSucceededWithResponse(e, t) {
                if (e == this.formSubmission) {
                    let s = await t.responseHTML;
                    if (s) {
                        e.method != R.get && this.view.clearSnapshotCache();
                        let { statusCode: r, redirected: o } = t,
                            p = {
                                action: this.getActionForFormSubmission(e),
                                response: {
                                    statusCode: r,
                                    responseHTML: s,
                                    redirected: o,
                                },
                            };
                        this.proposeVisit(t.location, p);
                    }
                }
            }
            async formSubmissionFailedWithResponse(e, t) {
                let s = await t.responseHTML;
                if (s) {
                    let r = q.fromHTMLString(s);
                    t.serverError
                        ? await this.view.renderError(r)
                        : await this.view.renderPage(r),
                        this.view.scrollToTop(),
                        this.view.clearSnapshotCache();
                }
            }
            formSubmissionErrored(e, t) {
                console.error(t);
            }
            formSubmissionFinished(e) {
                typeof this.adapter.formSubmissionFinished == "function" &&
                    this.adapter.formSubmissionFinished(e);
            }
            visitStarted(e) {
                this.delegate.visitStarted(e);
            }
            visitCompleted(e) {
                this.delegate.visitCompleted(e);
            }
            locationWithActionIsSamePage(e, t) {
                let s = W(e),
                    r = W(this.view.lastRenderedLocation),
                    o = t === "restore" && typeof s == "undefined";
                return (
                    t !== "replace" &&
                    Ge(e) === Ge(this.view.lastRenderedLocation) &&
                    (o || (s != null && s !== r))
                );
            }
            visitScrolledToSamePageLocation(e, t) {
                this.delegate.visitScrolledToSamePageLocation(e, t);
            }
            get location() {
                return this.history.location;
            }
            get restorationIdentifier() {
                return this.history.restorationIdentifier;
            }
            getActionForFormSubmission(e) {
                let { formElement: t, submitter: s } = e,
                    r = Se("data-turbo-action", s, t);
                return st(r) ? r : "advance";
            }
        },
        N;
    (function (i) {
        (i[(i.initial = 0)] = "initial"),
            (i[(i.loading = 1)] = "loading"),
            (i[(i.interactive = 2)] = "interactive"),
            (i[(i.complete = 3)] = "complete");
    })(N || (N = {}));
    var Zt = class {
            constructor(e) {
                (this.stage = N.initial),
                    (this.started = !1),
                    (this.interpretReadyState = () => {
                        let { readyState: t } = this;
                        t == "interactive"
                            ? this.pageIsInteractive()
                            : t == "complete" && this.pageIsComplete();
                    }),
                    (this.pageWillUnload = () => {
                        this.delegate.pageWillUnload();
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    (this.stage == N.initial && (this.stage = N.loading),
                    document.addEventListener(
                        "readystatechange",
                        this.interpretReadyState,
                        !1
                    ),
                    addEventListener("pagehide", this.pageWillUnload, !1),
                    (this.started = !0));
            }
            stop() {
                this.started &&
                    (document.removeEventListener(
                        "readystatechange",
                        this.interpretReadyState,
                        !1
                    ),
                    removeEventListener("pagehide", this.pageWillUnload, !1),
                    (this.started = !1));
            }
            pageIsInteractive() {
                this.stage == N.loading &&
                    ((this.stage = N.interactive),
                    this.delegate.pageBecameInteractive());
            }
            pageIsComplete() {
                this.pageIsInteractive(),
                    this.stage == N.interactive &&
                        ((this.stage = N.complete), this.delegate.pageLoaded());
            }
            get readyState() {
                return document.readyState;
            }
        },
        ei = class {
            constructor(e) {
                (this.started = !1),
                    (this.onScroll = () => {
                        this.updatePosition({
                            x: window.pageXOffset,
                            y: window.pageYOffset,
                        });
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    (addEventListener("scroll", this.onScroll, !1),
                    this.onScroll(),
                    (this.started = !0));
            }
            stop() {
                this.started &&
                    (removeEventListener("scroll", this.onScroll, !1),
                    (this.started = !1));
            }
            updatePosition(e) {
                this.delegate.scrollPositionChanged(e);
            }
        },
        ti = class {
            constructor(e) {
                (this.sources = new Set()),
                    (this.started = !1),
                    (this.inspectFetchResponse = (t) => {
                        let s = vr(t);
                        s &&
                            yr(s) &&
                            (t.preventDefault(),
                            this.receiveMessageResponse(s));
                    }),
                    (this.receiveMessageEvent = (t) => {
                        this.started &&
                            typeof t.data == "string" &&
                            this.receiveMessageHTML(t.data);
                    }),
                    (this.delegate = e);
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    addEventListener(
                        "turbo:before-fetch-response",
                        this.inspectFetchResponse,
                        !1
                    ));
            }
            stop() {
                this.started &&
                    ((this.started = !1),
                    removeEventListener(
                        "turbo:before-fetch-response",
                        this.inspectFetchResponse,
                        !1
                    ));
            }
            connectStreamSource(e) {
                this.streamSourceIsConnected(e) ||
                    (this.sources.add(e),
                    e.addEventListener(
                        "message",
                        this.receiveMessageEvent,
                        !1
                    ));
            }
            disconnectStreamSource(e) {
                this.streamSourceIsConnected(e) &&
                    (this.sources.delete(e),
                    e.removeEventListener(
                        "message",
                        this.receiveMessageEvent,
                        !1
                    ));
            }
            streamSourceIsConnected(e) {
                return this.sources.has(e);
            }
            async receiveMessageResponse(e) {
                let t = await e.responseHTML;
                t && this.receiveMessageHTML(t);
            }
            receiveMessageHTML(e) {
                this.delegate.receivedMessageFromStream(new J(e));
            }
        };
    function vr(i) {
        var e;
        let t =
            (e = i.detail) === null || e === void 0 ? void 0 : e.fetchResponse;
        if (t instanceof Qe) return t;
    }
    function yr(i) {
        var e;
        return (
            (e = i.contentType) !== null && e !== void 0 ? e : ""
        ).startsWith(J.contentType);
    }
    var ii = class extends Te {
            async render() {
                this.replaceHeadAndBody(), this.activateScriptElements();
            }
            replaceHeadAndBody() {
                let { documentElement: e, head: t, body: s } = document;
                e.replaceChild(this.newHead, t),
                    e.replaceChild(this.newElement, s);
            }
            activateScriptElements() {
                for (let e of this.scriptElements) {
                    let t = e.parentNode;
                    if (t) {
                        let s = this.createScriptElement(e);
                        t.replaceChild(s, e);
                    }
                }
            }
            get newHead() {
                return this.newSnapshot.headSnapshot.element;
            }
            get scriptElements() {
                return [...document.documentElement.querySelectorAll("script")];
            }
        },
        rt = class extends Te {
            get shouldRender() {
                return (
                    this.newSnapshot.isVisitable &&
                    this.trackedElementsAreIdentical
                );
            }
            prepareToRender() {
                this.mergeHead();
            }
            async render() {
                this.willRender && this.replaceBody();
            }
            finishRendering() {
                super.finishRendering(),
                    this.isPreview || this.focusFirstAutofocusableElement();
            }
            get currentHeadSnapshot() {
                return this.currentSnapshot.headSnapshot;
            }
            get newHeadSnapshot() {
                return this.newSnapshot.headSnapshot;
            }
            get newElement() {
                return this.newSnapshot.element;
            }
            mergeHead() {
                this.copyNewHeadStylesheetElements(),
                    this.copyNewHeadScriptElements(),
                    this.removeCurrentHeadProvisionalElements(),
                    this.copyNewHeadProvisionalElements();
            }
            replaceBody() {
                this.preservingPermanentElements(() => {
                    this.activateNewBody(), this.assignNewBody();
                });
            }
            get trackedElementsAreIdentical() {
                return (
                    this.currentHeadSnapshot.trackedElementSignature ==
                    this.newHeadSnapshot.trackedElementSignature
                );
            }
            copyNewHeadStylesheetElements() {
                for (let e of this.newHeadStylesheetElements)
                    document.head.appendChild(e);
            }
            copyNewHeadScriptElements() {
                for (let e of this.newHeadScriptElements)
                    document.head.appendChild(this.createScriptElement(e));
            }
            removeCurrentHeadProvisionalElements() {
                for (let e of this.currentHeadProvisionalElements)
                    document.head.removeChild(e);
            }
            copyNewHeadProvisionalElements() {
                for (let e of this.newHeadProvisionalElements)
                    document.head.appendChild(e);
            }
            activateNewBody() {
                document.adoptNode(this.newElement),
                    this.activateNewBodyScriptElements();
            }
            activateNewBodyScriptElements() {
                for (let e of this.newBodyScriptElements) {
                    let t = this.createScriptElement(e);
                    e.replaceWith(t);
                }
            }
            assignNewBody() {
                document.body && this.newElement instanceof HTMLBodyElement
                    ? document.body.replaceWith(this.newElement)
                    : document.documentElement.appendChild(this.newElement);
            }
            get newHeadStylesheetElements() {
                return this.newHeadSnapshot.getStylesheetElementsNotInSnapshot(
                    this.currentHeadSnapshot
                );
            }
            get newHeadScriptElements() {
                return this.newHeadSnapshot.getScriptElementsNotInSnapshot(
                    this.currentHeadSnapshot
                );
            }
            get currentHeadProvisionalElements() {
                return this.currentHeadSnapshot.provisionalElements;
            }
            get newHeadProvisionalElements() {
                return this.newHeadSnapshot.provisionalElements;
            }
            get newBodyScriptElements() {
                return this.newElement.querySelectorAll("script");
            }
        },
        si = class {
            constructor(e) {
                (this.keys = []), (this.snapshots = {}), (this.size = e);
            }
            has(e) {
                return we(e) in this.snapshots;
            }
            get(e) {
                if (this.has(e)) {
                    let t = this.read(e);
                    return this.touch(e), t;
                }
            }
            put(e, t) {
                return this.write(e, t), this.touch(e), t;
            }
            clear() {
                this.snapshots = {};
            }
            read(e) {
                return this.snapshots[we(e)];
            }
            write(e, t) {
                this.snapshots[we(e)] = t;
            }
            touch(e) {
                let t = we(e),
                    s = this.keys.indexOf(t);
                s > -1 && this.keys.splice(s, 1),
                    this.keys.unshift(t),
                    this.trim();
            }
            trim() {
                for (let e of this.keys.splice(this.size))
                    delete this.snapshots[e];
            }
        },
        ri = class extends tt {
            constructor() {
                super(...arguments);
                (this.snapshotCache = new si(10)),
                    (this.lastRenderedLocation = new URL(location.href));
            }
            renderPage(e, t = !1, s = !0) {
                let r = new rt(this.snapshot, e, t, s);
                return this.render(r);
            }
            renderError(e) {
                let t = new ii(this.snapshot, e, !1);
                return this.render(t);
            }
            clearSnapshotCache() {
                this.snapshotCache.clear();
            }
            async cacheSnapshot() {
                if (this.shouldCacheSnapshot) {
                    this.delegate.viewWillCacheSnapshot();
                    let { snapshot: e, lastRenderedLocation: t } = this;
                    await Qs();
                    let s = e.clone();
                    return this.snapshotCache.put(t, s), s;
                }
            }
            getCachedSnapshotForLocation(e) {
                return this.snapshotCache.get(e);
            }
            get snapshot() {
                return q.fromElement(this.element);
            }
            get shouldCacheSnapshot() {
                return this.snapshot.isCacheable;
            }
        },
        ni = class {
            constructor() {
                (this.navigator = new Yt(this)),
                    (this.history = new Gt(this)),
                    (this.view = new ri(this, document.documentElement)),
                    (this.adapter = new zt(this)),
                    (this.pageObserver = new Zt(this)),
                    (this.cacheObserver = new Kt()),
                    (this.linkClickObserver = new Qt(this)),
                    (this.formSubmitObserver = new Xt(this)),
                    (this.scrollObserver = new ei(this)),
                    (this.streamObserver = new ti(this)),
                    (this.frameRedirector = new Jt(document.documentElement)),
                    (this.drive = !0),
                    (this.enabled = !0),
                    (this.progressBarDelay = 500),
                    (this.started = !1);
            }
            start() {
                this.started ||
                    (this.pageObserver.start(),
                    this.cacheObserver.start(),
                    this.linkClickObserver.start(),
                    this.formSubmitObserver.start(),
                    this.scrollObserver.start(),
                    this.streamObserver.start(),
                    this.frameRedirector.start(),
                    this.history.start(),
                    (this.started = !0),
                    (this.enabled = !0));
            }
            disable() {
                this.enabled = !1;
            }
            stop() {
                this.started &&
                    (this.pageObserver.stop(),
                    this.cacheObserver.stop(),
                    this.linkClickObserver.stop(),
                    this.formSubmitObserver.stop(),
                    this.scrollObserver.stop(),
                    this.streamObserver.stop(),
                    this.frameRedirector.stop(),
                    this.history.stop(),
                    (this.started = !1));
            }
            registerAdapter(e) {
                this.adapter = e;
            }
            visit(e, t = {}) {
                this.navigator.proposeVisit(x(e), t);
            }
            connectStreamSource(e) {
                this.streamObserver.connectStreamSource(e);
            }
            disconnectStreamSource(e) {
                this.streamObserver.disconnectStreamSource(e);
            }
            renderStreamMessage(e) {
                document.documentElement.appendChild(J.wrap(e).fragment);
            }
            clearCache() {
                this.view.clearSnapshotCache();
            }
            setProgressBarDelay(e) {
                this.progressBarDelay = e;
            }
            get location() {
                return this.history.location;
            }
            get restorationIdentifier() {
                return this.history.restorationIdentifier;
            }
            historyPoppedToLocationWithRestorationIdentifier(e, t) {
                this.enabled
                    ? this.navigator.startVisit(e, t, {
                          action: "restore",
                          historyChanged: !0,
                      })
                    : this.adapter.pageInvalidated();
            }
            scrollPositionChanged(e) {
                this.history.updateRestorationData({ scrollPosition: e });
            }
            willFollowLinkToLocation(e, t) {
                return (
                    this.elementDriveEnabled(e) &&
                    ie(t, this.snapshot.rootLocation) &&
                    this.applicationAllowsFollowingLinkToLocation(e, t)
                );
            }
            followedLinkToLocation(e, t) {
                let s = this.getActionForLink(e);
                this.convertLinkWithMethodClickToFormSubmission(e) ||
                    this.visit(t.href, { action: s });
            }
            convertLinkWithMethodClickToFormSubmission(e) {
                let t = e.getAttribute("data-turbo-method");
                if (t) {
                    let s = document.createElement("form");
                    (s.method = t),
                        (s.action = e.getAttribute("href") || "undefined"),
                        (s.hidden = !0),
                        e.hasAttribute("data-turbo-confirm") &&
                            s.setAttribute(
                                "data-turbo-confirm",
                                e.getAttribute("data-turbo-confirm")
                            );
                    let r = this.getTargetFrameForLink(e);
                    return (
                        r
                            ? (s.setAttribute("data-turbo-frame", r),
                              s.addEventListener("turbo:submit-start", () =>
                                  s.remove()
                              ))
                            : s.addEventListener("submit", () => s.remove()),
                        document.body.appendChild(s),
                        P("submit", { cancelable: !0, target: s })
                    );
                } else return !1;
            }
            allowsVisitingLocationWithAction(e, t) {
                return (
                    this.locationWithActionIsSamePage(e, t) ||
                    this.applicationAllowsVisitingLocation(e)
                );
            }
            visitProposedToLocation(e, t) {
                oi(e), this.adapter.visitProposedToLocation(e, t);
            }
            visitStarted(e) {
                oi(e.location),
                    e.silent ||
                        this.notifyApplicationAfterVisitingLocation(
                            e.location,
                            e.action
                        );
            }
            visitCompleted(e) {
                this.notifyApplicationAfterPageLoad(e.getTimingMetrics());
            }
            locationWithActionIsSamePage(e, t) {
                return this.navigator.locationWithActionIsSamePage(e, t);
            }
            visitScrolledToSamePageLocation(e, t) {
                this.notifyApplicationAfterVisitingSamePageLocation(e, t);
            }
            willSubmitForm(e, t) {
                let s = Je(e, t);
                return (
                    this.elementDriveEnabled(e) &&
                    (!t || this.elementDriveEnabled(t)) &&
                    ie(x(s), this.snapshot.rootLocation)
                );
            }
            formSubmitted(e, t) {
                this.navigator.submitForm(e, t);
            }
            pageBecameInteractive() {
                (this.view.lastRenderedLocation = this.location),
                    this.notifyApplicationAfterPageLoad();
            }
            pageLoaded() {
                this.history.assumeControlOfScrollRestoration();
            }
            pageWillUnload() {
                this.history.relinquishControlOfScrollRestoration();
            }
            receivedMessageFromStream(e) {
                this.renderStreamMessage(e);
            }
            viewWillCacheSnapshot() {
                var e;
                ((e = this.navigator.currentVisit) === null || e === void 0
                    ? void 0
                    : e.silent) ||
                    this.notifyApplicationBeforeCachingSnapshot();
            }
            allowsImmediateRender({ element: e }, t) {
                return !this.notifyApplicationBeforeRender(e, t)
                    .defaultPrevented;
            }
            viewRenderedSnapshot(e, t) {
                (this.view.lastRenderedLocation = this.history.location),
                    this.notifyApplicationAfterRender();
            }
            viewInvalidated() {
                this.adapter.pageInvalidated();
            }
            frameLoaded(e) {
                this.notifyApplicationAfterFrameLoad(e);
            }
            frameRendered(e, t) {
                this.notifyApplicationAfterFrameRender(e, t);
            }
            applicationAllowsFollowingLinkToLocation(e, t) {
                return !this.notifyApplicationAfterClickingLinkToLocation(e, t)
                    .defaultPrevented;
            }
            applicationAllowsVisitingLocation(e) {
                return !this.notifyApplicationBeforeVisitingLocation(e)
                    .defaultPrevented;
            }
            notifyApplicationAfterClickingLinkToLocation(e, t) {
                return P("turbo:click", {
                    target: e,
                    detail: { url: t.href },
                    cancelable: !0,
                });
            }
            notifyApplicationBeforeVisitingLocation(e) {
                return P("turbo:before-visit", {
                    detail: { url: e.href },
                    cancelable: !0,
                });
            }
            notifyApplicationAfterVisitingLocation(e, t) {
                return (
                    Ye(document.documentElement),
                    P("turbo:visit", { detail: { url: e.href, action: t } })
                );
            }
            notifyApplicationBeforeCachingSnapshot() {
                return P("turbo:before-cache");
            }
            notifyApplicationBeforeRender(e, t) {
                return P("turbo:before-render", {
                    detail: { newBody: e, resume: t },
                    cancelable: !0,
                });
            }
            notifyApplicationAfterRender() {
                return P("turbo:render");
            }
            notifyApplicationAfterPageLoad(e = {}) {
                return (
                    Ze(document.documentElement),
                    P("turbo:load", {
                        detail: { url: this.location.href, timing: e },
                    })
                );
            }
            notifyApplicationAfterVisitingSamePageLocation(e, t) {
                dispatchEvent(
                    new HashChangeEvent("hashchange", {
                        oldURL: e.toString(),
                        newURL: t.toString(),
                    })
                );
            }
            notifyApplicationAfterFrameLoad(e) {
                return P("turbo:frame-load", { target: e });
            }
            notifyApplicationAfterFrameRender(e, t) {
                return P("turbo:frame-render", {
                    detail: { fetchResponse: e },
                    target: t,
                    cancelable: !0,
                });
            }
            elementDriveEnabled(e) {
                let t = e == null ? void 0 : e.closest("[data-turbo]");
                return this.drive
                    ? t
                        ? t.getAttribute("data-turbo") != "false"
                        : !0
                    : t
                    ? t.getAttribute("data-turbo") == "true"
                    : !1;
            }
            getActionForLink(e) {
                let t = e.getAttribute("data-turbo-action");
                return st(t) ? t : "advance";
            }
            getTargetFrameForLink(e) {
                let t = e.getAttribute("data-turbo-frame");
                if (t) return t;
                {
                    let s = e.closest("turbo-frame");
                    if (s) return s.id;
                }
            }
            get snapshot() {
                return this.view.snapshot;
            }
        };
    function oi(i) {
        Object.defineProperties(i, wr);
    }
    var wr = {
            absoluteURL: {
                get() {
                    return this.toString();
                },
            },
        },
        M = new ni(),
        { navigator: Er } = M;
    function ai() {
        M.start();
    }
    function Sr(i) {
        M.registerAdapter(i);
    }
    function Cr(i, e) {
        M.visit(i, e);
    }
    function nt(i) {
        M.connectStreamSource(i);
    }
    function ot(i) {
        M.disconnectStreamSource(i);
    }
    function Tr(i) {
        M.renderStreamMessage(i);
    }
    function Ar() {
        M.clearCache();
    }
    function kr(i) {
        M.setProgressBarDelay(i);
    }
    function Lr(i) {
        G.confirmMethod = i;
    }
    var xr = Object.freeze({
            __proto__: null,
            navigator: Er,
            session: M,
            PageRenderer: rt,
            PageSnapshot: q,
            start: ai,
            registerAdapter: Sr,
            visit: Cr,
            connectStreamSource: nt,
            disconnectStreamSource: ot,
            renderStreamMessage: Tr,
            clearCache: Ar,
            setProgressBarDelay: kr,
            setConfirmMethod: Lr,
        }),
        ci = class {
            constructor(e) {
                (this.fetchResponseLoaded = (t) => {}),
                    (this.currentFetchRequest = null),
                    (this.resolveVisitPromise = () => {}),
                    (this.connected = !1),
                    (this.hasBeenLoaded = !1),
                    (this.settingSourceURL = !1),
                    (this.element = e),
                    (this.view = new jt(this, this.element)),
                    (this.appearanceObserver = new Nt(this, this.element)),
                    (this.linkInterceptor = new it(this, this.element)),
                    (this.formInterceptor = new et(this, this.element));
            }
            connect() {
                this.connected ||
                    ((this.connected = !0),
                    (this.reloadable = !1),
                    this.loadingStyle == j.lazy &&
                        this.appearanceObserver.start(),
                    this.linkInterceptor.start(),
                    this.formInterceptor.start(),
                    this.sourceURLChanged());
            }
            disconnect() {
                this.connected &&
                    ((this.connected = !1),
                    this.appearanceObserver.stop(),
                    this.linkInterceptor.stop(),
                    this.formInterceptor.stop());
            }
            disabledChanged() {
                this.loadingStyle == j.eager && this.loadSourceURL();
            }
            sourceURLChanged() {
                (this.loadingStyle == j.eager || this.hasBeenLoaded) &&
                    this.loadSourceURL();
            }
            loadingStyleChanged() {
                this.loadingStyle == j.lazy
                    ? this.appearanceObserver.start()
                    : (this.appearanceObserver.stop(), this.loadSourceURL());
            }
            async loadSourceURL() {
                if (
                    !this.settingSourceURL &&
                    this.enabled &&
                    this.isActive &&
                    (this.reloadable || this.sourceURL != this.currentURL)
                ) {
                    let e = this.currentURL;
                    if (((this.currentURL = this.sourceURL), this.sourceURL))
                        try {
                            (this.element.loaded = this.visit(
                                x(this.sourceURL)
                            )),
                                this.appearanceObserver.stop(),
                                await this.element.loaded,
                                (this.hasBeenLoaded = !0);
                        } catch (t) {
                            throw ((this.currentURL = e), t);
                        }
                }
            }
            async loadResponse(e) {
                (e.redirected || (e.succeeded && e.isHTML)) &&
                    (this.sourceURL = e.response.url);
                try {
                    let t = await e.responseHTML;
                    if (t) {
                        let { body: s } = Bt(t),
                            r = new re(
                                await this.extractForeignFrameElement(s)
                            ),
                            o = new Vt(this.view.snapshot, r, !1, !1);
                        this.view.renderPromise &&
                            (await this.view.renderPromise),
                            await this.view.render(o),
                            M.frameRendered(e, this.element),
                            M.frameLoaded(this.element),
                            this.fetchResponseLoaded(e);
                    }
                } catch (t) {
                    console.error(t), this.view.invalidate();
                } finally {
                    this.fetchResponseLoaded = () => {};
                }
            }
            elementAppearedInViewport(e) {
                this.loadSourceURL();
            }
            shouldInterceptLinkClick(e, t) {
                return e.hasAttribute("data-turbo-method")
                    ? !1
                    : this.shouldInterceptNavigation(e);
            }
            linkClickIntercepted(e, t) {
                (this.reloadable = !0), this.navigateFrame(e, t);
            }
            shouldInterceptFormSubmission(e, t) {
                return this.shouldInterceptNavigation(e, t);
            }
            formSubmissionIntercepted(e, t) {
                this.formSubmission && this.formSubmission.stop(),
                    (this.reloadable = !1),
                    (this.formSubmission = new G(this, e, t));
                let { fetchRequest: s } = this.formSubmission;
                this.prepareHeadersForRequest(s.headers, s),
                    this.formSubmission.start();
            }
            prepareHeadersForRequest(e, t) {
                e["Turbo-Frame"] = this.id;
            }
            requestStarted(e) {
                Ye(this.element);
            }
            requestPreventedHandlingResponse(e, t) {
                this.resolveVisitPromise();
            }
            async requestSucceededWithResponse(e, t) {
                await this.loadResponse(t), this.resolveVisitPromise();
            }
            requestFailedWithResponse(e, t) {
                console.error(t), this.resolveVisitPromise();
            }
            requestErrored(e, t) {
                console.error(t), this.resolveVisitPromise();
            }
            requestFinished(e) {
                Ze(this.element);
            }
            formSubmissionStarted({ formElement: e }) {
                Ye(e, this.findFrameElement(e));
            }
            formSubmissionSucceededWithResponse(e, t) {
                let s = this.findFrameElement(e.formElement, e.submitter);
                this.proposeVisitIfNavigatedWithAction(
                    s,
                    e.formElement,
                    e.submitter
                ),
                    s.delegate.loadResponse(t);
            }
            formSubmissionFailedWithResponse(e, t) {
                this.element.delegate.loadResponse(t);
            }
            formSubmissionErrored(e, t) {
                console.error(t);
            }
            formSubmissionFinished({ formElement: e }) {
                Ze(e, this.findFrameElement(e));
            }
            allowsImmediateRender(e, t) {
                return !0;
            }
            viewRenderedSnapshot(e, t) {}
            viewInvalidated() {}
            async visit(e) {
                var t;
                let s = new Ce(
                    this,
                    R.get,
                    e,
                    new URLSearchParams(),
                    this.element
                );
                return (
                    (t = this.currentFetchRequest) === null ||
                        t === void 0 ||
                        t.cancel(),
                    (this.currentFetchRequest = s),
                    new Promise((r) => {
                        (this.resolveVisitPromise = () => {
                            (this.resolveVisitPromise = () => {}),
                                (this.currentFetchRequest = null),
                                r();
                        }),
                            s.perform();
                    })
                );
            }
            navigateFrame(e, t, s) {
                let r = this.findFrameElement(e, s);
                this.proposeVisitIfNavigatedWithAction(r, e, s),
                    r.setAttribute("reloadable", ""),
                    (r.src = t);
            }
            proposeVisitIfNavigatedWithAction(e, t, s) {
                let r = Se("data-turbo-action", s, t, e);
                if (st(r)) {
                    let { visitCachedSnapshot: o } = new li(e);
                    e.delegate.fetchResponseLoaded = (h) => {
                        if (e.src) {
                            let { statusCode: p, redirected: b } = h,
                                f = e.ownerDocument.documentElement.outerHTML,
                                w = {
                                    statusCode: p,
                                    redirected: b,
                                    responseHTML: f,
                                };
                            M.visit(e.src, {
                                action: r,
                                response: w,
                                visitCachedSnapshot: o,
                                willRender: !1,
                            });
                        }
                    };
                }
            }
            findFrameElement(e, t) {
                var s;
                let r =
                    Se("data-turbo-frame", t, e) ||
                    this.element.getAttribute("target");
                return (s = hi(r)) !== null && s !== void 0 ? s : this.element;
            }
            async extractForeignFrameElement(e) {
                let t,
                    s = CSS.escape(this.id);
                try {
                    if (
                        (t = ui(
                            e.querySelector(`turbo-frame#${s}`),
                            this.currentURL
                        ))
                    )
                        return t;
                    if (
                        (t = ui(
                            e.querySelector(`turbo-frame[src][recurse~=${s}]`),
                            this.currentURL
                        ))
                    )
                        return (
                            await t.loaded,
                            await this.extractForeignFrameElement(t)
                        );
                    console.error(
                        `Response has no matching <turbo-frame id="${s}"> element`
                    );
                } catch (r) {
                    console.error(r);
                }
                return new B();
            }
            formActionIsVisitable(e, t) {
                let s = Je(e, t);
                return ie(x(s), this.rootLocation);
            }
            shouldInterceptNavigation(e, t) {
                let s =
                    Se("data-turbo-frame", t, e) ||
                    this.element.getAttribute("target");
                if (
                    (e instanceof HTMLFormElement &&
                        !this.formActionIsVisitable(e, t)) ||
                    !this.enabled ||
                    s == "_top"
                )
                    return !1;
                if (s) {
                    let r = hi(s);
                    if (r) return !r.disabled;
                }
                return !(
                    !M.elementDriveEnabled(e) ||
                    (t && !M.elementDriveEnabled(t))
                );
            }
            get id() {
                return this.element.id;
            }
            get enabled() {
                return !this.element.disabled;
            }
            get sourceURL() {
                if (this.element.src) return this.element.src;
            }
            get reloadable() {
                return this.findFrameElement(this.element).hasAttribute(
                    "reloadable"
                );
            }
            set reloadable(e) {
                let t = this.findFrameElement(this.element);
                e
                    ? t.setAttribute("reloadable", "")
                    : t.removeAttribute("reloadable");
            }
            set sourceURL(e) {
                (this.settingSourceURL = !0),
                    (this.element.src = e ?? null),
                    (this.currentURL = this.element.src),
                    (this.settingSourceURL = !1);
            }
            get loadingStyle() {
                return this.element.loading;
            }
            get isLoading() {
                return (
                    this.formSubmission !== void 0 ||
                    this.resolveVisitPromise() !== void 0
                );
            }
            get isActive() {
                return this.element.isActive && this.connected;
            }
            get rootLocation() {
                var e;
                let t = this.element.ownerDocument.querySelector(
                        'meta[name="turbo-root"]'
                    ),
                    s =
                        (e = t == null ? void 0 : t.content) !== null &&
                        e !== void 0
                            ? e
                            : "/";
                return x(s);
            }
        },
        li = class {
            constructor(e) {
                (this.visitCachedSnapshot = ({ element: t }) => {
                    var s;
                    let { id: r, clone: o } = this;
                    (s = t.querySelector("#" + r)) === null ||
                        s === void 0 ||
                        s.replaceWith(o);
                }),
                    (this.clone = e.cloneNode(!0)),
                    (this.id = e.id);
            }
        };
    function hi(i) {
        if (i != null) {
            let e = document.getElementById(i);
            if (e instanceof B) return e;
        }
    }
    function ui(i, e) {
        if (i) {
            let t = i.getAttribute("src");
            if (t != null && e != null && zs(t, e))
                throw new Error(
                    `Matching <turbo-frame id="${i.id}"> element has a source URL which references itself`
                );
            if (
                (i.ownerDocument !== document &&
                    (i = document.importNode(i, !0)),
                i instanceof B)
            )
                return i.connectedCallback(), i.disconnectedCallback(), i;
        }
    }
    var Rr = {
            after() {
                this.targetElements.forEach((i) => {
                    var e;
                    return (e = i.parentElement) === null || e === void 0
                        ? void 0
                        : e.insertBefore(this.templateContent, i.nextSibling);
                });
            },
            append() {
                this.removeDuplicateTargetChildren(),
                    this.targetElements.forEach((i) =>
                        i.append(this.templateContent)
                    );
            },
            before() {
                this.targetElements.forEach((i) => {
                    var e;
                    return (e = i.parentElement) === null || e === void 0
                        ? void 0
                        : e.insertBefore(this.templateContent, i);
                });
            },
            prepend() {
                this.removeDuplicateTargetChildren(),
                    this.targetElements.forEach((i) =>
                        i.prepend(this.templateContent)
                    );
            },
            remove() {
                this.targetElements.forEach((i) => i.remove());
            },
            replace() {
                this.targetElements.forEach((i) =>
                    i.replaceWith(this.templateContent)
                );
            },
            update() {
                this.targetElements.forEach((i) => {
                    (i.innerHTML = ""), i.append(this.templateContent);
                });
            },
        },
        di = class extends HTMLElement {
            async connectedCallback() {
                try {
                    await this.render();
                } catch (e) {
                    console.error(e);
                } finally {
                    this.disconnect();
                }
            }
            async render() {
                var e;
                return (e = this.renderPromise) !== null && e !== void 0
                    ? e
                    : (this.renderPromise = (async () => {
                          this.dispatchEvent(this.beforeRenderEvent) &&
                              (await Ee(), this.performAction());
                      })());
            }
            disconnect() {
                try {
                    this.remove();
                } catch {}
            }
            removeDuplicateTargetChildren() {
                this.duplicateChildren.forEach((e) => e.remove());
            }
            get duplicateChildren() {
                var e;
                let t = this.targetElements
                        .flatMap((r) => [...r.children])
                        .filter((r) => !!r.id),
                    s = [
                        ...((e = this.templateContent) === null || e === void 0
                            ? void 0
                            : e.children),
                    ]
                        .filter((r) => !!r.id)
                        .map((r) => r.id);
                return t.filter((r) => s.includes(r.id));
            }
            get performAction() {
                if (this.action) {
                    let e = Rr[this.action];
                    if (e) return e;
                    this.raise("unknown action");
                }
                this.raise("action attribute is missing");
            }
            get targetElements() {
                if (this.target) return this.targetElementsById;
                if (this.targets) return this.targetElementsByQuery;
                this.raise("target or targets attribute is missing");
            }
            get templateContent() {
                return this.templateElement.content.cloneNode(!0);
            }
            get templateElement() {
                if (this.firstElementChild instanceof HTMLTemplateElement)
                    return this.firstElementChild;
                this.raise("first child element must be a <template> element");
            }
            get action() {
                return this.getAttribute("action");
            }
            get target() {
                return this.getAttribute("target");
            }
            get targets() {
                return this.getAttribute("targets");
            }
            raise(e) {
                throw new Error(`${this.description}: ${e}`);
            }
            get description() {
                var e, t;
                return (t = (
                    (e = this.outerHTML.match(/<[^>]+>/)) !== null &&
                    e !== void 0
                        ? e
                        : []
                )[0]) !== null && t !== void 0
                    ? t
                    : "<turbo-stream>";
            }
            get beforeRenderEvent() {
                return new CustomEvent("turbo:before-stream-render", {
                    bubbles: !0,
                    cancelable: !0,
                });
            }
            get targetElementsById() {
                var e;
                let t =
                    (e = this.ownerDocument) === null || e === void 0
                        ? void 0
                        : e.getElementById(this.target);
                return t !== null ? [t] : [];
            }
            get targetElementsByQuery() {
                var e;
                let t =
                    (e = this.ownerDocument) === null || e === void 0
                        ? void 0
                        : e.querySelectorAll(this.targets);
                return t.length !== 0 ? Array.prototype.slice.call(t) : [];
            }
        };
    B.delegateConstructor = ci;
    customElements.define("turbo-frame", B);
    customElements.define("turbo-stream", di);
    (() => {
        let i = document.currentScript;
        if (!!i && !i.hasAttribute("data-turbo-suppress-warning")) {
            for (; (i = i.parentElement); )
                if (i == document.body)
                    return console.warn(
                        qt`
        You are loading Turbo from a <script> element inside the <body> element. This is probably not what you meant to do!

        Load your application’s JavaScript bundle inside the <head> element instead. <script> elements in <body> are evaluated with each page change.

        For more information, see: https://turbo.hotwired.dev/handbook/building#working-with-script-elements

        ——
        Suppress this warning by adding a "data-turbo-suppress-warning" attribute to: %s
      `,
                        i.outerHTML
                    );
        }
    })();
    window.Turbo = xr;
    ai();
    var vi;
    async function Dr() {
        return vi || yi(Br().then(yi));
    }
    function yi(i) {
        return (vi = i);
    }
    async function Br() {
        let { createConsumer: i } = await Promise.resolve().then(
            () => (bi(), gi)
        );
        return i();
    }
    async function wi(i, e) {
        let { subscriptions: t } = await Dr();
        return t.create(i, e);
    }
    var Ei = class extends HTMLElement {
        async connectedCallback() {
            nt(this),
                (this.subscription = await wi(this.channel, {
                    received: this.dispatchMessageEvent.bind(this),
                }));
        }
        disconnectedCallback() {
            ot(this), this.subscription && this.subscription.unsubscribe();
        }
        dispatchMessageEvent(e) {
            let t = new MessageEvent("message", { data: e });
            return this.dispatchEvent(t);
        }
        get channel() {
            let e = this.getAttribute("channel"),
                t = this.getAttribute("signed-stream-name");
            return { channel: e, signed_stream_name: t };
        }
    };
    customElements.define("turbo-cable-stream-source", Ei);
    var Si = { exports: {} };
    (function (i, e) {
        (function (t) {
            i.exports = t();
        })(function (t) {
            var s = [
                "0",
                "1",
                "2",
                "3",
                "4",
                "5",
                "6",
                "7",
                "8",
                "9",
                "a",
                "b",
                "c",
                "d",
                "e",
                "f",
            ];
            function r(d, u) {
                var a = d[0],
                    n = d[1],
                    l = d[2],
                    c = d[3];
                (a += (((n & l) | (~n & c)) + u[0] - 680876936) | 0),
                    (a = (((a << 7) | (a >>> 25)) + n) | 0),
                    (c += (((a & n) | (~a & l)) + u[1] - 389564586) | 0),
                    (c = (((c << 12) | (c >>> 20)) + a) | 0),
                    (l += (((c & a) | (~c & n)) + u[2] + 606105819) | 0),
                    (l = (((l << 17) | (l >>> 15)) + c) | 0),
                    (n += (((l & c) | (~l & a)) + u[3] - 1044525330) | 0),
                    (n = (((n << 22) | (n >>> 10)) + l) | 0),
                    (a += (((n & l) | (~n & c)) + u[4] - 176418897) | 0),
                    (a = (((a << 7) | (a >>> 25)) + n) | 0),
                    (c += (((a & n) | (~a & l)) + u[5] + 1200080426) | 0),
                    (c = (((c << 12) | (c >>> 20)) + a) | 0),
                    (l += (((c & a) | (~c & n)) + u[6] - 1473231341) | 0),
                    (l = (((l << 17) | (l >>> 15)) + c) | 0),
                    (n += (((l & c) | (~l & a)) + u[7] - 45705983) | 0),
                    (n = (((n << 22) | (n >>> 10)) + l) | 0),
                    (a += (((n & l) | (~n & c)) + u[8] + 1770035416) | 0),
                    (a = (((a << 7) | (a >>> 25)) + n) | 0),
                    (c += (((a & n) | (~a & l)) + u[9] - 1958414417) | 0),
                    (c = (((c << 12) | (c >>> 20)) + a) | 0),
                    (l += (((c & a) | (~c & n)) + u[10] - 42063) | 0),
                    (l = (((l << 17) | (l >>> 15)) + c) | 0),
                    (n += (((l & c) | (~l & a)) + u[11] - 1990404162) | 0),
                    (n = (((n << 22) | (n >>> 10)) + l) | 0),
                    (a += (((n & l) | (~n & c)) + u[12] + 1804603682) | 0),
                    (a = (((a << 7) | (a >>> 25)) + n) | 0),
                    (c += (((a & n) | (~a & l)) + u[13] - 40341101) | 0),
                    (c = (((c << 12) | (c >>> 20)) + a) | 0),
                    (l += (((c & a) | (~c & n)) + u[14] - 1502002290) | 0),
                    (l = (((l << 17) | (l >>> 15)) + c) | 0),
                    (n += (((l & c) | (~l & a)) + u[15] + 1236535329) | 0),
                    (n = (((n << 22) | (n >>> 10)) + l) | 0),
                    (a += (((n & c) | (l & ~c)) + u[1] - 165796510) | 0),
                    (a = (((a << 5) | (a >>> 27)) + n) | 0),
                    (c += (((a & l) | (n & ~l)) + u[6] - 1069501632) | 0),
                    (c = (((c << 9) | (c >>> 23)) + a) | 0),
                    (l += (((c & n) | (a & ~n)) + u[11] + 643717713) | 0),
                    (l = (((l << 14) | (l >>> 18)) + c) | 0),
                    (n += (((l & a) | (c & ~a)) + u[0] - 373897302) | 0),
                    (n = (((n << 20) | (n >>> 12)) + l) | 0),
                    (a += (((n & c) | (l & ~c)) + u[5] - 701558691) | 0),
                    (a = (((a << 5) | (a >>> 27)) + n) | 0),
                    (c += (((a & l) | (n & ~l)) + u[10] + 38016083) | 0),
                    (c = (((c << 9) | (c >>> 23)) + a) | 0),
                    (l += (((c & n) | (a & ~n)) + u[15] - 660478335) | 0),
                    (l = (((l << 14) | (l >>> 18)) + c) | 0),
                    (n += (((l & a) | (c & ~a)) + u[4] - 405537848) | 0),
                    (n = (((n << 20) | (n >>> 12)) + l) | 0),
                    (a += (((n & c) | (l & ~c)) + u[9] + 568446438) | 0),
                    (a = (((a << 5) | (a >>> 27)) + n) | 0),
                    (c += (((a & l) | (n & ~l)) + u[14] - 1019803690) | 0),
                    (c = (((c << 9) | (c >>> 23)) + a) | 0),
                    (l += (((c & n) | (a & ~n)) + u[3] - 187363961) | 0),
                    (l = (((l << 14) | (l >>> 18)) + c) | 0),
                    (n += (((l & a) | (c & ~a)) + u[8] + 1163531501) | 0),
                    (n = (((n << 20) | (n >>> 12)) + l) | 0),
                    (a += (((n & c) | (l & ~c)) + u[13] - 1444681467) | 0),
                    (a = (((a << 5) | (a >>> 27)) + n) | 0),
                    (c += (((a & l) | (n & ~l)) + u[2] - 51403784) | 0),
                    (c = (((c << 9) | (c >>> 23)) + a) | 0),
                    (l += (((c & n) | (a & ~n)) + u[7] + 1735328473) | 0),
                    (l = (((l << 14) | (l >>> 18)) + c) | 0),
                    (n += (((l & a) | (c & ~a)) + u[12] - 1926607734) | 0),
                    (n = (((n << 20) | (n >>> 12)) + l) | 0),
                    (a += ((n ^ l ^ c) + u[5] - 378558) | 0),
                    (a = (((a << 4) | (a >>> 28)) + n) | 0),
                    (c += ((a ^ n ^ l) + u[8] - 2022574463) | 0),
                    (c = (((c << 11) | (c >>> 21)) + a) | 0),
                    (l += ((c ^ a ^ n) + u[11] + 1839030562) | 0),
                    (l = (((l << 16) | (l >>> 16)) + c) | 0),
                    (n += ((l ^ c ^ a) + u[14] - 35309556) | 0),
                    (n = (((n << 23) | (n >>> 9)) + l) | 0),
                    (a += ((n ^ l ^ c) + u[1] - 1530992060) | 0),
                    (a = (((a << 4) | (a >>> 28)) + n) | 0),
                    (c += ((a ^ n ^ l) + u[4] + 1272893353) | 0),
                    (c = (((c << 11) | (c >>> 21)) + a) | 0),
                    (l += ((c ^ a ^ n) + u[7] - 155497632) | 0),
                    (l = (((l << 16) | (l >>> 16)) + c) | 0),
                    (n += ((l ^ c ^ a) + u[10] - 1094730640) | 0),
                    (n = (((n << 23) | (n >>> 9)) + l) | 0),
                    (a += ((n ^ l ^ c) + u[13] + 681279174) | 0),
                    (a = (((a << 4) | (a >>> 28)) + n) | 0),
                    (c += ((a ^ n ^ l) + u[0] - 358537222) | 0),
                    (c = (((c << 11) | (c >>> 21)) + a) | 0),
                    (l += ((c ^ a ^ n) + u[3] - 722521979) | 0),
                    (l = (((l << 16) | (l >>> 16)) + c) | 0),
                    (n += ((l ^ c ^ a) + u[6] + 76029189) | 0),
                    (n = (((n << 23) | (n >>> 9)) + l) | 0),
                    (a += ((n ^ l ^ c) + u[9] - 640364487) | 0),
                    (a = (((a << 4) | (a >>> 28)) + n) | 0),
                    (c += ((a ^ n ^ l) + u[12] - 421815835) | 0),
                    (c = (((c << 11) | (c >>> 21)) + a) | 0),
                    (l += ((c ^ a ^ n) + u[15] + 530742520) | 0),
                    (l = (((l << 16) | (l >>> 16)) + c) | 0),
                    (n += ((l ^ c ^ a) + u[2] - 995338651) | 0),
                    (n = (((n << 23) | (n >>> 9)) + l) | 0),
                    (a += ((l ^ (n | ~c)) + u[0] - 198630844) | 0),
                    (a = (((a << 6) | (a >>> 26)) + n) | 0),
                    (c += ((n ^ (a | ~l)) + u[7] + 1126891415) | 0),
                    (c = (((c << 10) | (c >>> 22)) + a) | 0),
                    (l += ((a ^ (c | ~n)) + u[14] - 1416354905) | 0),
                    (l = (((l << 15) | (l >>> 17)) + c) | 0),
                    (n += ((c ^ (l | ~a)) + u[5] - 57434055) | 0),
                    (n = (((n << 21) | (n >>> 11)) + l) | 0),
                    (a += ((l ^ (n | ~c)) + u[12] + 1700485571) | 0),
                    (a = (((a << 6) | (a >>> 26)) + n) | 0),
                    (c += ((n ^ (a | ~l)) + u[3] - 1894986606) | 0),
                    (c = (((c << 10) | (c >>> 22)) + a) | 0),
                    (l += ((a ^ (c | ~n)) + u[10] - 1051523) | 0),
                    (l = (((l << 15) | (l >>> 17)) + c) | 0),
                    (n += ((c ^ (l | ~a)) + u[1] - 2054922799) | 0),
                    (n = (((n << 21) | (n >>> 11)) + l) | 0),
                    (a += ((l ^ (n | ~c)) + u[8] + 1873313359) | 0),
                    (a = (((a << 6) | (a >>> 26)) + n) | 0),
                    (c += ((n ^ (a | ~l)) + u[15] - 30611744) | 0),
                    (c = (((c << 10) | (c >>> 22)) + a) | 0),
                    (l += ((a ^ (c | ~n)) + u[6] - 1560198380) | 0),
                    (l = (((l << 15) | (l >>> 17)) + c) | 0),
                    (n += ((c ^ (l | ~a)) + u[13] + 1309151649) | 0),
                    (n = (((n << 21) | (n >>> 11)) + l) | 0),
                    (a += ((l ^ (n | ~c)) + u[4] - 145523070) | 0),
                    (a = (((a << 6) | (a >>> 26)) + n) | 0),
                    (c += ((n ^ (a | ~l)) + u[11] - 1120210379) | 0),
                    (c = (((c << 10) | (c >>> 22)) + a) | 0),
                    (l += ((a ^ (c | ~n)) + u[2] + 718787259) | 0),
                    (l = (((l << 15) | (l >>> 17)) + c) | 0),
                    (n += ((c ^ (l | ~a)) + u[9] - 343485551) | 0),
                    (n = (((n << 21) | (n >>> 11)) + l) | 0),
                    (d[0] = (a + d[0]) | 0),
                    (d[1] = (n + d[1]) | 0),
                    (d[2] = (l + d[2]) | 0),
                    (d[3] = (c + d[3]) | 0);
            }
            function o(d) {
                var u = [],
                    a;
                for (a = 0; a < 64; a += 4)
                    u[a >> 2] =
                        d.charCodeAt(a) +
                        (d.charCodeAt(a + 1) << 8) +
                        (d.charCodeAt(a + 2) << 16) +
                        (d.charCodeAt(a + 3) << 24);
                return u;
            }
            function h(d) {
                var u = [],
                    a;
                for (a = 0; a < 64; a += 4)
                    u[a >> 2] =
                        d[a] +
                        (d[a + 1] << 8) +
                        (d[a + 2] << 16) +
                        (d[a + 3] << 24);
                return u;
            }
            function p(d) {
                var u = d.length,
                    a = [1732584193, -271733879, -1732584194, 271733878],
                    n,
                    l,
                    c,
                    L,
                    I,
                    H;
                for (n = 64; n <= u; n += 64) r(a, o(d.substring(n - 64, n)));
                for (
                    d = d.substring(n - 64),
                        l = d.length,
                        c = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        n = 0;
                    n < l;
                    n += 1
                )
                    c[n >> 2] |= d.charCodeAt(n) << (n % 4 << 3);
                if (((c[n >> 2] |= 128 << (n % 4 << 3)), n > 55))
                    for (r(a, c), n = 0; n < 16; n += 1) c[n] = 0;
                return (
                    (L = u * 8),
                    (L = L.toString(16).match(/(.*?)(.{0,8})$/)),
                    (I = parseInt(L[2], 16)),
                    (H = parseInt(L[1], 16) || 0),
                    (c[14] = I),
                    (c[15] = H),
                    r(a, c),
                    a
                );
            }
            function b(d) {
                var u = d.length,
                    a = [1732584193, -271733879, -1732584194, 271733878],
                    n,
                    l,
                    c,
                    L,
                    I,
                    H;
                for (n = 64; n <= u; n += 64) r(a, h(d.subarray(n - 64, n)));
                for (
                    d = n - 64 < u ? d.subarray(n - 64) : new Uint8Array(0),
                        l = d.length,
                        c = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        n = 0;
                    n < l;
                    n += 1
                )
                    c[n >> 2] |= d[n] << (n % 4 << 3);
                if (((c[n >> 2] |= 128 << (n % 4 << 3)), n > 55))
                    for (r(a, c), n = 0; n < 16; n += 1) c[n] = 0;
                return (
                    (L = u * 8),
                    (L = L.toString(16).match(/(.*?)(.{0,8})$/)),
                    (I = parseInt(L[2], 16)),
                    (H = parseInt(L[1], 16) || 0),
                    (c[14] = I),
                    (c[15] = H),
                    r(a, c),
                    a
                );
            }
            function f(d) {
                var u = "",
                    a;
                for (a = 0; a < 4; a += 1)
                    u += s[(d >> (a * 8 + 4)) & 15] + s[(d >> (a * 8)) & 15];
                return u;
            }
            function w(d) {
                var u;
                for (u = 0; u < d.length; u += 1) d[u] = f(d[u]);
                return d.join("");
            }
            w(p("hello")) !== "5d41402abc4b2a76b9719d911017c592",
                typeof ArrayBuffer != "undefined" &&
                    !ArrayBuffer.prototype.slice &&
                    (function () {
                        function d(u, a) {
                            return (
                                (u = u | 0 || 0),
                                u < 0 ? Math.max(u + a, 0) : Math.min(u, a)
                            );
                        }
                        ArrayBuffer.prototype.slice = function (u, a) {
                            var n = this.byteLength,
                                l = d(u, n),
                                c = n,
                                L,
                                I,
                                H,
                                Ft;
                            return (
                                a !== t && (c = d(a, n)),
                                l > c
                                    ? new ArrayBuffer(0)
                                    : ((L = c - l),
                                      (I = new ArrayBuffer(L)),
                                      (H = new Uint8Array(I)),
                                      (Ft = new Uint8Array(this, l, L)),
                                      H.set(Ft),
                                      I)
                            );
                        };
                    })();
            function v(d) {
                return (
                    /[\u0080-\uFFFF]/.test(d) &&
                        (d = unescape(encodeURIComponent(d))),
                    d
                );
            }
            function E(d, u) {
                var a = d.length,
                    n = new ArrayBuffer(a),
                    l = new Uint8Array(n),
                    c;
                for (c = 0; c < a; c += 1) l[c] = d.charCodeAt(c);
                return u ? l : n;
            }
            function S(d) {
                return String.fromCharCode.apply(null, new Uint8Array(d));
            }
            function m(d, u, a) {
                var n = new Uint8Array(d.byteLength + u.byteLength);
                return (
                    n.set(new Uint8Array(d)),
                    n.set(new Uint8Array(u), d.byteLength),
                    a ? n : n.buffer
                );
            }
            function y(d) {
                var u = [],
                    a = d.length,
                    n;
                for (n = 0; n < a - 1; n += 2)
                    u.push(parseInt(d.substr(n, 2), 16));
                return String.fromCharCode.apply(String, u);
            }
            function g() {
                this.reset();
            }
            return (
                (g.prototype.append = function (d) {
                    return this.appendBinary(v(d)), this;
                }),
                (g.prototype.appendBinary = function (d) {
                    (this._buff += d), (this._length += d.length);
                    var u = this._buff.length,
                        a;
                    for (a = 64; a <= u; a += 64)
                        r(this._hash, o(this._buff.substring(a - 64, a)));
                    return (this._buff = this._buff.substring(a - 64)), this;
                }),
                (g.prototype.end = function (d) {
                    var u = this._buff,
                        a = u.length,
                        n,
                        l = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        c;
                    for (n = 0; n < a; n += 1)
                        l[n >> 2] |= u.charCodeAt(n) << (n % 4 << 3);
                    return (
                        this._finish(l, a),
                        (c = w(this._hash)),
                        d && (c = y(c)),
                        this.reset(),
                        c
                    );
                }),
                (g.prototype.reset = function () {
                    return (
                        (this._buff = ""),
                        (this._length = 0),
                        (this._hash = [
                            1732584193, -271733879, -1732584194, 271733878,
                        ]),
                        this
                    );
                }),
                (g.prototype.getState = function () {
                    return {
                        buff: this._buff,
                        length: this._length,
                        hash: this._hash.slice(),
                    };
                }),
                (g.prototype.setState = function (d) {
                    return (
                        (this._buff = d.buff),
                        (this._length = d.length),
                        (this._hash = d.hash),
                        this
                    );
                }),
                (g.prototype.destroy = function () {
                    delete this._hash, delete this._buff, delete this._length;
                }),
                (g.prototype._finish = function (d, u) {
                    var a = u,
                        n,
                        l,
                        c;
                    if (((d[a >> 2] |= 128 << (a % 4 << 3)), a > 55))
                        for (r(this._hash, d), a = 0; a < 16; a += 1) d[a] = 0;
                    (n = this._length * 8),
                        (n = n.toString(16).match(/(.*?)(.{0,8})$/)),
                        (l = parseInt(n[2], 16)),
                        (c = parseInt(n[1], 16) || 0),
                        (d[14] = l),
                        (d[15] = c),
                        r(this._hash, d);
                }),
                (g.hash = function (d, u) {
                    return g.hashBinary(v(d), u);
                }),
                (g.hashBinary = function (d, u) {
                    var a = p(d),
                        n = w(a);
                    return u ? y(n) : n;
                }),
                (g.ArrayBuffer = function () {
                    this.reset();
                }),
                (g.ArrayBuffer.prototype.append = function (d) {
                    var u = m(this._buff.buffer, d, !0),
                        a = u.length,
                        n;
                    for (this._length += d.byteLength, n = 64; n <= a; n += 64)
                        r(this._hash, h(u.subarray(n - 64, n)));
                    return (
                        (this._buff =
                            n - 64 < a
                                ? new Uint8Array(u.buffer.slice(n - 64))
                                : new Uint8Array(0)),
                        this
                    );
                }),
                (g.ArrayBuffer.prototype.end = function (d) {
                    var u = this._buff,
                        a = u.length,
                        n = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        l,
                        c;
                    for (l = 0; l < a; l += 1)
                        n[l >> 2] |= u[l] << (l % 4 << 3);
                    return (
                        this._finish(n, a),
                        (c = w(this._hash)),
                        d && (c = y(c)),
                        this.reset(),
                        c
                    );
                }),
                (g.ArrayBuffer.prototype.reset = function () {
                    return (
                        (this._buff = new Uint8Array(0)),
                        (this._length = 0),
                        (this._hash = [
                            1732584193, -271733879, -1732584194, 271733878,
                        ]),
                        this
                    );
                }),
                (g.ArrayBuffer.prototype.getState = function () {
                    var d = g.prototype.getState.call(this);
                    return (d.buff = S(d.buff)), d;
                }),
                (g.ArrayBuffer.prototype.setState = function (d) {
                    return (
                        (d.buff = E(d.buff, !0)),
                        g.prototype.setState.call(this, d)
                    );
                }),
                (g.ArrayBuffer.prototype.destroy = g.prototype.destroy),
                (g.ArrayBuffer.prototype._finish = g.prototype._finish),
                (g.ArrayBuffer.hash = function (d, u) {
                    var a = b(new Uint8Array(d)),
                        n = w(a);
                    return u ? y(n) : n;
                }),
                g
            );
        });
    })(Si);
    var Nr = Si.exports,
        Hr =
            File.prototype.slice ||
            File.prototype.mozSlice ||
            File.prototype.webkitSlice,
        Oe = class {
            static create(e, t) {
                new Oe(e).create(t);
            }
            constructor(e) {
                (this.file = e),
                    (this.chunkSize = 2097152),
                    (this.chunkCount = Math.ceil(
                        this.file.size / this.chunkSize
                    )),
                    (this.chunkIndex = 0);
            }
            create(e) {
                (this.callback = e),
                    (this.md5Buffer = new Nr.ArrayBuffer()),
                    (this.fileReader = new FileReader()),
                    this.fileReader.addEventListener("load", (t) =>
                        this.fileReaderDidLoad(t)
                    ),
                    this.fileReader.addEventListener("error", (t) =>
                        this.fileReaderDidError(t)
                    ),
                    this.readNextChunk();
            }
            fileReaderDidLoad(e) {
                if (
                    (this.md5Buffer.append(e.target.result),
                    !this.readNextChunk())
                ) {
                    let t = this.md5Buffer.end(!0),
                        s = btoa(t);
                    this.callback(null, s);
                }
            }
            fileReaderDidError(e) {
                this.callback(`Error reading ${this.file.name}`);
            }
            readNextChunk() {
                if (
                    this.chunkIndex < this.chunkCount ||
                    (this.chunkIndex == 0 && this.chunkCount == 0)
                ) {
                    let e = this.chunkIndex * this.chunkSize,
                        t = Math.min(e + this.chunkSize, this.file.size),
                        s = Hr.call(this.file, e, t);
                    return (
                        this.fileReader.readAsArrayBuffer(s),
                        this.chunkIndex++,
                        !0
                    );
                } else return !1;
            }
        };
    function jr(i) {
        let e = Ci(document.head, `meta[name="${i}"]`);
        if (e) return e.getAttribute("content");
    }
    function $r(i, e) {
        typeof i == "string" && ((e = i), (i = document));
        let t = i.querySelectorAll(e);
        return Ai(t);
    }
    function Ci(i, e) {
        return (
            typeof i == "string" && ((e = i), (i = document)),
            i.querySelector(e)
        );
    }
    function Ti(i, e, t = {}) {
        let { disabled: s } = i,
            { bubbles: r, cancelable: o, detail: h } = t,
            p = document.createEvent("Event");
        p.initEvent(e, r || !0, o || !0), (p.detail = h || {});
        try {
            (i.disabled = !1), i.dispatchEvent(p);
        } finally {
            i.disabled = s;
        }
        return p;
    }
    function Ai(i) {
        return Array.isArray(i)
            ? i
            : Array.from
            ? Array.from(i)
            : [].slice.call(i);
    }
    var ki = class {
            constructor(e, t, s, r, o) {
                (this.file = e),
                    (this.attributes = {
                        filename: e.name,
                        content_type: e.type || "application/octet-stream",
                        byte_size: e.size,
                        checksum: t,
                    }),
                    (this.directUploadToken = r),
                    (this.attachmentName = o),
                    (this.xhr = new XMLHttpRequest()),
                    this.xhr.open("POST", s, !0),
                    (this.xhr.responseType = "json"),
                    this.xhr.setRequestHeader(
                        "Content-Type",
                        "application/json"
                    ),
                    this.xhr.setRequestHeader("Accept", "application/json"),
                    this.xhr.setRequestHeader(
                        "X-Requested-With",
                        "XMLHttpRequest"
                    );
                let h = jr("csrf-token");
                h != null && this.xhr.setRequestHeader("X-CSRF-Token", h),
                    this.xhr.addEventListener("load", (p) =>
                        this.requestDidLoad(p)
                    ),
                    this.xhr.addEventListener("error", (p) =>
                        this.requestDidError(p)
                    );
            }
            get status() {
                return this.xhr.status;
            }
            get response() {
                let { responseType: e, response: t } = this.xhr;
                return e == "json" ? t : JSON.parse(t);
            }
            create(e) {
                (this.callback = e),
                    this.xhr.send(
                        JSON.stringify({
                            blob: this.attributes,
                            direct_upload_token: this.directUploadToken,
                            attachment_name: this.attachmentName,
                        })
                    );
            }
            requestDidLoad(e) {
                if (this.status >= 200 && this.status < 300) {
                    let { response: t } = this,
                        { direct_upload: s } = t;
                    delete t.direct_upload,
                        (this.attributes = t),
                        (this.directUploadData = s),
                        this.callback(null, this.toJSON());
                } else this.requestDidError(e);
            }
            requestDidError(e) {
                this.callback(
                    `Error creating Blob for "${this.file.name}". Status: ${this.status}`
                );
            }
            toJSON() {
                let e = {};
                for (let t in this.attributes) e[t] = this.attributes[t];
                return e;
            }
        },
        Li = class {
            constructor(e) {
                (this.blob = e), (this.file = e.file);
                let { url: t, headers: s } = e.directUploadData;
                (this.xhr = new XMLHttpRequest()),
                    this.xhr.open("PUT", t, !0),
                    (this.xhr.responseType = "text");
                for (let r in s) this.xhr.setRequestHeader(r, s[r]);
                this.xhr.addEventListener("load", (r) =>
                    this.requestDidLoad(r)
                ),
                    this.xhr.addEventListener("error", (r) =>
                        this.requestDidError(r)
                    );
            }
            create(e) {
                (this.callback = e), this.xhr.send(this.file.slice());
            }
            requestDidLoad(e) {
                let { status: t, response: s } = this.xhr;
                t >= 200 && t < 300
                    ? this.callback(null, s)
                    : this.requestDidError(e);
            }
            requestDidError(e) {
                this.callback(
                    `Error storing "${this.file.name}". Status: ${this.xhr.status}`
                );
            }
        },
        Vr = 0,
        xi = class {
            constructor(e, t, s, r, o) {
                (this.id = ++Vr),
                    (this.file = e),
                    (this.url = t),
                    (this.serviceName = s),
                    (this.attachmentName = r),
                    (this.delegate = o);
            }
            create(e) {
                Oe.create(this.file, (t, s) => {
                    if (t) {
                        e(t);
                        return;
                    }
                    let r = new ki(
                        this.file,
                        s,
                        this.url,
                        this.serviceName,
                        this.attachmentName
                    );
                    Ri(
                        this.delegate,
                        "directUploadWillCreateBlobWithXHR",
                        r.xhr
                    ),
                        r.create((o) => {
                            if (o) e(o);
                            else {
                                let h = new Li(r);
                                Ri(
                                    this.delegate,
                                    "directUploadWillStoreFileWithXHR",
                                    h.xhr
                                ),
                                    h.create((p) => {
                                        p ? e(p) : e(null, r.toJSON());
                                    });
                            }
                        });
                });
            }
        };
    function Ri(i, e, ...t) {
        if (i && typeof i[e] == "function") return i[e](...t);
    }
    var Mi = class {
            constructor(e, t) {
                (this.input = e),
                    (this.file = t),
                    (this.directUpload = new xi(
                        this.file,
                        this.url,
                        this.directUploadToken,
                        this.attachmentName,
                        this
                    )),
                    this.dispatch("initialize");
            }
            start(e) {
                let t = document.createElement("input");
                (t.type = "hidden"),
                    (t.name = this.input.name),
                    this.input.insertAdjacentElement("beforebegin", t),
                    this.dispatch("start"),
                    this.directUpload.create((s, r) => {
                        s
                            ? (t.parentNode.removeChild(t),
                              this.dispatchError(s))
                            : (t.value = r.signed_id),
                            this.dispatch("end"),
                            e(s);
                    });
            }
            uploadRequestDidProgress(e) {
                let t = (e.loaded / e.total) * 100;
                t && this.dispatch("progress", { progress: t });
            }
            get url() {
                return this.input.getAttribute("data-direct-upload-url");
            }
            get directUploadToken() {
                return this.input.getAttribute("data-direct-upload-token");
            }
            get attachmentName() {
                return this.input.getAttribute(
                    "data-direct-upload-attachment-name"
                );
            }
            dispatch(e, t = {}) {
                return (
                    (t.file = this.file),
                    (t.id = this.directUpload.id),
                    Ti(this.input, `direct-upload:${e}`, { detail: t })
                );
            }
            dispatchError(e) {
                this.dispatch("error", { error: e }).defaultPrevented ||
                    alert(e);
            }
            directUploadWillCreateBlobWithXHR(e) {
                this.dispatch("before-blob-request", { xhr: e });
            }
            directUploadWillStoreFileWithXHR(e) {
                this.dispatch("before-storage-request", { xhr: e }),
                    e.upload.addEventListener("progress", (t) =>
                        this.uploadRequestDidProgress(t)
                    );
            }
        },
        _r = "input[type=file][data-direct-upload-url]:not([disabled])",
        Pi = class {
            constructor(e) {
                (this.form = e),
                    (this.inputs = $r(e, _r).filter((t) => t.files.length));
            }
            start(e) {
                let t = this.createDirectUploadControllers(),
                    s = () => {
                        let r = t.shift();
                        r
                            ? r.start((o) => {
                                  o ? (e(o), this.dispatch("end")) : s();
                              })
                            : (e(), this.dispatch("end"));
                    };
                this.dispatch("start"), s();
            }
            createDirectUploadControllers() {
                let e = [];
                return (
                    this.inputs.forEach((t) => {
                        Ai(t.files).forEach((s) => {
                            let r = new Mi(t, s);
                            e.push(r);
                        });
                    }),
                    e
                );
            }
            dispatch(e, t = {}) {
                return Ti(this.form, `direct-uploads:${e}`, { detail: t });
            }
        },
        pt = "data-direct-uploads-processing",
        mt = new WeakMap(),
        Oi = !1;
    function gt() {
        Oi ||
            ((Oi = !0),
            document.addEventListener("click", Ur, !0),
            document.addEventListener("submit", Wr, !0),
            document.addEventListener("ajax:before", zr));
    }
    function Ur(i) {
        let { target: e } = i;
        (e.tagName == "INPUT" || e.tagName == "BUTTON") &&
            e.type == "submit" &&
            e.form &&
            mt.set(e.form, e);
    }
    function Wr(i) {
        Fi(i);
    }
    function zr(i) {
        i.target.tagName == "FORM" && Fi(i);
    }
    function Fi(i) {
        let e = i.target;
        if (e.hasAttribute(pt)) {
            i.preventDefault();
            return;
        }
        let t = new Pi(e),
            { inputs: s } = t;
        s.length &&
            (i.preventDefault(),
            e.setAttribute(pt, ""),
            s.forEach(Xr),
            t.start((r) => {
                e.removeAttribute(pt), r ? s.forEach(Jr) : Kr(e);
            }));
    }
    function Kr(i) {
        let e = mt.get(i) || Ci(i, "input[type=submit], button[type=submit]");
        if (e) {
            let { disabled: t } = e;
            (e.disabled = !1), e.focus(), e.click(), (e.disabled = t);
        } else
            (e = document.createElement("input")),
                (e.type = "submit"),
                (e.style.display = "none"),
                i.appendChild(e),
                e.click(),
                i.removeChild(e);
        mt.delete(i);
    }
    function Xr(i) {
        i.disabled = !0;
    }
    function Jr(i) {
        i.disabled = !1;
    }
    function Gr() {
        window.ActiveStorage && gt();
    }
    setTimeout(Gr, 1);
    var Ii = {
        toHTMLAttributes: function (i) {
            if (Object.prototype.toString.call(i) != "[object Object]")
                return "";
            var e = Object.keys(i),
                t = "",
                s,
                r;
            for (r = e.length; r--; )
                (s = e[r]),
                    s != "class" &&
                        i.hasOwnProperty(s) &&
                        i[s] !== void 0 &&
                        (t += " " + s + (i[s] !== void 0 ? `="${i[s]}"` : ""));
            return t;
        },
        currentPageHasTrixEditor: function () {
            let i = window.location.pathname,
                e = i.split("/"),
                t = e.includes("resources") && e.includes("edit");
            return !!(i === "/resources/new" || t);
        },
        strftime: function (i, e) {
            e instanceof Date || (e = new Date());
            var t = e.getDay(),
                s = e.getDate(),
                r = e.getMonth(),
                o = e.getFullYear(),
                h = e.getHours(),
                p = [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                ],
                b = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                f = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
                w = function () {
                    return (o % 4 === 0 && o % 100 !== 0) || o % 400 === 0;
                },
                v = function () {
                    var S = new Date(e);
                    return S.setDate(s - ((t + 6) % 7) + 3), S;
                },
                E = function (S, m) {
                    return ("" + (Math.pow(10, m) + S)).slice(1);
                };
            return i.replace(/%[a-z]/gi, function (S) {
                return (
                    {
                        "%a": p[t].slice(0, 3),
                        "%A": p[t],
                        "%b": b[r].slice(0, 3),
                        "%B": b[r],
                        "%c": e.toUTCString(),
                        "%C": Math.floor(o / 100),
                        "%d": E(s, 2),
                        "%e": s,
                        "%F": e.toISOString().slice(0, 10),
                        "%G": v().getFullYear(),
                        "%g": ("" + v().getFullYear()).slice(2),
                        "%H": E(h, 2),
                        "%I": E(((h + 11) % 12) + 1, 2),
                        "%j": E(f[r] + s + (r > 1 && w() ? 1 : 0), 3),
                        "%k": "" + h,
                        "%l": ((h + 11) % 12) + 1,
                        "%m": E(r + 1, 2),
                        "%M": E(e.getMinutes(), 2),
                        "%p": h < 12 ? "AM" : "PM",
                        "%P": h < 12 ? "am" : "pm",
                        "%s": Math.round(e.getTime() / 1e3),
                        "%S": E(e.getSeconds(), 2),
                        "%u": t || 7,
                        "%V": (function () {
                            var m = v(),
                                y = m.valueOf();
                            m.setMonth(0, 1);
                            var g = m.getDay();
                            return (
                                g !== 4 && m.setMonth(0, 1 + ((4 - g + 7) % 7)),
                                E(1 + Math.ceil((y - m) / 6048e5), 2)
                            );
                        })(),
                        "%w": "" + t,
                        "%x": e.toLocaleDateString(),
                        "%X": e.toLocaleTimeString(),
                        "%y": ("" + o).slice(2),
                        "%Y": o,
                        "%z": e
                            .toTimeString()
                            .replace(/.+GMT([+-]\d+).+/, "$1"),
                        "%Z": e.toTimeString().replace(/.+\((.+?)\)$/, "$1"),
                    }[S] || S
                );
            });
        },
    };
    var Di = class {
        constructor(e, t, s) {
            (this.eventTarget = e),
                (this.eventName = t),
                (this.eventOptions = s),
                (this.unorderedBindings = new Set());
        }
        connect() {
            this.eventTarget.addEventListener(
                this.eventName,
                this,
                this.eventOptions
            );
        }
        disconnect() {
            this.eventTarget.removeEventListener(
                this.eventName,
                this,
                this.eventOptions
            );
        }
        bindingConnected(e) {
            this.unorderedBindings.add(e);
        }
        bindingDisconnected(e) {
            this.unorderedBindings.delete(e);
        }
        handleEvent(e) {
            let t = Yr(e);
            for (let s of this.bindings) {
                if (t.immediatePropagationStopped) break;
                s.handleEvent(t);
            }
        }
        get bindings() {
            return Array.from(this.unorderedBindings).sort((e, t) => {
                let s = e.index,
                    r = t.index;
                return s < r ? -1 : s > r ? 1 : 0;
            });
        }
    };
    function Yr(i) {
        if ("immediatePropagationStopped" in i) return i;
        {
            let { stopImmediatePropagation: e } = i;
            return Object.assign(i, {
                immediatePropagationStopped: !1,
                stopImmediatePropagation() {
                    (this.immediatePropagationStopped = !0), e.call(this);
                },
            });
        }
    }
    var Bi = class {
            constructor(e) {
                (this.application = e),
                    (this.eventListenerMaps = new Map()),
                    (this.started = !1);
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    this.eventListeners.forEach((e) => e.connect()));
            }
            stop() {
                this.started &&
                    ((this.started = !1),
                    this.eventListeners.forEach((e) => e.disconnect()));
            }
            get eventListeners() {
                return Array.from(this.eventListenerMaps.values()).reduce(
                    (e, t) => e.concat(Array.from(t.values())),
                    []
                );
            }
            bindingConnected(e) {
                this.fetchEventListenerForBinding(e).bindingConnected(e);
            }
            bindingDisconnected(e) {
                this.fetchEventListenerForBinding(e).bindingDisconnected(e);
            }
            handleError(e, t, s = {}) {
                this.application.handleError(e, `Error ${t}`, s);
            }
            fetchEventListenerForBinding(e) {
                let { eventTarget: t, eventName: s, eventOptions: r } = e;
                return this.fetchEventListener(t, s, r);
            }
            fetchEventListener(e, t, s) {
                let r = this.fetchEventListenerMapForEventTarget(e),
                    o = this.cacheKey(t, s),
                    h = r.get(o);
                return (
                    h || ((h = this.createEventListener(e, t, s)), r.set(o, h)),
                    h
                );
            }
            createEventListener(e, t, s) {
                let r = new Di(e, t, s);
                return this.started && r.connect(), r;
            }
            fetchEventListenerMapForEventTarget(e) {
                let t = this.eventListenerMaps.get(e);
                return (
                    t || ((t = new Map()), this.eventListenerMaps.set(e, t)), t
                );
            }
            cacheKey(e, t) {
                let s = [e];
                return (
                    Object.keys(t)
                        .sort()
                        .forEach((r) => {
                            s.push(`${t[r] ? "" : "!"}${r}`);
                        }),
                    s.join(":")
                );
            }
        },
        Zr = /^((.+?)(@(window|document))?->)?(.+?)(#([^:]+?))(:(.+))?$/;
    function en(i) {
        let t = i.trim().match(Zr) || [];
        return {
            eventTarget: tn(t[4]),
            eventName: t[2],
            eventOptions: t[9] ? sn(t[9]) : {},
            identifier: t[5],
            methodName: t[7],
        };
    }
    function tn(i) {
        if (i == "window") return window;
        if (i == "document") return document;
    }
    function sn(i) {
        return i
            .split(":")
            .reduce(
                (e, t) =>
                    Object.assign(e, { [t.replace(/^!/, "")]: !/^!/.test(t) }),
                {}
            );
    }
    function rn(i) {
        if (i == window) return "window";
        if (i == document) return "document";
    }
    function qi(i) {
        return i.replace(/(?:[_-])([a-z0-9])/g, (e, t) => t.toUpperCase());
    }
    function Fe(i) {
        return i.charAt(0).toUpperCase() + i.slice(1);
    }
    function Ni(i) {
        return i.replace(/([A-Z])/g, (e, t) => `-${t.toLowerCase()}`);
    }
    function nn(i) {
        return i.match(/[^\s]+/g) || [];
    }
    var Hi = class {
            constructor(e, t, s) {
                (this.element = e),
                    (this.index = t),
                    (this.eventTarget = s.eventTarget || e),
                    (this.eventName =
                        s.eventName || on(e) || bt("missing event name")),
                    (this.eventOptions = s.eventOptions || {}),
                    (this.identifier =
                        s.identifier || bt("missing identifier")),
                    (this.methodName =
                        s.methodName || bt("missing method name"));
            }
            static forToken(e) {
                return new this(e.element, e.index, en(e.content));
            }
            toString() {
                let e = this.eventTargetName ? `@${this.eventTargetName}` : "";
                return `${this.eventName}${e}->${this.identifier}#${this.methodName}`;
            }
            get params() {
                let e = {},
                    t = new RegExp(`^data-${this.identifier}-(.+)-param$`);
                for (let { name: s, value: r } of Array.from(
                    this.element.attributes
                )) {
                    let o = s.match(t),
                        h = o && o[1];
                    h && (e[qi(h)] = an(r));
                }
                return e;
            }
            get eventTargetName() {
                return rn(this.eventTarget);
            }
        },
        ji = {
            a: (i) => "click",
            button: (i) => "click",
            form: (i) => "submit",
            details: (i) => "toggle",
            input: (i) =>
                i.getAttribute("type") == "submit" ? "click" : "input",
            select: (i) => "change",
            textarea: (i) => "input",
        };
    function on(i) {
        let e = i.tagName.toLowerCase();
        if (e in ji) return ji[e](i);
    }
    function bt(i) {
        throw new Error(i);
    }
    function an(i) {
        try {
            return JSON.parse(i);
        } catch {
            return i;
        }
    }
    var $i = class {
            constructor(e, t) {
                (this.context = e), (this.action = t);
            }
            get index() {
                return this.action.index;
            }
            get eventTarget() {
                return this.action.eventTarget;
            }
            get eventOptions() {
                return this.action.eventOptions;
            }
            get identifier() {
                return this.context.identifier;
            }
            handleEvent(e) {
                this.willBeInvokedByEvent(e) &&
                    this.shouldBeInvokedPerSelf(e) &&
                    (this.processStopPropagation(e),
                    this.processPreventDefault(e),
                    this.invokeWithEvent(e));
            }
            get eventName() {
                return this.action.eventName;
            }
            get method() {
                let e = this.controller[this.methodName];
                if (typeof e == "function") return e;
                throw new Error(
                    `Action "${this.action}" references undefined method "${this.methodName}"`
                );
            }
            processStopPropagation(e) {
                this.eventOptions.stop && e.stopPropagation();
            }
            processPreventDefault(e) {
                this.eventOptions.prevent && e.preventDefault();
            }
            invokeWithEvent(e) {
                let { target: t, currentTarget: s } = e;
                try {
                    let { params: r } = this.action,
                        o = Object.assign(e, { params: r });
                    this.method.call(this.controller, o),
                        this.context.logDebugActivity(this.methodName, {
                            event: e,
                            target: t,
                            currentTarget: s,
                            action: this.methodName,
                        });
                } catch (r) {
                    let {
                            identifier: o,
                            controller: h,
                            element: p,
                            index: b,
                        } = this,
                        f = {
                            identifier: o,
                            controller: h,
                            element: p,
                            index: b,
                            event: e,
                        };
                    this.context.handleError(
                        r,
                        `invoking action "${this.action}"`,
                        f
                    );
                }
            }
            shouldBeInvokedPerSelf(e) {
                return this.action.eventOptions.self === !0
                    ? this.action.element === e.target
                    : !0;
            }
            willBeInvokedByEvent(e) {
                let t = e.target;
                return this.element === t
                    ? !0
                    : t instanceof Element && this.element.contains(t)
                    ? this.scope.containsElement(t)
                    : this.scope.containsElement(this.action.element);
            }
            get controller() {
                return this.context.controller;
            }
            get methodName() {
                return this.action.methodName;
            }
            get element() {
                return this.scope.element;
            }
            get scope() {
                return this.context.scope;
            }
        },
        Vi = class {
            constructor(e, t) {
                (this.mutationObserverInit = {
                    attributes: !0,
                    childList: !0,
                    subtree: !0,
                }),
                    (this.element = e),
                    (this.started = !1),
                    (this.delegate = t),
                    (this.elements = new Set()),
                    (this.mutationObserver = new MutationObserver((s) =>
                        this.processMutations(s)
                    ));
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    this.mutationObserver.observe(
                        this.element,
                        this.mutationObserverInit
                    ),
                    this.refresh());
            }
            pause(e) {
                this.started &&
                    (this.mutationObserver.disconnect(), (this.started = !1)),
                    e(),
                    this.started ||
                        (this.mutationObserver.observe(
                            this.element,
                            this.mutationObserverInit
                        ),
                        (this.started = !0));
            }
            stop() {
                this.started &&
                    (this.mutationObserver.takeRecords(),
                    this.mutationObserver.disconnect(),
                    (this.started = !1));
            }
            refresh() {
                if (this.started) {
                    let e = new Set(this.matchElementsInTree());
                    for (let t of Array.from(this.elements))
                        e.has(t) || this.removeElement(t);
                    for (let t of Array.from(e)) this.addElement(t);
                }
            }
            processMutations(e) {
                if (this.started) for (let t of e) this.processMutation(t);
            }
            processMutation(e) {
                e.type == "attributes"
                    ? this.processAttributeChange(e.target, e.attributeName)
                    : e.type == "childList" &&
                      (this.processRemovedNodes(e.removedNodes),
                      this.processAddedNodes(e.addedNodes));
            }
            processAttributeChange(e, t) {
                let s = e;
                this.elements.has(s)
                    ? this.delegate.elementAttributeChanged &&
                      this.matchElement(s)
                        ? this.delegate.elementAttributeChanged(s, t)
                        : this.removeElement(s)
                    : this.matchElement(s) && this.addElement(s);
            }
            processRemovedNodes(e) {
                for (let t of Array.from(e)) {
                    let s = this.elementFromNode(t);
                    s && this.processTree(s, this.removeElement);
                }
            }
            processAddedNodes(e) {
                for (let t of Array.from(e)) {
                    let s = this.elementFromNode(t);
                    s &&
                        this.elementIsActive(s) &&
                        this.processTree(s, this.addElement);
                }
            }
            matchElement(e) {
                return this.delegate.matchElement(e);
            }
            matchElementsInTree(e = this.element) {
                return this.delegate.matchElementsInTree(e);
            }
            processTree(e, t) {
                for (let s of this.matchElementsInTree(e)) t.call(this, s);
            }
            elementFromNode(e) {
                if (e.nodeType == Node.ELEMENT_NODE) return e;
            }
            elementIsActive(e) {
                return e.isConnected != this.element.isConnected
                    ? !1
                    : this.element.contains(e);
            }
            addElement(e) {
                this.elements.has(e) ||
                    (this.elementIsActive(e) &&
                        (this.elements.add(e),
                        this.delegate.elementMatched &&
                            this.delegate.elementMatched(e)));
            }
            removeElement(e) {
                this.elements.has(e) &&
                    (this.elements.delete(e),
                    this.delegate.elementUnmatched &&
                        this.delegate.elementUnmatched(e));
            }
        },
        _i = class {
            constructor(e, t, s) {
                (this.attributeName = t),
                    (this.delegate = s),
                    (this.elementObserver = new Vi(e, this));
            }
            get element() {
                return this.elementObserver.element;
            }
            get selector() {
                return `[${this.attributeName}]`;
            }
            start() {
                this.elementObserver.start();
            }
            pause(e) {
                this.elementObserver.pause(e);
            }
            stop() {
                this.elementObserver.stop();
            }
            refresh() {
                this.elementObserver.refresh();
            }
            get started() {
                return this.elementObserver.started;
            }
            matchElement(e) {
                return e.hasAttribute(this.attributeName);
            }
            matchElementsInTree(e) {
                let t = this.matchElement(e) ? [e] : [],
                    s = Array.from(e.querySelectorAll(this.selector));
                return t.concat(s);
            }
            elementMatched(e) {
                this.delegate.elementMatchedAttribute &&
                    this.delegate.elementMatchedAttribute(
                        e,
                        this.attributeName
                    );
            }
            elementUnmatched(e) {
                this.delegate.elementUnmatchedAttribute &&
                    this.delegate.elementUnmatchedAttribute(
                        e,
                        this.attributeName
                    );
            }
            elementAttributeChanged(e, t) {
                this.delegate.elementAttributeValueChanged &&
                    this.attributeName == t &&
                    this.delegate.elementAttributeValueChanged(e, t);
            }
        },
        Ui = class {
            constructor(e, t) {
                (this.element = e),
                    (this.delegate = t),
                    (this.started = !1),
                    (this.stringMap = new Map()),
                    (this.mutationObserver = new MutationObserver((s) =>
                        this.processMutations(s)
                    ));
            }
            start() {
                this.started ||
                    ((this.started = !0),
                    this.mutationObserver.observe(this.element, {
                        attributes: !0,
                        attributeOldValue: !0,
                    }),
                    this.refresh());
            }
            stop() {
                this.started &&
                    (this.mutationObserver.takeRecords(),
                    this.mutationObserver.disconnect(),
                    (this.started = !1));
            }
            refresh() {
                if (this.started)
                    for (let e of this.knownAttributeNames)
                        this.refreshAttribute(e, null);
            }
            processMutations(e) {
                if (this.started) for (let t of e) this.processMutation(t);
            }
            processMutation(e) {
                let t = e.attributeName;
                t && this.refreshAttribute(t, e.oldValue);
            }
            refreshAttribute(e, t) {
                let s = this.delegate.getStringMapKeyForAttribute(e);
                if (s != null) {
                    this.stringMap.has(e) || this.stringMapKeyAdded(s, e);
                    let r = this.element.getAttribute(e);
                    if (
                        (this.stringMap.get(e) != r &&
                            this.stringMapValueChanged(r, s, t),
                        r == null)
                    ) {
                        let o = this.stringMap.get(e);
                        this.stringMap.delete(e),
                            o && this.stringMapKeyRemoved(s, e, o);
                    } else this.stringMap.set(e, r);
                }
            }
            stringMapKeyAdded(e, t) {
                this.delegate.stringMapKeyAdded &&
                    this.delegate.stringMapKeyAdded(e, t);
            }
            stringMapValueChanged(e, t, s) {
                this.delegate.stringMapValueChanged &&
                    this.delegate.stringMapValueChanged(e, t, s);
            }
            stringMapKeyRemoved(e, t, s) {
                this.delegate.stringMapKeyRemoved &&
                    this.delegate.stringMapKeyRemoved(e, t, s);
            }
            get knownAttributeNames() {
                return Array.from(
                    new Set(
                        this.currentAttributeNames.concat(
                            this.recordedAttributeNames
                        )
                    )
                );
            }
            get currentAttributeNames() {
                return Array.from(this.element.attributes).map((e) => e.name);
            }
            get recordedAttributeNames() {
                return Array.from(this.stringMap.keys());
            }
        };
    function cn(i, e, t) {
        Wi(i, e).add(t);
    }
    function ln(i, e, t) {
        Wi(i, e).delete(t), hn(i, e);
    }
    function Wi(i, e) {
        let t = i.get(e);
        return t || ((t = new Set()), i.set(e, t)), t;
    }
    function hn(i, e) {
        let t = i.get(e);
        t != null && t.size == 0 && i.delete(e);
    }
    var Ie = class {
        constructor() {
            this.valuesByKey = new Map();
        }
        get keys() {
            return Array.from(this.valuesByKey.keys());
        }
        get values() {
            return Array.from(this.valuesByKey.values()).reduce(
                (t, s) => t.concat(Array.from(s)),
                []
            );
        }
        get size() {
            return Array.from(this.valuesByKey.values()).reduce(
                (t, s) => t + s.size,
                0
            );
        }
        add(e, t) {
            cn(this.valuesByKey, e, t);
        }
        delete(e, t) {
            ln(this.valuesByKey, e, t);
        }
        has(e, t) {
            let s = this.valuesByKey.get(e);
            return s != null && s.has(t);
        }
        hasKey(e) {
            return this.valuesByKey.has(e);
        }
        hasValue(e) {
            return Array.from(this.valuesByKey.values()).some((s) => s.has(e));
        }
        getValuesForKey(e) {
            let t = this.valuesByKey.get(e);
            return t ? Array.from(t) : [];
        }
        getKeysForValue(e) {
            return Array.from(this.valuesByKey)
                .filter(([t, s]) => s.has(e))
                .map(([t, s]) => t);
        }
    };
    var vt = class {
        constructor(e, t, s) {
            (this.attributeObserver = new _i(e, t, this)),
                (this.delegate = s),
                (this.tokensByElement = new Ie());
        }
        get started() {
            return this.attributeObserver.started;
        }
        start() {
            this.attributeObserver.start();
        }
        pause(e) {
            this.attributeObserver.pause(e);
        }
        stop() {
            this.attributeObserver.stop();
        }
        refresh() {
            this.attributeObserver.refresh();
        }
        get element() {
            return this.attributeObserver.element;
        }
        get attributeName() {
            return this.attributeObserver.attributeName;
        }
        elementMatchedAttribute(e) {
            this.tokensMatched(this.readTokensForElement(e));
        }
        elementAttributeValueChanged(e) {
            let [t, s] = this.refreshTokensForElement(e);
            this.tokensUnmatched(t), this.tokensMatched(s);
        }
        elementUnmatchedAttribute(e) {
            this.tokensUnmatched(this.tokensByElement.getValuesForKey(e));
        }
        tokensMatched(e) {
            e.forEach((t) => this.tokenMatched(t));
        }
        tokensUnmatched(e) {
            e.forEach((t) => this.tokenUnmatched(t));
        }
        tokenMatched(e) {
            this.delegate.tokenMatched(e),
                this.tokensByElement.add(e.element, e);
        }
        tokenUnmatched(e) {
            this.delegate.tokenUnmatched(e),
                this.tokensByElement.delete(e.element, e);
        }
        refreshTokensForElement(e) {
            let t = this.tokensByElement.getValuesForKey(e),
                s = this.readTokensForElement(e),
                r = dn(t, s).findIndex(([o, h]) => !fn(o, h));
            return r == -1 ? [[], []] : [t.slice(r), s.slice(r)];
        }
        readTokensForElement(e) {
            let t = this.attributeName,
                s = e.getAttribute(t) || "";
            return un(s, e, t);
        }
    };
    function un(i, e, t) {
        return i
            .trim()
            .split(/\s+/)
            .filter((s) => s.length)
            .map((s, r) => ({
                element: e,
                attributeName: t,
                content: s,
                index: r,
            }));
    }
    function dn(i, e) {
        let t = Math.max(i.length, e.length);
        return Array.from({ length: t }, (s, r) => [i[r], e[r]]);
    }
    function fn(i, e) {
        return i && e && i.index == e.index && i.content == e.content;
    }
    var yt = class {
            constructor(e, t, s) {
                (this.tokenListObserver = new vt(e, t, this)),
                    (this.delegate = s),
                    (this.parseResultsByToken = new WeakMap()),
                    (this.valuesByTokenByElement = new WeakMap());
            }
            get started() {
                return this.tokenListObserver.started;
            }
            start() {
                this.tokenListObserver.start();
            }
            stop() {
                this.tokenListObserver.stop();
            }
            refresh() {
                this.tokenListObserver.refresh();
            }
            get element() {
                return this.tokenListObserver.element;
            }
            get attributeName() {
                return this.tokenListObserver.attributeName;
            }
            tokenMatched(e) {
                let { element: t } = e,
                    { value: s } = this.fetchParseResultForToken(e);
                s &&
                    (this.fetchValuesByTokenForElement(t).set(e, s),
                    this.delegate.elementMatchedValue(t, s));
            }
            tokenUnmatched(e) {
                let { element: t } = e,
                    { value: s } = this.fetchParseResultForToken(e);
                s &&
                    (this.fetchValuesByTokenForElement(t).delete(e),
                    this.delegate.elementUnmatchedValue(t, s));
            }
            fetchParseResultForToken(e) {
                let t = this.parseResultsByToken.get(e);
                return (
                    t ||
                        ((t = this.parseToken(e)),
                        this.parseResultsByToken.set(e, t)),
                    t
                );
            }
            fetchValuesByTokenForElement(e) {
                let t = this.valuesByTokenByElement.get(e);
                return (
                    t ||
                        ((t = new Map()),
                        this.valuesByTokenByElement.set(e, t)),
                    t
                );
            }
            parseToken(e) {
                try {
                    return { value: this.delegate.parseValueForToken(e) };
                } catch (t) {
                    return { error: t };
                }
            }
        },
        zi = class {
            constructor(e, t) {
                (this.context = e),
                    (this.delegate = t),
                    (this.bindingsByAction = new Map());
            }
            start() {
                this.valueListObserver ||
                    ((this.valueListObserver = new yt(
                        this.element,
                        this.actionAttribute,
                        this
                    )),
                    this.valueListObserver.start());
            }
            stop() {
                this.valueListObserver &&
                    (this.valueListObserver.stop(),
                    delete this.valueListObserver,
                    this.disconnectAllActions());
            }
            get element() {
                return this.context.element;
            }
            get identifier() {
                return this.context.identifier;
            }
            get actionAttribute() {
                return this.schema.actionAttribute;
            }
            get schema() {
                return this.context.schema;
            }
            get bindings() {
                return Array.from(this.bindingsByAction.values());
            }
            connectAction(e) {
                let t = new $i(this.context, e);
                this.bindingsByAction.set(e, t),
                    this.delegate.bindingConnected(t);
            }
            disconnectAction(e) {
                let t = this.bindingsByAction.get(e);
                t &&
                    (this.bindingsByAction.delete(e),
                    this.delegate.bindingDisconnected(t));
            }
            disconnectAllActions() {
                this.bindings.forEach((e) =>
                    this.delegate.bindingDisconnected(e)
                ),
                    this.bindingsByAction.clear();
            }
            parseValueForToken(e) {
                let t = Hi.forToken(e);
                if (t.identifier == this.identifier) return t;
            }
            elementMatchedValue(e, t) {
                this.connectAction(t);
            }
            elementUnmatchedValue(e, t) {
                this.disconnectAction(t);
            }
        },
        Ki = class {
            constructor(e, t) {
                (this.context = e),
                    (this.receiver = t),
                    (this.stringMapObserver = new Ui(this.element, this)),
                    (this.valueDescriptorMap =
                        this.controller.valueDescriptorMap);
            }
            start() {
                this.stringMapObserver.start(),
                    this.invokeChangedCallbacksForDefaultValues();
            }
            stop() {
                this.stringMapObserver.stop();
            }
            get element() {
                return this.context.element;
            }
            get controller() {
                return this.context.controller;
            }
            getStringMapKeyForAttribute(e) {
                if (e in this.valueDescriptorMap)
                    return this.valueDescriptorMap[e].name;
            }
            stringMapKeyAdded(e, t) {
                let s = this.valueDescriptorMap[t];
                this.hasValue(e) ||
                    this.invokeChangedCallback(
                        e,
                        s.writer(this.receiver[e]),
                        s.writer(s.defaultValue)
                    );
            }
            stringMapValueChanged(e, t, s) {
                let r = this.valueDescriptorNameMap[t];
                e !== null &&
                    (s === null && (s = r.writer(r.defaultValue)),
                    this.invokeChangedCallback(t, e, s));
            }
            stringMapKeyRemoved(e, t, s) {
                let r = this.valueDescriptorNameMap[e];
                this.hasValue(e)
                    ? this.invokeChangedCallback(
                          e,
                          r.writer(this.receiver[e]),
                          s
                      )
                    : this.invokeChangedCallback(
                          e,
                          r.writer(r.defaultValue),
                          s
                      );
            }
            invokeChangedCallbacksForDefaultValues() {
                for (let { key: e, name: t, defaultValue: s, writer: r } of this
                    .valueDescriptors)
                    s != null &&
                        !this.controller.data.has(e) &&
                        this.invokeChangedCallback(t, r(s), void 0);
            }
            invokeChangedCallback(e, t, s) {
                let r = `${e}Changed`,
                    o = this.receiver[r];
                if (typeof o == "function") {
                    let h = this.valueDescriptorNameMap[e];
                    try {
                        let p = h.reader(t),
                            b = s;
                        s && (b = h.reader(s)), o.call(this.receiver, p, b);
                    } catch (p) {
                        throw p instanceof TypeError
                            ? new TypeError(
                                  `Stimulus Value "${this.context.identifier}.${h.name}" - ${p.message}`
                              )
                            : p;
                    }
                }
            }
            get valueDescriptors() {
                let { valueDescriptorMap: e } = this;
                return Object.keys(e).map((t) => e[t]);
            }
            get valueDescriptorNameMap() {
                let e = {};
                return (
                    Object.keys(this.valueDescriptorMap).forEach((t) => {
                        let s = this.valueDescriptorMap[t];
                        e[s.name] = s;
                    }),
                    e
                );
            }
            hasValue(e) {
                let t = this.valueDescriptorNameMap[e],
                    s = `has${Fe(t.name)}`;
                return this.receiver[s];
            }
        },
        Xi = class {
            constructor(e, t) {
                (this.context = e),
                    (this.delegate = t),
                    (this.targetsByName = new Ie());
            }
            start() {
                this.tokenListObserver ||
                    ((this.tokenListObserver = new vt(
                        this.element,
                        this.attributeName,
                        this
                    )),
                    this.tokenListObserver.start());
            }
            stop() {
                this.tokenListObserver &&
                    (this.disconnectAllTargets(),
                    this.tokenListObserver.stop(),
                    delete this.tokenListObserver);
            }
            tokenMatched({ element: e, content: t }) {
                this.scope.containsElement(e) && this.connectTarget(e, t);
            }
            tokenUnmatched({ element: e, content: t }) {
                this.disconnectTarget(e, t);
            }
            connectTarget(e, t) {
                var s;
                this.targetsByName.has(t, e) ||
                    (this.targetsByName.add(t, e),
                    (s = this.tokenListObserver) === null ||
                        s === void 0 ||
                        s.pause(() => this.delegate.targetConnected(e, t)));
            }
            disconnectTarget(e, t) {
                var s;
                this.targetsByName.has(t, e) &&
                    (this.targetsByName.delete(t, e),
                    (s = this.tokenListObserver) === null ||
                        s === void 0 ||
                        s.pause(() => this.delegate.targetDisconnected(e, t)));
            }
            disconnectAllTargets() {
                for (let e of this.targetsByName.keys)
                    for (let t of this.targetsByName.getValuesForKey(e))
                        this.disconnectTarget(t, e);
            }
            get attributeName() {
                return `data-${this.context.identifier}-target`;
            }
            get element() {
                return this.context.element;
            }
            get scope() {
                return this.context.scope;
            }
        },
        Ji = class {
            constructor(e, t) {
                (this.logDebugActivity = (s, r = {}) => {
                    let { identifier: o, controller: h, element: p } = this;
                    (r = Object.assign(
                        { identifier: o, controller: h, element: p },
                        r
                    )),
                        this.application.logDebugActivity(
                            this.identifier,
                            s,
                            r
                        );
                }),
                    (this.module = e),
                    (this.scope = t),
                    (this.controller = new e.controllerConstructor(this)),
                    (this.bindingObserver = new zi(this, this.dispatcher)),
                    (this.valueObserver = new Ki(this, this.controller)),
                    (this.targetObserver = new Xi(this, this));
                try {
                    this.controller.initialize(),
                        this.logDebugActivity("initialize");
                } catch (s) {
                    this.handleError(s, "initializing controller");
                }
            }
            connect() {
                this.bindingObserver.start(),
                    this.valueObserver.start(),
                    this.targetObserver.start();
                try {
                    this.controller.connect(), this.logDebugActivity("connect");
                } catch (e) {
                    this.handleError(e, "connecting controller");
                }
            }
            disconnect() {
                try {
                    this.controller.disconnect(),
                        this.logDebugActivity("disconnect");
                } catch (e) {
                    this.handleError(e, "disconnecting controller");
                }
                this.targetObserver.stop(),
                    this.valueObserver.stop(),
                    this.bindingObserver.stop();
            }
            get application() {
                return this.module.application;
            }
            get identifier() {
                return this.module.identifier;
            }
            get schema() {
                return this.application.schema;
            }
            get dispatcher() {
                return this.application.dispatcher;
            }
            get element() {
                return this.scope.element;
            }
            get parentElement() {
                return this.element.parentElement;
            }
            handleError(e, t, s = {}) {
                let { identifier: r, controller: o, element: h } = this;
                (s = Object.assign(
                    { identifier: r, controller: o, element: h },
                    s
                )),
                    this.application.handleError(e, `Error ${t}`, s);
            }
            targetConnected(e, t) {
                this.invokeControllerMethod(`${t}TargetConnected`, e);
            }
            targetDisconnected(e, t) {
                this.invokeControllerMethod(`${t}TargetDisconnected`, e);
            }
            invokeControllerMethod(e, ...t) {
                let s = this.controller;
                typeof s[e] == "function" && s[e](...t);
            }
        };
    function wt(i, e) {
        let t = Gi(i);
        return Array.from(
            t.reduce(
                (s, r) => (mn(r, e).forEach((o) => s.add(o)), s),
                new Set()
            )
        );
    }
    function pn(i, e) {
        return Gi(i).reduce((s, r) => (s.push(...gn(r, e)), s), []);
    }
    function Gi(i) {
        let e = [];
        for (; i; ) e.push(i), (i = Object.getPrototypeOf(i));
        return e.reverse();
    }
    function mn(i, e) {
        let t = i[e];
        return Array.isArray(t) ? t : [];
    }
    function gn(i, e) {
        let t = i[e];
        return t ? Object.keys(t).map((s) => [s, t[s]]) : [];
    }
    function bn(i) {
        return vn(i, yn(i));
    }
    function vn(i, e) {
        let t = Cn(i),
            s = wn(i.prototype, e);
        return Object.defineProperties(t.prototype, s), t;
    }
    function yn(i) {
        return wt(i, "blessings").reduce((t, s) => {
            let r = s(i);
            for (let o in r) {
                let h = t[o] || {};
                t[o] = Object.assign(h, r[o]);
            }
            return t;
        }, {});
    }
    function wn(i, e) {
        return Sn(e).reduce((t, s) => {
            let r = En(i, e, s);
            return r && Object.assign(t, { [s]: r }), t;
        }, {});
    }
    function En(i, e, t) {
        let s = Object.getOwnPropertyDescriptor(i, t);
        if (!(s && "value" in s)) {
            let o = Object.getOwnPropertyDescriptor(e, t).value;
            return s && ((o.get = s.get || o.get), (o.set = s.set || o.set)), o;
        }
    }
    var Sn = (() =>
            typeof Object.getOwnPropertySymbols == "function"
                ? (i) => [
                      ...Object.getOwnPropertyNames(i),
                      ...Object.getOwnPropertySymbols(i),
                  ]
                : Object.getOwnPropertyNames)(),
        Cn = (() => {
            function i(t) {
                function s() {
                    return Reflect.construct(t, arguments, new.target);
                }
                return (
                    (s.prototype = Object.create(t.prototype, {
                        constructor: { value: s },
                    })),
                    Reflect.setPrototypeOf(s, t),
                    s
                );
            }
            function e() {
                let s = i(function () {
                    this.a.call(this);
                });
                return (s.prototype.a = function () {}), new s();
            }
            try {
                return e(), i;
            } catch {
                return (s) => class extends s {};
            }
        })();
    function Tn(i) {
        return {
            identifier: i.identifier,
            controllerConstructor: bn(i.controllerConstructor),
        };
    }
    var Qi = class {
            constructor(e, t) {
                (this.application = e),
                    (this.definition = Tn(t)),
                    (this.contextsByScope = new WeakMap()),
                    (this.connectedContexts = new Set());
            }
            get identifier() {
                return this.definition.identifier;
            }
            get controllerConstructor() {
                return this.definition.controllerConstructor;
            }
            get contexts() {
                return Array.from(this.connectedContexts);
            }
            connectContextForScope(e) {
                let t = this.fetchContextForScope(e);
                this.connectedContexts.add(t), t.connect();
            }
            disconnectContextForScope(e) {
                let t = this.contextsByScope.get(e);
                t && (this.connectedContexts.delete(t), t.disconnect());
            }
            fetchContextForScope(e) {
                let t = this.contextsByScope.get(e);
                return (
                    t ||
                        ((t = new Ji(this, e)), this.contextsByScope.set(e, t)),
                    t
                );
            }
        },
        Yi = class {
            constructor(e) {
                this.scope = e;
            }
            has(e) {
                return this.data.has(this.getDataKey(e));
            }
            get(e) {
                return this.getAll(e)[0];
            }
            getAll(e) {
                let t = this.data.get(this.getDataKey(e)) || "";
                return nn(t);
            }
            getAttributeName(e) {
                return this.data.getAttributeNameForKey(this.getDataKey(e));
            }
            getDataKey(e) {
                return `${e}-class`;
            }
            get data() {
                return this.scope.data;
            }
        },
        Zi = class {
            constructor(e) {
                this.scope = e;
            }
            get element() {
                return this.scope.element;
            }
            get identifier() {
                return this.scope.identifier;
            }
            get(e) {
                let t = this.getAttributeNameForKey(e);
                return this.element.getAttribute(t);
            }
            set(e, t) {
                let s = this.getAttributeNameForKey(e);
                return this.element.setAttribute(s, t), this.get(e);
            }
            has(e) {
                let t = this.getAttributeNameForKey(e);
                return this.element.hasAttribute(t);
            }
            delete(e) {
                if (this.has(e)) {
                    let t = this.getAttributeNameForKey(e);
                    return this.element.removeAttribute(t), !0;
                } else return !1;
            }
            getAttributeNameForKey(e) {
                return `data-${this.identifier}-${Ni(e)}`;
            }
        },
        es = class {
            constructor(e) {
                (this.warnedKeysByObject = new WeakMap()), (this.logger = e);
            }
            warn(e, t, s) {
                let r = this.warnedKeysByObject.get(e);
                r || ((r = new Set()), this.warnedKeysByObject.set(e, r)),
                    r.has(t) || (r.add(t), this.logger.warn(s, e));
            }
        };
    function Et(i, e) {
        return `[${i}~="${e}"]`;
    }
    var ts = class {
            constructor(e) {
                this.scope = e;
            }
            get element() {
                return this.scope.element;
            }
            get identifier() {
                return this.scope.identifier;
            }
            get schema() {
                return this.scope.schema;
            }
            has(e) {
                return this.find(e) != null;
            }
            find(...e) {
                return e.reduce(
                    (t, s) =>
                        t || this.findTarget(s) || this.findLegacyTarget(s),
                    void 0
                );
            }
            findAll(...e) {
                return e.reduce(
                    (t, s) => [
                        ...t,
                        ...this.findAllTargets(s),
                        ...this.findAllLegacyTargets(s),
                    ],
                    []
                );
            }
            findTarget(e) {
                let t = this.getSelectorForTargetName(e);
                return this.scope.findElement(t);
            }
            findAllTargets(e) {
                let t = this.getSelectorForTargetName(e);
                return this.scope.findAllElements(t);
            }
            getSelectorForTargetName(e) {
                let t = this.schema.targetAttributeForScope(this.identifier);
                return Et(t, e);
            }
            findLegacyTarget(e) {
                let t = this.getLegacySelectorForTargetName(e);
                return this.deprecate(this.scope.findElement(t), e);
            }
            findAllLegacyTargets(e) {
                let t = this.getLegacySelectorForTargetName(e);
                return this.scope
                    .findAllElements(t)
                    .map((s) => this.deprecate(s, e));
            }
            getLegacySelectorForTargetName(e) {
                let t = `${this.identifier}.${e}`;
                return Et(this.schema.targetAttribute, t);
            }
            deprecate(e, t) {
                if (e) {
                    let { identifier: s } = this,
                        r = this.schema.targetAttribute,
                        o = this.schema.targetAttributeForScope(s);
                    this.guide.warn(
                        e,
                        `target:${t}`,
                        `Please replace ${r}="${s}.${t}" with ${o}="${t}". The ${r} attribute is deprecated and will be removed in a future version of Stimulus.`
                    );
                }
                return e;
            }
            get guide() {
                return this.scope.guide;
            }
        },
        is = class {
            constructor(e, t, s, r) {
                (this.targets = new ts(this)),
                    (this.classes = new Yi(this)),
                    (this.data = new Zi(this)),
                    (this.containsElement = (o) =>
                        o.closest(this.controllerSelector) === this.element),
                    (this.schema = e),
                    (this.element = t),
                    (this.identifier = s),
                    (this.guide = new es(r));
            }
            findElement(e) {
                return this.element.matches(e)
                    ? this.element
                    : this.queryElements(e).find(this.containsElement);
            }
            findAllElements(e) {
                return [
                    ...(this.element.matches(e) ? [this.element] : []),
                    ...this.queryElements(e).filter(this.containsElement),
                ];
            }
            queryElements(e) {
                return Array.from(this.element.querySelectorAll(e));
            }
            get controllerSelector() {
                return Et(this.schema.controllerAttribute, this.identifier);
            }
        },
        ss = class {
            constructor(e, t, s) {
                (this.element = e),
                    (this.schema = t),
                    (this.delegate = s),
                    (this.valueListObserver = new yt(
                        this.element,
                        this.controllerAttribute,
                        this
                    )),
                    (this.scopesByIdentifierByElement = new WeakMap()),
                    (this.scopeReferenceCounts = new WeakMap());
            }
            start() {
                this.valueListObserver.start();
            }
            stop() {
                this.valueListObserver.stop();
            }
            get controllerAttribute() {
                return this.schema.controllerAttribute;
            }
            parseValueForToken(e) {
                let { element: t, content: s } = e,
                    r = this.fetchScopesByIdentifierForElement(t),
                    o = r.get(s);
                return (
                    o ||
                        ((o = this.delegate.createScopeForElementAndIdentifier(
                            t,
                            s
                        )),
                        r.set(s, o)),
                    o
                );
            }
            elementMatchedValue(e, t) {
                let s = (this.scopeReferenceCounts.get(t) || 0) + 1;
                this.scopeReferenceCounts.set(t, s),
                    s == 1 && this.delegate.scopeConnected(t);
            }
            elementUnmatchedValue(e, t) {
                let s = this.scopeReferenceCounts.get(t);
                s &&
                    (this.scopeReferenceCounts.set(t, s - 1),
                    s == 1 && this.delegate.scopeDisconnected(t));
            }
            fetchScopesByIdentifierForElement(e) {
                let t = this.scopesByIdentifierByElement.get(e);
                return (
                    t ||
                        ((t = new Map()),
                        this.scopesByIdentifierByElement.set(e, t)),
                    t
                );
            }
        },
        rs = class {
            constructor(e) {
                (this.application = e),
                    (this.scopeObserver = new ss(
                        this.element,
                        this.schema,
                        this
                    )),
                    (this.scopesByIdentifier = new Ie()),
                    (this.modulesByIdentifier = new Map());
            }
            get element() {
                return this.application.element;
            }
            get schema() {
                return this.application.schema;
            }
            get logger() {
                return this.application.logger;
            }
            get controllerAttribute() {
                return this.schema.controllerAttribute;
            }
            get modules() {
                return Array.from(this.modulesByIdentifier.values());
            }
            get contexts() {
                return this.modules.reduce((e, t) => e.concat(t.contexts), []);
            }
            start() {
                this.scopeObserver.start();
            }
            stop() {
                this.scopeObserver.stop();
            }
            loadDefinition(e) {
                this.unloadIdentifier(e.identifier);
                let t = new Qi(this.application, e);
                this.connectModule(t);
            }
            unloadIdentifier(e) {
                let t = this.modulesByIdentifier.get(e);
                t && this.disconnectModule(t);
            }
            getContextForElementAndIdentifier(e, t) {
                let s = this.modulesByIdentifier.get(t);
                if (s) return s.contexts.find((r) => r.element == e);
            }
            handleError(e, t, s) {
                this.application.handleError(e, t, s);
            }
            createScopeForElementAndIdentifier(e, t) {
                return new is(this.schema, e, t, this.logger);
            }
            scopeConnected(e) {
                this.scopesByIdentifier.add(e.identifier, e);
                let t = this.modulesByIdentifier.get(e.identifier);
                t && t.connectContextForScope(e);
            }
            scopeDisconnected(e) {
                this.scopesByIdentifier.delete(e.identifier, e);
                let t = this.modulesByIdentifier.get(e.identifier);
                t && t.disconnectContextForScope(e);
            }
            connectModule(e) {
                this.modulesByIdentifier.set(e.identifier, e),
                    this.scopesByIdentifier
                        .getValuesForKey(e.identifier)
                        .forEach((s) => e.connectContextForScope(s));
            }
            disconnectModule(e) {
                this.modulesByIdentifier.delete(e.identifier),
                    this.scopesByIdentifier
                        .getValuesForKey(e.identifier)
                        .forEach((s) => e.disconnectContextForScope(s));
            }
        },
        An = {
            controllerAttribute: "data-controller",
            actionAttribute: "data-action",
            targetAttribute: "data-target",
            targetAttributeForScope: (i) => `data-${i}-target`,
        },
        le = class {
            constructor(e = document.documentElement, t = An) {
                (this.logger = console),
                    (this.debug = !1),
                    (this.logDebugActivity = (s, r, o = {}) => {
                        this.debug && this.logFormattedMessage(s, r, o);
                    }),
                    (this.element = e),
                    (this.schema = t),
                    (this.dispatcher = new Bi(this)),
                    (this.router = new rs(this));
            }
            static start(e, t) {
                let s = new le(e, t);
                return s.start(), s;
            }
            async start() {
                await kn(),
                    this.logDebugActivity("application", "starting"),
                    this.dispatcher.start(),
                    this.router.start(),
                    this.logDebugActivity("application", "start");
            }
            stop() {
                this.logDebugActivity("application", "stopping"),
                    this.dispatcher.stop(),
                    this.router.stop(),
                    this.logDebugActivity("application", "stop");
            }
            register(e, t) {
                this.load({ identifier: e, controllerConstructor: t });
            }
            load(e, ...t) {
                (Array.isArray(e) ? e : [e, ...t]).forEach((r) => {
                    r.controllerConstructor.shouldLoad &&
                        this.router.loadDefinition(r);
                });
            }
            unload(e, ...t) {
                (Array.isArray(e) ? e : [e, ...t]).forEach((r) =>
                    this.router.unloadIdentifier(r)
                );
            }
            get controllers() {
                return this.router.contexts.map((e) => e.controller);
            }
            getControllerForElementAndIdentifier(e, t) {
                let s = this.router.getContextForElementAndIdentifier(e, t);
                return s ? s.controller : null;
            }
            handleError(e, t, s) {
                var r;
                this.logger.error(
                    `%s

%o

%o`,
                    t,
                    e,
                    s
                ),
                    (r = window.onerror) === null ||
                        r === void 0 ||
                        r.call(window, t, "", 0, 0, e);
            }
            logFormattedMessage(e, t, s = {}) {
                (s = Object.assign({ application: this }, s)),
                    this.logger.groupCollapsed(`${e} #${t}`),
                    this.logger.log("details:", Object.assign({}, s)),
                    this.logger.groupEnd();
            }
        };
    function kn() {
        return new Promise((i) => {
            document.readyState == "loading"
                ? document.addEventListener("DOMContentLoaded", () => i())
                : i();
        });
    }
    function Ln(i) {
        return wt(i, "classes").reduce((t, s) => Object.assign(t, xn(s)), {});
    }
    function xn(i) {
        return {
            [`${i}Class`]: {
                get() {
                    let { classes: e } = this;
                    if (e.has(i)) return e.get(i);
                    {
                        let t = e.getAttributeName(i);
                        throw new Error(`Missing attribute "${t}"`);
                    }
                },
            },
            [`${i}Classes`]: {
                get() {
                    return this.classes.getAll(i);
                },
            },
            [`has${Fe(i)}Class`]: {
                get() {
                    return this.classes.has(i);
                },
            },
        };
    }
    function Rn(i) {
        return wt(i, "targets").reduce((t, s) => Object.assign(t, Mn(s)), {});
    }
    function Mn(i) {
        return {
            [`${i}Target`]: {
                get() {
                    let e = this.targets.find(i);
                    if (e) return e;
                    throw new Error(
                        `Missing target element "${i}" for "${this.identifier}" controller`
                    );
                },
            },
            [`${i}Targets`]: {
                get() {
                    return this.targets.findAll(i);
                },
            },
            [`has${Fe(i)}Target`]: {
                get() {
                    return this.targets.has(i);
                },
            },
        };
    }
    function Pn(i) {
        let e = pn(i, "values"),
            t = {
                valueDescriptorMap: {
                    get() {
                        return e.reduce((s, r) => {
                            let o = ns(r, this.identifier),
                                h = this.data.getAttributeNameForKey(o.key);
                            return Object.assign(s, { [h]: o });
                        }, {});
                    },
                },
            };
        return e.reduce((s, r) => Object.assign(s, On(r)), t);
    }
    function On(i, e) {
        let t = ns(i, e),
            { key: s, name: r, reader: o, writer: h } = t;
        return {
            [r]: {
                get() {
                    let p = this.data.get(s);
                    return p !== null ? o(p) : t.defaultValue;
                },
                set(p) {
                    p === void 0 ? this.data.delete(s) : this.data.set(s, h(p));
                },
            },
            [`has${Fe(r)}`]: {
                get() {
                    return this.data.has(s) || t.hasCustomDefaultValue;
                },
            },
        };
    }
    function ns([i, e], t) {
        return Bn({ controller: t, token: i, typeDefinition: e });
    }
    function St(i) {
        switch (i) {
            case Array:
                return "array";
            case Boolean:
                return "boolean";
            case Number:
                return "number";
            case Object:
                return "object";
            case String:
                return "string";
        }
    }
    function he(i) {
        switch (typeof i) {
            case "boolean":
                return "boolean";
            case "number":
                return "number";
            case "string":
                return "string";
        }
        if (Array.isArray(i)) return "array";
        if (Object.prototype.toString.call(i) === "[object Object]")
            return "object";
    }
    function Fn(i) {
        let e = St(i.typeObject.type);
        if (!e) return;
        let t = he(i.typeObject.default);
        if (e !== t) {
            let s = i.controller ? `${i.controller}.${i.token}` : i.token;
            throw new Error(
                `The specified default value for the Stimulus Value "${s}" must match the defined type "${e}". The provided default value of "${i.typeObject.default}" is of type "${t}".`
            );
        }
        return e;
    }
    function In(i) {
        let e = Fn({
                controller: i.controller,
                token: i.token,
                typeObject: i.typeDefinition,
            }),
            t = he(i.typeDefinition),
            s = St(i.typeDefinition),
            r = e || t || s;
        if (r) return r;
        let o = i.controller ? `${i.controller}.${i.typeDefinition}` : i.token;
        throw new Error(`Unknown value type "${o}" for "${i.token}" value`);
    }
    function Dn(i) {
        let e = St(i);
        if (e) return qn[e];
        let t = i.default;
        return t !== void 0 ? t : i;
    }
    function Bn(i) {
        let e = `${Ni(i.token)}-value`,
            t = In(i);
        return {
            type: t,
            key: e,
            name: qi(e),
            get defaultValue() {
                return Dn(i.typeDefinition);
            },
            get hasCustomDefaultValue() {
                return he(i.typeDefinition) !== void 0;
            },
            reader: Nn[t],
            writer: os[t] || os.default,
        };
    }
    var qn = {
            get array() {
                return [];
            },
            boolean: !1,
            number: 0,
            get object() {
                return {};
            },
            string: "",
        },
        Nn = {
            array(i) {
                let e = JSON.parse(i);
                if (!Array.isArray(e))
                    throw new TypeError(
                        `expected value of type "array" but instead got value "${i}" of type "${he(
                            e
                        )}"`
                    );
                return e;
            },
            boolean(i) {
                return !(i == "0" || String(i).toLowerCase() == "false");
            },
            number(i) {
                return Number(i);
            },
            object(i) {
                let e = JSON.parse(i);
                if (e === null || typeof e != "object" || Array.isArray(e))
                    throw new TypeError(
                        `expected value of type "object" but instead got value "${i}" of type "${he(
                            e
                        )}"`
                    );
                return e;
            },
            string(i) {
                return i;
            },
        },
        os = { default: Hn, array: as, object: as };
    function as(i) {
        return JSON.stringify(i);
    }
    function Hn(i) {
        return `${i}`;
    }
    var C = class {
        constructor(e) {
            this.context = e;
        }
        static get shouldLoad() {
            return !0;
        }
        get application() {
            return this.context.application;
        }
        get scope() {
            return this.context.scope;
        }
        get element() {
            return this.scope.element;
        }
        get identifier() {
            return this.scope.identifier;
        }
        get targets() {
            return this.scope.targets;
        }
        get classes() {
            return this.scope.classes;
        }
        get data() {
            return this.scope.data;
        }
        initialize() {}
        connect() {}
        disconnect() {}
        dispatch(
            e,
            {
                target: t = this.element,
                detail: s = {},
                prefix: r = this.identifier,
                bubbles: o = !0,
                cancelable: h = !0,
            } = {}
        ) {
            let p = r ? `${r}:${e}` : e,
                b = new CustomEvent(p, {
                    detail: s,
                    bubbles: o,
                    cancelable: h,
                });
            return t.dispatchEvent(b), b;
        }
    };
    C.blessings = [Ln, Rn, Pn];
    C.targets = [];
    C.values = {};
    var k = le.start();
    k.debug = !1;
    window.Stimulus = k;
    function De(i, e = () => {}) {
        let t = hs(i, "transition");
        t.filter((s) => ["enter", "enter-start", "enter-end"].includes(s.value))
            .length > 0
            ? jn(i, t, e)
            : e();
    }
    function Be(i, e = () => {}) {
        let t = hs(i, "transition");
        t.filter((s) => ["leave", "leave-start", "leave-end"].includes(s.value))
            .length > 0
            ? $n(i, t, e)
            : e();
    }
    function jn(i, e, t) {
        let s = (
                e.find((h) => h.value === "enter") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== ""),
            r = (
                e.find((h) => h.value === "enter-start") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== ""),
            o = (
                e.find((h) => h.value === "enter-end") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== "");
        cs(i, s, r, o, t, () => {});
    }
    function $n(i, e, t) {
        let s = (
                e.find((h) => h.value === "leave") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== ""),
            r = (
                e.find((h) => h.value === "leave-start") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== ""),
            o = (
                e.find((h) => h.value === "leave-end") || { expression: "" }
            ).expression
                .split(" ")
                .filter((h) => h !== "");
        cs(i, s, r, o, () => {}, t);
    }
    function cs(i, e, t, s, r, o) {
        let h = i.__x_original_classes || [];
        Vn(i, {
            start() {
                i.classList.add(...t);
            },
            during() {
                i.classList.add(...e);
            },
            show() {
                r();
            },
            end() {
                i.classList.remove(...t.filter((b) => !h.includes(b))),
                    i.classList.add(...s);
            },
            hide() {
                o();
            },
            cleanup() {
                i.classList.remove(...e.filter((b) => !h.includes(b))),
                    i.classList.remove(...s.filter((b) => !h.includes(b)));
            },
        });
    }
    function Vn(i, e) {
        e.start();
        let t = "width";
        getComputedStyle(i).getPropertyValue(t),
            e.during(),
            requestAnimationFrame(() => {
                let s =
                    Number(
                        getComputedStyle(i)
                            .transitionDuration.replace(/,.*/, "")
                            .replace("s", "")
                    ) * 1e3;
                e.show(),
                    requestAnimationFrame(() => {
                        e.end(),
                            setTimeout(() => {
                                e.hide(), i.isConnected && e.cleanup();
                            }, s);
                    });
            });
    }
    var ls = /^x-transition\b/;
    function _n(i) {
        let e = i.name;
        return ls.test(e);
    }
    function hs(i, e) {
        return Array.from(i.attributes)
            .filter(_n)
            .map((t) => {
                let s = t.name,
                    r = s.match(ls),
                    o = s.match(/:([a-zA-Z\-:]+)/),
                    h = s.match(/\.[^.\]]+(?=[^\]]*$)/g) || [];
                return {
                    type: r ? "transition" : null,
                    value: o ? o[1] : null,
                    modifiers: h.map((p) => p.replace(".", "")),
                    expression: t.value,
                };
            })
            .filter((t) => (e ? t.type === e : !0));
    }
    var ue = class extends C {
        connect() {
            this.onConnectValue && this.show(),
                this.hasDelayValue &&
                    setTimeout(() => {
                        this.hide();
                    }, this.delayValue),
                (this.element[this.identifier] = this);
        }
        toggle(i) {
            i.stopPropagation(),
                this.toggleableTargets.forEach((e) => {
                    e.classList.contains("hidden")
                        ? De(e, () => e.classList.remove("hidden"))
                        : Be(e, () => e.classList.add("hidden"));
                });
        }
        clickAway(i) {
            i.stopPropagation(),
                this.toggleAreaTarget.contains(i.target) ||
                    this.toggleableTargets.forEach((e) => {
                        !e.classList.contains("hidden") &&
                        !e.dataset.revealOnClickAway
                            ? Be(e, () => e.classList.add("hidden"))
                            : e.classList.contains("hidden") &&
                              e.dataset.revealOnClickAway &&
                              De(e, () => e.classList.remove("hidden"));
                    });
        }
        show(i) {
            i !== void 0 && i.stopPropagation(),
                this.toggleableTargets.forEach((e) => {
                    e.classList.contains("hidden") &&
                        De(e, () => e.classList.remove("hidden"));
                });
        }
        hide(i) {
            i !== void 0 && i.stopPropagation(),
                this.toggleableTargets.forEach((e) => {
                    e.classList.contains("hidden") ||
                        Be(e, () => e.classList.add("hidden"));
                });
        }
        toggleRemote(i) {
            this.toggle(i),
                this.application
                    .getControllerForElementAndIdentifier(
                        document.querySelector(this.data.get("remote")),
                        "toggle"
                    )
                    .toggle(i);
        }
        hideWithKeyboard(i) {
            i.keyCode === 27 && this.hide();
        }
        teardown() {
            this.element.remove();
        }
    };
    T(ue, "targets", ["toggleable", "toggleArea"]),
        T(ue, "values", { delay: Number, onConnect: Boolean });
    var de = class extends C {
        connect() {
            this.isModalValue &&
                (this.isOnNewsletterPage()
                    ? this.showNewsletterModal()
                    : this.isModalValue &&
                      !this.isSubscribedValue &&
                      !this.popupShownValue &&
                      this.initializePopup());
        }
        isOnNewsletterPage() {
            let i = window.location.search;
            return new URLSearchParams(i).has("newsletter");
        }
        initializePopup() {
            let i = this;
            this.popupRecentlyShown() ||
                (this.popupTimeout = setTimeout(() => {
                    i.showNewsletterModal(), i.addPopupCookie();
                }, 60 * 1e3 * 2));
        }
        onSubmit(i) {
            let e = new XMLHttpRequest(),
                t = `/newsletter_subscriptions?newsletter_subscription[email]=${this.emailTarget.value}`,
                s = this.formTarget.querySelector(
                    "input[name='authenticity_token']"
                ).value;
            (e.responseType = "json"),
                e.open("POST", t),
                e.setRequestHeader("X-CSRF-Token", s);
            let r = this;
            (e.onreadystatechange = function () {
                e.readyState === XMLHttpRequest.DONE &&
                    (r.handleSuccessfulSubscription(), r.removePopupTimeout());
            }),
                e.send();
        }
        handleSuccessfulSubscription() {
            this.formTarget.insertAdjacentHTML(
                "afterend",
                this.alertTemplate()
            ),
                this.formTarget.remove();
        }
        showNewsletterModal() {
            this.application
                .getControllerForElementAndIdentifier(this.element, "toggle")
                .show();
        }
        addPopupCookie() {
            let i = new Date(),
                e = new Date();
            e.setTime(i.getTime() + 36e5 * 24 * 14),
                (document.cookie = `popup_shown = true; path=/; expires=${e.toGMTString()} SameSite=Strict`);
        }
        popupRecentlyShown() {
            return (
                document.cookie
                    .split(";")
                    .filter((i) => i.includes("popup_shown=")).length > 0
            );
        }
        removePopupTimeout() {
            if (this.isModalValue) this.clearPopupTimeout();
            else {
                let i = document.getElementById("newsletter-modal");
                i &&
                    this.application
                        .getControllerForElementAndIdentifier(i, "newsletter")
                        .clearPopupTimeout();
            }
        }
        clearPopupTimeout() {
            clearTimeout(this.popupTimeout), (this.popupTimeout = null);
        }
        alertTemplate() {
            return `
      <div class="rounded-md bg-teal-50 p-4 max-w-xl mx-auto">
        <div class="flex">
          <div class="flex-shrink-0">
            <!-- Heroicon name: solid/check-circle -->
            <svg class="h-5 w-5 text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3 flex-1 md:flex md:justify-between">
            <p class="text-sm text-teal-700">
              <strong>Thanks for subscribing!</strong> Expect an email from us shortly :)
            </p>
          </div>
        </div>
      </div>
    `;
        }
    };
    T(de, "targets", ["email", "form"]),
        T(de, "values", { isModal: Boolean, isSubscribed: Boolean });
    var qe = class extends C {
        initialize() {
            let i = { rootMargin: "100px" };
            this.intersectionObserver = new IntersectionObserver(
                (e, t) => this.processIntersectionEntries(e, t),
                i
            );
        }
        connect() {
            this.attachInstanceToThisElement(), this.lazyLoad();
        }
        disconnect() {
            this.entryTargets.forEach((i) => {
                this.intersectionObserver.unobserve(i);
            });
        }
        processIntersectionEntries(i, e) {
            i.forEach((t) => {
                t.isIntersecting &&
                    (this.loadContentFor(t.target), e.unobserve(t.target));
            });
        }
        loadContentFor(i) {
            this.preloadImage(i);
        }
        preloadImage(i) {
            let e = i.getAttribute("data-src");
            !e ||
                (this.isImage(i)
                    ? (console.log(i),
                      console.log("The above is an image"),
                      i.addEventListener(
                          "load",
                          function (t) {
                              i.removeAttribute("data-src"),
                                  i.classList.remove("opacity-0"),
                                  i.parentElement.classList.remove(
                                      "animate-pulse"
                                  ),
                                  i.parentElement.classList.remove(
                                      "bg-gray-100"
                                  );
                          },
                          { once: !0 }
                      ),
                      (i.src = e))
                    : (i.style.backgroundImage = `url("${e}")`));
        }
        needToLoadImageFor(i) {
            return i.hasAttribute("data-src");
        }
        isImage(i) {
            return i instanceof HTMLImageElement;
        }
        lazyLoad() {
            this.entryTargets.forEach((i) => {
                this.needToLoadImageFor(i) &&
                    this.intersectionObserver.observe(i);
            });
        }
        attachInstanceToThisElement() {
            this.element[
                ((i) =>
                    i
                        .split("--")
                        .slice(-1)[0]
                        .split(/[-_]/)
                        .map((e) => e.replace(/./, (t) => t.toUpperCase()))
                        .join("")
                        .replace(/^\w/, (e) => e.toLowerCase()))(
                    this.identifier
                )
            ] = this;
        }
    };
    T(qe, "targets", ["entry"]);
    var pa = It(Ct());
    var He = class {
        constructor(e) {
            this.response = e;
        }
        get statusCode() {
            return this.response.status;
        }
        get redirected() {
            return this.response.redirected;
        }
        get ok() {
            return this.response.ok;
        }
        get unauthenticated() {
            return this.statusCode === 401;
        }
        get unprocessableEntity() {
            return this.statusCode === 422;
        }
        get authenticationURL() {
            return this.response.headers.get("WWW-Authenticate");
        }
        get contentType() {
            return (this.response.headers.get("Content-Type") || "").replace(
                /;.*$/,
                ""
            );
        }
        get headers() {
            return this.response.headers;
        }
        get html() {
            return this.contentType.match(
                /^(application|text)\/(html|xhtml\+xml)$/
            )
                ? this.text
                : Promise.reject(
                      new Error(
                          `Expected an HTML response but got "${this.contentType}" instead`
                      )
                  );
        }
        get json() {
            return this.contentType.match(/^application\/.*json$/)
                ? this.responseJson ||
                      (this.responseJson = this.response.json())
                : Promise.reject(
                      new Error(
                          `Expected a JSON response but got "${this.contentType}" instead`
                      )
                  );
        }
        get text() {
            return (
                this.responseText || (this.responseText = this.response.text())
            );
        }
        get isTurboStream() {
            return this.contentType.match(/^text\/vnd\.turbo-stream\.html/);
        }
        async renderTurboStream() {
            if (this.isTurboStream)
                window.Turbo
                    ? await window.Turbo.renderStreamMessage(await this.text)
                    : console.warn(
                          "You must set `window.Turbo = Turbo` to automatically process Turbo Stream events with request.js"
                      );
            else
                return Promise.reject(
                    new Error(
                        `Expected a Turbo Stream response but got "${this.contentType}" instead`
                    )
                );
        }
    };
    var je = class {
        static register(e) {
            this.interceptor = e;
        }
        static get() {
            return this.interceptor;
        }
        static reset() {
            this.interceptor = void 0;
        }
    };
    function ds(i) {
        let e = document.cookie ? document.cookie.split("; ") : [],
            t = `${encodeURIComponent(i)}=`,
            s = e.find((r) => r.startsWith(t));
        if (s) {
            let r = s.split("=").slice(1).join("=");
            if (r) return decodeURIComponent(r);
        }
    }
    function fs(i) {
        let e = {};
        for (let t in i) {
            let s = i[t];
            s !== void 0 && (e[t] = s);
        }
        return e;
    }
    function Tt(i) {
        let e = document.head.querySelector(`meta[name="${i}"]`);
        return e && e.content;
    }
    function ps(i) {
        return [...i].reduce(
            (e, [t, s]) => e.concat(typeof s == "string" ? [[t, s]] : []),
            []
        );
    }
    function ms(i, e) {
        for (let [t, s] of e)
            s instanceof window.File ||
                (i.has(t) ? (i.delete(t), i.set(t, s)) : i.append(t, s));
    }
    var $e = class {
        constructor(e, t, s = {}) {
            (this.method = e),
                (this.options = s),
                (this.originalUrl = t.toString());
        }
        async perform() {
            try {
                let t = je.get();
                t && (await t(this));
            } catch (t) {
                console.error(t);
            }
            let e = new He(await window.fetch(this.url, this.fetchOptions));
            return e.unauthenticated && e.authenticationURL
                ? Promise.reject((window.location.href = e.authenticationURL))
                : (e.ok && e.isTurboStream && (await e.renderTurboStream()), e);
        }
        addHeader(e, t) {
            let s = this.additionalHeaders;
            (s[e] = t), (this.options.headers = s);
        }
        get fetchOptions() {
            return {
                method: this.method.toUpperCase(),
                headers: this.headers,
                body: this.formattedBody,
                signal: this.signal,
                credentials: "same-origin",
                redirect: this.redirect,
            };
        }
        get headers() {
            return fs(
                Object.assign(
                    {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": this.csrfToken,
                        "Content-Type": this.contentType,
                        Accept: this.accept,
                    },
                    this.additionalHeaders
                )
            );
        }
        get csrfToken() {
            return ds(Tt("csrf-param")) || Tt("csrf-token");
        }
        get contentType() {
            return this.options.contentType
                ? this.options.contentType
                : this.body == null || this.body instanceof window.FormData
                ? void 0
                : this.body instanceof window.File
                ? this.body.type
                : "application/json";
        }
        get accept() {
            switch (this.responseKind) {
                case "html":
                    return "text/html, application/xhtml+xml";
                case "turbo-stream":
                    return "text/vnd.turbo-stream.html, text/html, application/xhtml+xml";
                case "json":
                    return "application/json, application/vnd.api+json";
                default:
                    return "*/*";
            }
        }
        get body() {
            return this.options.body;
        }
        get query() {
            let e = (this.originalUrl.split("?")[1] || "").split("#")[0],
                t = new URLSearchParams(e),
                s = this.options.query;
            s instanceof window.FormData
                ? (s = ps(s))
                : s instanceof window.URLSearchParams
                ? (s = s.entries())
                : (s = Object.entries(s || {})),
                ms(t, s);
            let r = t.toString();
            return r.length > 0 ? `?${r}` : "";
        }
        get url() {
            return this.originalUrl.split("?")[0].split("#")[0] + this.query;
        }
        get responseKind() {
            return this.options.responseKind || "html";
        }
        get signal() {
            return this.options.signal;
        }
        get redirect() {
            return this.options.redirect || "follow";
        }
        get additionalHeaders() {
            return this.options.headers || {};
        }
        get formattedBody() {
            let e =
                Object.prototype.toString.call(this.body) === "[object String]";
            return this.headers["Content-Type"] === "application/json" && !e
                ? JSON.stringify(this.body)
                : this.body;
        }
    };
    async function fe(i, e) {
        return new $e("get", i, e).perform();
    }
    var Ve = class extends C {
        async loadMore(i) {
            i.preventDefault(),
                this.addLoadingIndicator(),
                (
                    await fe(this.nextTarget.dataset.nextUrl, {
                        responseKind: "turbo-stream",
                    })
                ).ok &&
                    setTimeout(() => {
                        this.lazyLoadImages(),
                            this.hasMasonryTarget && this.reinitializeMasonry();
                    }, 350);
        }
        reinitializeMasonry() {
            console.log("MASONRY CONTROLLER CALED"),
                this.application
                    .getControllerForElementAndIdentifier(
                        this.masonryTarget,
                        "masonry"
                    )
                    .reinitialize();
        }
        lazyLoadImages() {
            this.application
                .getControllerForElementAndIdentifier(
                    this.element,
                    "lazy-loader"
                )
                .lazyLoad();
        }
        addLoadingIndicator() {
            this.application
                .getControllerForElementAndIdentifier(
                    this.nextTarget,
                    "button-loader"
                )
                .load();
        }
        removeLoadingIndicator() {
            this.application
                .getControllerForElementAndIdentifier(
                    this.nextTarget,
                    "button-loader"
                )
                .unload();
        }
    };
    T(Ve, "targets", ["next", "masonry"]);
    var pe = class extends C {
        load() {
            (this.buttonTarget.style.width = `${this.buttonTarget.offsetWidth}px`),
                (this.buttonTarget.style.height = `${this.buttonTarget.offsetHeight}px`),
                (this.buttonTarget.disabled = !0),
                this.textTarget.classList.add(this.hiddenClass),
                this.loaderTarget.classList.remove(this.hiddenClass);
        }
        unload() {
            (this.buttonTarget.disabled = !1),
                this.loaderTarget.classList.add(this.hiddenClass),
                this.textTarget.classList.remove(this.hiddenClass),
                (this.buttonTarget.style.width = ""),
                (this.buttonTarget.style.height = "");
        }
    };
    T(pe, "targets", ["text", "loader", "button"]),
        T(pe, "classes", ["hidden"]);
    var me = class extends C {
        connect() {
            if (this.hasInitialQuerySelectorValue) {
                console.log(this.initialQuerySelectorValue);
                let i = document.querySelector(this.initialQuerySelectorValue);
                console.log(i),
                    setTimeout(() => {
                        this.scrollTo(i);
                    }, 400);
            }
        }
        scroll(i) {
            i.preventDefault();
            let e = i.currentTarget.getAttribute("href");
            this.scrollTo(document.querySelector(e));
        }
        scrollTo(i) {
            let e = this.hasContainerTarget ? this.containerTarget : document,
                t = { top: this.offsetTop(i), behavior: "smooth" };
            this.hasContainerTarget
                ? this.containerTarget.scroll(t)
                : scroll(t);
        }
        offsetTop(i) {
            let e = 0;
            return (
                this.hasContainerTarget
                    ? (e = i.offsetTop - this.containerTarget.offsetTop)
                    : (e = i.offsetTop),
                e - 16
            );
        }
    };
    T(me, "targets", ["container"]),
        T(me, "values", { initialQuerySelector: String });
    var Es = It(ws());
    var kt = class extends C {
        initialize() {
            document.documentElement.style.scrollBehavior = "smooth";
            let i = new Es.default("[data-controller='sticky']");
        }
    };
    var _e = class extends C {
        connect() {
            let i = document.querySelectorAll(
                '[data-controller*="flash-message"]'
            );
            if (i.length > 1) {
                let t = 0;
                i.forEach((s, r) => {
                    s.isEqualNode(this.element) &&
                        r > 0 &&
                        (this.element.style.transform = `translateY(${t}px)`),
                        (t += this.heightOf(s));
                });
            }
            this.application
                .getControllerForElementAndIdentifier(this.element, "toggle")
                .show(event),
                (this.hideTimeout = setTimeout(() => {
                    this.hide();
                }, 3e4));
        }
        disconnect() {
            clearTimeout(this.hideTimeout);
        }
        hide(i) {
            this.application
                .getControllerForElementAndIdentifier(this.element, "toggle")
                .hide(),
                setTimeout(() => {
                    let t = document.querySelectorAll(
                        '[data-controller*="flash-message"]'
                    );
                    if (t.length > 1) {
                        let s = Array.from(t).indexOf(this.element),
                            r = 0;
                        t.forEach((o, h) => {
                            o.isEqualNode(this.element) ||
                                (h > s &&
                                    (o.style.transform = `translateY(${r}px)`),
                                (r += this.heightOf(o)));
                        });
                    }
                    this.element.remove();
                }, 100);
        }
        heightOf(i) {
            let e = i.querySelector("div"),
                t = 0;
            return (
                e.classList.contains("hidden")
                    ? ((e.style.visibility = "hidden"),
                      e.classList.remove("hidden"),
                      (t = i.offsetHeight),
                      e.classList.add("hidden"),
                      (e.style.visibility = null))
                    : (t = i.offsetHeight),
                t
            );
        }
    };
    T(_e, "targets", ["container"]);
    var Xn = "https://gumroad.com/js/gumroad.js",
        Ue = class extends C {
            initialize() {
                this.gumroadScriptLoaded()
                    ? this.reinitializeGumroadScript()
                    : this.loadGumroadScript();
            }
            disconnect() {
                (window.GumroadOverlay = null),
                    this.element.removeAttribute("data-controller");
            }
            loadGumroadScript() {
                let i = document.createElement("script");
                document.head.appendChild(i),
                    document.readyState === "complete" &&
                        setTimeout(() => {
                            createGumroadOverlay();
                        }, 550),
                    (i.type = "text/javascript"),
                    (i.src = Xn),
                    this.markGumroadScriptAsLoaded();
            }
            gumroadScriptLoaded() {
                return document.documentElement.hasAttribute(
                    "data-gumroad-loaded"
                );
            }
            markGumroadScriptAsLoaded() {
                document.documentElement.setAttribute(
                    "data-gumroad-loaded",
                    !0
                );
            }
            reinitializeGumroadScript() {
                this.reinitializeAllCheckoutButtons(),
                    this.removeOldGumroadStylesheet(),
                    this.removeOldGumroadElements(),
                    createGumroadOverlay();
            }
            reinitializeAllCheckoutButtons() {
                this.checkoutTargets.forEach(function (i) {
                    let e = i.cloneNode();
                    e.appendChild(
                        document.createTextNode(i.lastChild.nodeValue)
                    ),
                        i.parentNode.replaceChild(e, i);
                });
            }
            removeOldGumroadElements() {
                let i = document.querySelector(".gumroad-loading-indicator"),
                    e = document.querySelector(".gumroad-scroll-container");
                i && i.remove(), e && e.remove();
            }
            removeOldGumroadStylesheet() {
                document.querySelectorAll("style").forEach(function (e) {
                    e.innerText.match("gumroad-button") && e.remove();
                });
            }
        };
    T(Ue, "targets", ["checkout"]);
    var We = class extends C {
        connect() {
            (this.activeTabClasses = (
                this.data.get("activeTab") || "active"
            ).split(" ")),
                (this.inactiveTabClasses = (
                    this.data.get("inactiveTab") || "inactive"
                ).split(" ")),
                this.anchor &&
                    (this.index = this.tabTargets.findIndex(
                        (i) => i.id === this.anchor
                    )),
                this.showTab();
        }
        change(i) {
            i.preventDefault(),
                i.currentTarget.dataset.index
                    ? (this.index = i.currentTarget.dataset.index)
                    : i.currentTarget.dataset.id
                    ? (this.index = this.tabTargets.findIndex(
                          (e) => e.id == i.currentTarget.dataset.id
                      ))
                    : (this.index = this.tabTargets.indexOf(i.currentTarget)),
                window.dispatchEvent(new CustomEvent("tsc:tab-change"));
        }
        showTab() {
            this.tabTargets.forEach((i, e) => {
                let t = this.panelTargets[e];
                e === this.index
                    ? (t.classList.remove("hidden"),
                      i.classList.remove(...this.inactiveTabClasses),
                      i.classList.add(...this.activeTabClasses),
                      i.id && (location.hash = i.id))
                    : (t.classList.add("hidden"),
                      i.classList.remove(...this.activeTabClasses),
                      i.classList.add(...this.inactiveTabClasses));
            });
        }
        get index() {
            return parseInt(this.data.get("index") || 0);
        }
        set index(i) {
            this.data.set("index", i >= 0 ? i : 0), this.showTab();
        }
        get anchor() {
            return document.URL.split("#").length > 1
                ? document.URL.split("#")[1]
                : null;
        }
    };
    T(We, "targets", ["tab", "panel"]);
    var ge = class extends C {
        connect() {
            let i = this.togglerTargets.filter(
                (e) => window.getComputedStyle(e).display !== "none"
            )[0];
            console.log(i), this.toggleClasses(i);
        }
        toggle(i) {
            this.toggleClasses(i.currentTarget);
        }
        toggleClasses(i) {
            i.hasAttribute("data-toggle-classes") &&
                (this.activeToggleableClassesValue =
                    i.dataset.toggleClasses.split(" ")),
                this.togglerTargets
                    .filter((e) => e != i)
                    .forEach((e) => {
                        this.activeTogglerClassesValue.forEach((t) => {
                            e.classList.remove(t);
                        }),
                            this.inactiveTogglerClassesValue.forEach((t) => {
                                e.classList.add(t);
                            });
                    }),
                this.inactiveTogglerClassesValue.forEach((e) => {
                    i.classList.remove(e);
                }),
                this.activeTogglerClassesValue.forEach((e) => {
                    i.classList.add(e);
                });
        }
        activeToggleableClassesValueChanged(i, e) {
            console.log("Toggle classes"),
                i &&
                    this.toggleableTargets.forEach((t) => {
                        i.forEach((s) => {
                            t.classList.add(s);
                        });
                    }),
                e &&
                    this.toggleableTargets.forEach((t) => {
                        e.forEach((s) => {
                            t.classList.remove(s);
                        });
                    });
        }
    };
    T(ge, "targets", ["toggler", "toggleable"]),
        T(ge, "values", {
            activeTogglerClasses: Array,
            inactiveTogglerClasses: Array,
            activeToggleableClasses: Array,
        });
    var be = class extends C {
        initialize() {
            this.resizeObserver = new ResizeObserver((i, e) =>
                this.processResizeEntries(i, e)
            );
        }
        connect() {
            this.isOpenValue &&
                setTimeout(() => {
                    this.open();
                }, 100),
                this.resizeObserver.observe(
                    this.contentTarget.firstElementChild
                );
        }
        disconnect() {
            this.resizeObserver.disconnect();
        }
        processResizeEntries(i, e) {
            i.forEach((t) => {
                this.isOpenValue &&
                    (this.contentTarget.style.maxHeight = `${t.target.scrollHeight}px`);
            });
        }
        toggle() {
            this.isOpenValue
                ? (this.chevronTarget.classList.remove("rotate-180"),
                  (this.contentTarget.style.maxHeight = ""))
                : this.open(),
                (this.isOpenValue = !this.isOpenValue);
        }
        open() {
            this.chevronTarget.classList.add("rotate-180"), this.setMaxHeight();
        }
        setMaxHeight() {
            let i = this.contentTarget;
            i.style.maxHeight = `${i.scrollHeight}px`;
        }
    };
    T(be, "targets", ["content", "chevron"]),
        T(be, "values", { isOpen: Boolean });
    async function z(i, e = null) {
        i.classList.remove("hidden"), await Ss("enter", i, e);
    }
    async function K(i, e = null) {
        await Ss("leave", i, e), i.classList.add("hidden");
    }
    async function Ss(i, e, t) {
        let s = e.dataset,
            r = t ? `${t}-${i}` : i,
            o = `transition${i.charAt(0).toUpperCase() + i.slice(1)}`,
            h = s[o] ? s[o].split(" ") : [r],
            p = s[`${o}Start`] ? s[`${o}Start`].split(" ") : [`${r}-start`],
            b = s[`${o}End`] ? s[`${o}End`].split(" ") : [`${r}-end`];
        Lt(e, h),
            Lt(e, p),
            await Jn(),
            xt(e, p),
            Lt(e, b),
            await Gn(e),
            xt(e, b),
            xt(e, h);
    }
    function Lt(i, e) {
        i.classList.add(...e);
    }
    function xt(i, e) {
        i.classList.remove(...e);
    }
    function Jn() {
        return new Promise((i) => {
            requestAnimationFrame(() => {
                requestAnimationFrame(i);
            });
        });
    }
    function Gn(i) {
        return new Promise((e) => {
            let t = getComputedStyle(i).transitionDuration.split(",")[0],
                s = Number(t.replace("s", "")) * 1e3;
            setTimeout(() => {
                e();
            }, s);
        });
    }
    var ze = class extends C {
        disconnect() {
            document.removeEventListener("click", this.handleClick);
        }
        show() {
            this.containerTarget.classList.remove("hidden"),
                Promise.all([
                    z(this.backdropTarget),
                    z(this.panelTarget),
                    z(this.sidebarTarget),
                ]).then(() => {
                    document.addEventListener("click", this.handleClick);
                });
        }
        hide() {
            Promise.all([
                K(this.backdropTarget),
                K(this.panelTarget),
                K(this.sidebarTarget),
            ]).then(() => {
                this.containerTarget.classList.add("hidden"),
                    document.removeEventListener("click", this.handleClick);
            });
        }
        handleClick = (i) => {
            console.log("handling click"),
                this.panelTarget.contains(i.target) || this.hide();
        };
    };
    T(ze, "targets", ["container", "backdrop", "panel", "sidebar"]);
    var Ke = class extends C {
        connect() {
            z(this.wrapperTarget),
                z(this.bodyTarget),
                document.addEventListener(
                    "turbo:submit-end",
                    this.handleSubmit
                );
        }
        disconnect() {
            document.removeEventListener("turbo:submit-end", this.handleSubmit);
        }
        close() {
            K(this.wrapperTarget),
                K(this.bodyTarget).then(() => {
                    this.element.remove();
                }),
                (this.element.closest("turbo-frame").src = void 0);
        }
        handleKeyup(i) {
            i.code == "Escape" && this.close();
        }
        handleSubmit = (i) => {
            console.log("CLOSING MODAL"), i.detail.success && this.close();
        };
    };
    T(Ke, "targets", ["wrapper", "body"]);
    var Cs = {
            responsive: !0,
            breakpointCols: {
                "min-width: 1500px": 6,
                "min-width: 1200px": 5,
                "min-width: 992px": 4,
                "min-width: 768px": 3,
                "min-width: 576px": 2,
            },
            numCols: 4,
        },
        Rt = null,
        X = {},
        ve = [];
    function Qn(i, e = {}) {
        return (
            typeof i == "string"
                ? (ve = document.querySelectorAll(i))
                : (ve = i),
            (X = Object.assign(Cs, e)),
            ve.forEach(function (t) {
                Yn(t), Mt(t);
            }),
            Zn(),
            this
        );
    }
    function Yn(i) {
        i.classList.add("flexmasonry"),
            X.responsive && i.classList.add("flexmasonry-responsive"),
            Ls(i),
            Array.from(i.children).forEach(function (e) {
                e.classList.add("flexmasonry-item");
            }),
            ks(i);
    }
    function Ts() {
        ve.forEach(function (i) {
            Mt(i);
        });
    }
    function As() {
        Rt && window.cancelAnimationFrame(Rt),
            (Rt = window.requestAnimationFrame(function () {
                Rs();
            }));
    }
    function Zn() {
        window.addEventListener("load", Ts),
            window.addEventListener("resize", As);
    }
    function eo() {
        window.removeEventListener("load", Ts),
            window.removeEventListener("resize", As);
    }
    function Mt(i) {
        if (ee() < 2) {
            i.style.removeProperty("height");
            return;
        }
        let e = [];
        Array.from(i.children).forEach(function (s) {
            if (s.classList.contains("flexmasonry-break")) return;
            let r = window.getComputedStyle(s),
                o = r.getPropertyValue("order"),
                h = r.getPropertyValue("height");
            e[o - 1] || (e[o - 1] = 0), (e[o - 1] += Math.ceil(parseFloat(h)));
        });
        let t = Math.max(...e);
        i.style.height = t + "px";
    }
    function ks(i) {
        let e = i.querySelectorAll(".flexmasonry-break");
        if (Array.from(e).length !== ee() - 1)
            for (let t = 1; t < ee(); t++) {
                let s = document.createElement("div");
                s.classList.add("flexmasonry-break"),
                    s.classList.add("flexmasonry-break-" + t),
                    i.appendChild(s);
            }
    }
    function to(i) {
        let e = i.querySelectorAll(".flexmasonry-break");
        Array.from(e).length !== ee() - 1 &&
            Array.from(e).forEach(function (t) {
                t.parentNode.removeChild(t);
            });
    }
    function Ls(i) {
        i.classList.contains("flexmasonry-cols-" + ee()) ||
            ((i.className = i.className.replace(/(flexmasonry-cols-\d+)/, "")),
            i.classList.add("flexmasonry-cols-" + ee()));
    }
    function ee() {
        if (!X.responsive) return X.numCols;
        let i = Object.keys(X.breakpointCols);
        for (let e of i)
            if (window.matchMedia("(" + e + ")").matches)
                return X.breakpointCols[e];
        return 1;
    }
    function xs(i, e = {}) {
        return (X = Object.assign(Cs, e)), Ls(i), to(i), ks(i), Mt(i), this;
    }
    function Rs(i = {}) {
        return (
            ve.forEach(function (e) {
                xs(e, i);
            }),
            this
        );
    }
    function io() {
        eo();
    }
    var ye = { init: Qn, refresh: xs, refreshAll: Rs, destroyAll: io };
    var Pt = class extends C {
        connect() {
            ye.init([this.element], {
                responsive: !0,
                breakpointCols: { "min-width: 1280px": 2 },
                numCols: 1,
            });
        }
        reinitialize() {
            this.element
                .querySelectorAll("div.flexmasonry-break")
                .forEach(function (e) {
                    e.remove();
                }),
                ye.destroyAll(),
                ye.init([this.element], {
                    responsive: !0,
                    breakpointCols: { "min-width: 1280px": 2 },
                    numCols: 1,
                });
        }
        disconnect() {
            ye.destroyAll();
        }
    };
    var Ot = class extends C {
        filter = async (i) => {
            var e = i.target.dataset.url;
            console.log(e);
            let t = await fe(e, { responseKind: "turbo-stream" });
            console.log(t),
                history.pushState(
                    history.state,
                    "",
                    new URL(
                        e,
                        `${window.location.protocol}//${window.location.host}`
                    )
                );
        };
        resolveNewInputValue(i, e, t) {
            if (t) return i ? `${i}+${e}` : e;
            {
                let s = i.split("+");
                return s.length == 1 ? null : s.filter((r) => r != e).join("+");
            }
        }
    };
    k.register("toggle", ue);
    k.register("newsletter", de);
    k.register("lazy-loader", qe);
    k.register("pagination", Ve);
    k.register("button-loader", pe);
    k.register("smooth-scroll", me);
    k.register("sticky", kt);
    k.register("flash-message", _e);
    k.register("gumroad", Ue);
    k.register("tabs", We);
    k.register("class-toggler", ge);
    k.register("accordion", be);
    k.register("sidebar", ze);
    k.register("modal-form", Ke);
    k.register("masonry", Pt);
    k.register("filters", Ot);
    window.dataLayer = window.dataLayer || [];
    function Ms() {
        dataLayer.push(arguments);
    }
   
    window.Helpers = Ii;
})();
/**
 * Sticky.js
 * Library for sticky elements written in vanilla javascript. With this library you can easily set sticky elements on your website. It's also responsive.
 *
 * @version 1.3.0
 * @author Rafal Galus <biuro@rafalgalus.pl>
 * @website https://rgalus.github.io/sticky-js/
 * @repo https://github.com/rgalus/sticky-js
 * @license https://github.com/rgalus/sticky-js/blob/master/LICENSE
 */
//# sourceMappingURL=/assets/application.js-04638b6ea3482da5f3e20c8ba7f06e3d0f25e0eb71ff7e409d7d681ab08eae49.map
//!
