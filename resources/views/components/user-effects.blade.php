@once
<style>
#user-effect-layer {
    position: fixed;
    inset: 0;
    overflow: hidden;
    pointer-events: auto;
    z-index: 0;
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
    background: rgba(255, 255, 255, 0.9);
    border-radius: 9999px;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.75);
}

.user-particle.star {
    background: rgba(209, 213, 219, 0.95);
    clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
    box-shadow: 0 0 10px rgba(226, 232, 240, 0.9);
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

.user-firework {
    position: fixed;
    width: 0;
    height: 0;
    pointer-events: none;
    z-index: 25;
}

.user-spark {
    position: absolute;
    width: 6px;
    height: 6px;
    border-radius: 9999px;
    transform: translate(0, 0);
    animation: user-spark 900ms ease-out forwards;
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

@keyframes user-spark {
    to {
        transform: translate(var(--x), var(--y)) scale(0.2);
        opacity: 0;
    }
}

@media (prefers-reduced-motion: reduce) {
    #user-effect-layer,
    #user-effect-counter {
        display: none;
    }
}
</style>
@endonce

<div id="user-effect-layer" aria-hidden="true"></div>
<div id="user-effect-counter" aria-live="polite">Collected 0/5</div>

@once
<script>
(function() {
    var layer = document.getElementById('user-effect-layer');
    var counter = document.getElementById('user-effect-counter');
    if (!layer || !counter) {
        return;
    }

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        layer.style.display = 'none';
        counter.style.display = 'none';
        return;
    }

    var goal = 5;
    var collected = 0;
    var activeParticles = 0;
    var maxParticles = 24;
    var spawnInterval = 1100;
    var colors = ['#f59e0b', '#f97316', '#fbbf24', '#fde68a', '#fb7185'];

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
        activeParticles = Math.max(0, activeParticles - 1);
    }

    function createPop(x, y) {
        var pop = document.createElement('div');
        pop.className = 'user-pop';
        pop.style.left = x + 'px';
        pop.style.top = y + 'px';
        layer.appendChild(pop);
        setTimeout(function() {
            if (pop.parentNode) {
                pop.parentNode.removeChild(pop);
            }
        }, 500);
    }

    function createFirework(x, y) {
        var burst = document.createElement('div');
        burst.className = 'user-firework';
        burst.style.left = x + 'px';
        burst.style.top = y + 'px';

        var sparks = 14;
        for (var i = 0; i < sparks; i++) {
            var spark = document.createElement('span');
            spark.className = 'user-spark';
            var angle = (Math.PI * 2 * i) / sparks;
            var distance = 60 + Math.random() * 30;
            spark.style.setProperty('--x', Math.cos(angle) * distance + 'px');
            spark.style.setProperty('--y', Math.sin(angle) * distance + 'px');
            spark.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            burst.appendChild(spark);
        }

        layer.appendChild(burst);
        setTimeout(function() {
            if (burst.parentNode) {
                burst.parentNode.removeChild(burst);
            }
        }, 900);
    }

    function collectParticle(particle, event) {
        event.preventDefault();
        event.stopPropagation();
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
            collected = 0;
            createFirework(Math.round(window.innerWidth / 2), Math.round(window.innerHeight / 3));
        }
        updateCounter();
    }

    function createParticle() {
        if (activeParticles >= maxParticles) {
            return;
        }
        activeParticles += 1;
        var particle = document.createElement('div');
        var isSnow = Math.random() < 0.65;
        particle.className = 'user-particle ' + (isSnow ? 'snowflake' : 'star');

        var size = 12 + Math.random() * 12;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = Math.floor(Math.random() * 100) + '%';
        particle.style.opacity = (0.5 + Math.random() * 0.5).toFixed(2);
        particle.style.setProperty('--drift', Math.round((Math.random() * 2 - 1) * 25) + 'px');
        particle.style.animationDuration = (16 + Math.random() * 12).toFixed(2) + 's';

        particle.addEventListener('click', function(event) {
            collectParticle(particle, event);
        });

        particle.addEventListener('animationend', function() {
            removeParticle(particle);
        });

        layer.appendChild(particle);
    }

    updateCounter();

    setInterval(function() {
        createParticle();
    }, spawnInterval);
})();
</script>
@endonce
