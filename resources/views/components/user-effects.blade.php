@once
<style>
#user-effect-layer {
    position: fixed;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
}

#user-burst-layer {
    position: fixed;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
    z-index: 35;
}

#user-effect-counter {
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 30;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(253, 186, 116, 0.7);
    color: #9a3412;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 9999px;
    box-shadow: 0 6px 12px rgba(15, 23, 42, 0.08);
}

.user-particle {
    position: absolute;
    top: -10vh;
    pointer-events: auto;
    cursor: pointer;
    animation-name: user-fall;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}

.user-particle.snowflake {
    background: radial-gradient(circle, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.7) 45%, rgba(255, 255, 255, 0.2) 70%, rgba(255, 255, 255, 0) 100%);
    border-radius: 9999px;
    box-shadow: 0 0 12px rgba(255, 255, 255, 0.9), 0 0 18px rgba(226, 232, 240, 0.7);
}

.user-pop {
    position: fixed;
    width: 12px;
    height: 12px;
    border: 2px solid rgba(251, 191, 36, 0.9);
    border-radius: 9999px;
    transform: translate(-50%, -50%) scale(0.4);
    opacity: 0.9;
    animation: user-pop 450ms ease-out forwards;
    pointer-events: none;
    z-index: 25;
}

.user-activity-item {
    position: fixed;
    bottom: -40px;
    width: 28px;
    height: 28px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    opacity: 0;
    pointer-events: none;
    filter: drop-shadow(0 6px 10px rgba(15, 23, 42, 0.15));
    animation: user-activity-rise 2s ease-out forwards;
    will-change: transform, opacity, filter;
}

@keyframes user-fall {
    from {
        transform: translate3d(0, -10vh, 0) rotate(0deg);
    }
    to {
        transform: translate3d(var(--drift), 110vh, 0) rotate(360deg);
    }
}

@keyframes user-pop {
    to {
        transform: translate(-50%, -50%) scale(1.8);
        opacity: 0;
    }
}

@keyframes user-activity-rise {
    0% {
        transform: translate(0, 0) scale(0.6) rotate(0deg);
        opacity: 0;
        filter: blur(0);
    }
    20% {
        opacity: 1;
    }
    70% {
        opacity: 0.6;
    }
    100% {
        transform: translate(var(--dx), var(--dy)) scale(var(--scale)) rotate(var(--rot));
        opacity: 0;
        filter: blur(6px);
    }
}

@media (prefers-reduced-motion: reduce) {
    #user-effect-layer,
    #user-burst-layer,
    #user-effect-counter {
        display: none;
    }
}
</style>
@endonce

<div id="user-effect-layer" aria-hidden="true"></div>
<div id="user-burst-layer" aria-hidden="true"></div>
<div id="user-effect-counter" aria-live="polite">Collected 0/5</div>

@once
<script>
(function() {
    var layer = document.getElementById('user-effect-layer');
    var burstLayer = document.getElementById('user-burst-layer');
    var counter = document.getElementById('user-effect-counter');
    if (!layer || !counter) {
        return;
    }
    if (!burstLayer) {
        burstLayer = layer;
    }

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        layer.style.display = 'none';
        counter.style.display = 'none';
        return;
    }

    var goal = 5;
    var collected = 0;
    var activeParticles = 0;
    var maxParticles = 20;
    var spawnInterval = 1200;
    var particles = [];
    function svgToData(svg) {
        return 'data:image/svg+xml;utf8,' + encodeURIComponent(svg);
    }
    var activityIcons = [
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><polygon fill="#fb923c" points="32,6 4,20 32,34 60,20"/><rect x="20" y="34" width="24" height="8" rx="2" fill="#f97316"/><path d="M60,20v20" stroke="#1f2937" stroke-width="3" stroke-linecap="round"/><circle cx="60" cy="42" r="3" fill="#1f2937"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><circle cx="32" cy="32" r="8" fill="#f59e0b"/><circle cx="32" cy="14" r="9" fill="#fb7185"/><circle cx="48" cy="22" r="9" fill="#fb7185"/><circle cx="50" cy="40" r="9" fill="#fb7185"/><circle cx="32" cy="50" r="9" fill="#fb7185"/><circle cx="14" cy="40" r="9" fill="#fb7185"/><circle cx="16" cy="22" r="9" fill="#fb7185"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><circle cx="32" cy="32" r="7" fill="#f59e0b"/><circle cx="32" cy="12" r="8" fill="#60a5fa"/><circle cx="46" cy="18" r="8" fill="#60a5fa"/><circle cx="52" cy="32" r="8" fill="#60a5fa"/><circle cx="46" cy="46" r="8" fill="#60a5fa"/><circle cx="32" cy="52" r="8" fill="#60a5fa"/><circle cx="18" cy="46" r="8" fill="#60a5fa"/><circle cx="12" cy="32" r="8" fill="#60a5fa"/><circle cx="18" cy="18" r="8" fill="#60a5fa"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect x="28" y="8" width="8" height="30" rx="3" fill="#94a3b8"/><rect x="24" y="32" width="16" height="18" rx="4" fill="#f97316"/><path d="M24,48h16l-4,10H28z" fill="#fbbf24"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect x="26" y="8" width="12" height="24" rx="6" fill="#94a3b8"/><rect x="22" y="28" width="20" height="10" rx="5" fill="#cbd5e1"/><rect x="30" y="36" width="4" height="16" rx="2" fill="#1f2937"/><rect x="24" y="52" width="16" height="4" rx="2" fill="#1f2937"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect x="24" y="6" width="16" height="18" rx="8" fill="#a78bfa"/><rect x="20" y="22" width="24" height="8" rx="4" fill="#c4b5fd"/><rect x="28" y="30" width="8" height="20" rx="4" fill="#1f2937"/><rect x="22" y="50" width="20" height="5" rx="2.5" fill="#1f2937"/></svg>'),
        svgToData('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><circle cx="32" cy="34" r="7" fill="#f59e0b"/><circle cx="32" cy="12" r="7" fill="#34d399"/><circle cx="46" cy="20" r="7" fill="#34d399"/><circle cx="50" cy="34" r="7" fill="#34d399"/><circle cx="40" cy="48" r="7" fill="#34d399"/><circle cx="24" cy="48" r="7" fill="#34d399"/><circle cx="14" cy="34" r="7" fill="#34d399"/><circle cx="18" cy="20" r="7" fill="#34d399"/></svg>')
    ];

    function updateCounter() {
        counter.textContent = 'Collected ' + collected + '/' + goal;
    }

    function removeParticle(particle) {
        if (!particle || particle.dataset.removed === '1') {
            return;
        }
        particle.dataset.removed = '1';
        if (particle.parentNode) {
            particle.parentNode.removeChild(particle);
        }
        var index = particles.indexOf(particle);
        if (index !== -1) {
            particles.splice(index, 1);
        }
        activeParticles = Math.max(0, activeParticles - 1);
    }

    function createPop(x, y) {
        var pop = document.createElement('div');
        pop.className = 'user-pop';
        pop.style.left = x + 'px';
        pop.style.top = y + 'px';
        burstLayer.appendChild(pop);
        setTimeout(function() {
            if (pop.parentNode) {
                pop.parentNode.removeChild(pop);
            }
        }, 500);
    }

    function createActivitySpray() {
        if (!activityIcons.length) {
            return;
        }
        var count = 12;
        var width = Math.max(window.innerWidth, 320);
        var height = Math.max(window.innerHeight, 480);
        for (var i = 0; i < count; i++) {
            (function(index) {
                setTimeout(function() {
                    var item = document.createElement('div');
                    item.className = 'user-activity-item';
                    var image = activityIcons[Math.floor(Math.random() * activityIcons.length)];
                    item.style.backgroundImage = 'url(' + image + ')';

                    var size = 36 + Math.random() * 24;
                    item.style.width = Math.round(size) + 'px';
                    item.style.height = Math.round(size) + 'px';

                    var startX = Math.random() * width;
                    item.style.left = Math.round(startX - size / 2) + 'px';
                    item.style.bottom = '-40px';

                    var dx = (Math.random() * 320) - 160;
                    var dy = -1 * (height * (0.8 + Math.random() * 0.5));
                    var rot = (Math.random() * 180) - 90;
                    var scale = (0.8 + Math.random() * 0.55).toFixed(2);

                    item.style.setProperty('--dx', Math.round(dx) + 'px');
                    item.style.setProperty('--dy', Math.round(dy) + 'px');
                    item.style.setProperty('--rot', Math.round(rot) + 'deg');
                    item.style.setProperty('--scale', scale);
                    item.style.animationDuration = '2s';

                    burstLayer.appendChild(item);
                    setTimeout(function() {
                        if (item.parentNode) {
                            item.parentNode.removeChild(item);
                        }
                    }, 2100);
                }, index * 140);
            })(i);
        }
    }

    function collectParticle(particle, event) {
        if (particle.dataset.collected === '1') {
            return;
        }
        particle.dataset.collected = '1';
        collected += 1;
        if (event && typeof event.clientX === 'number') {
            createPop(event.clientX, event.clientY);
        }
        removeParticle(particle);
        if (collected >= goal) {
            createActivitySpray();
            collected = 0;
        }
        updateCounter();
    }

    function handleParticleCollect(event) {
        if (!particles.length) {
            return;
        }
        var x = event.clientX;
        var y = event.clientY;
        if (typeof x !== 'number' || typeof y !== 'number') {
            return;
        }
        for (var i = particles.length - 1; i >= 0; i--) {
            var particle = particles[i];
            if (!particle || particle.dataset.collected === '1') {
                continue;
            }
            var rect = particle.getBoundingClientRect();
            if (x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom) {
                collectParticle(particle, event);
                break;
            }
        }
    }

    function createParticle() {
        if (activeParticles >= maxParticles) {
            return;
        }
        activeParticles += 1;
        var particle = document.createElement('div');
        particle.className = 'user-particle snowflake';

        var size = 16 + Math.random() * 12;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = Math.floor(Math.random() * 100) + '%';
        particle.style.opacity = (0.5 + Math.random() * 0.5).toFixed(2);
        particle.style.setProperty('--drift', Math.round((Math.random() * 2 - 1) * 18) + 'px');
        particle.style.animationDuration = (22 + Math.random() * 12).toFixed(2) + 's';
        particles.push(particle);

        particle.addEventListener('animationend', function() {
            removeParticle(particle);
        });

        layer.appendChild(particle);
    }

    updateCounter();
    document.addEventListener('pointerdown', handleParticleCollect, true);

    setInterval(function() {
        createParticle();
    }, spawnInterval);
})();
</script>
@endonce
