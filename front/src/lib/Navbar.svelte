<script lang="ts">
    import { Router, Link, Route } from "svelte-routing";
    import { routes } from "../routes/routes";
    import Routes from "../routes/Routes.svelte";
    import MobileNavToggle from "./MobileNavToggle.svelte";
    import SvgIcon from "./SvgIcon.svelte";
  
    const maxMobileNavViewportWidth: number = 600;
    let viewportHeight: number = window.innerHeight || document.documentElement.clientHeight;
    let viewportWidth: number = window.innerWidth || document.documentElement.clientWidth;
    let scrollTop: number = document.documentElement.scrollTop;
    let isMobileNavOpen: boolean = false;

    window.addEventListener('resize', () => {
        viewportWidth = window.innerWidth || document.documentElement.clientWidth;
        viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    });

    window.addEventListener('scroll', () => {
        scrollTop = document.documentElement.scrollTop;
    });

    $: hasScrolled = scrollTop < (50 * viewportHeight) / 100;

    $: isWide = hasScrolled && !isMobileNavVisible;

    $: isDark = !isWide;

    $: isMobileNavVisible = isMobileNavOpen && viewportWidth <= maxMobileNavViewportWidth;
  
    function toggleMobileNav() {
        isMobileNavOpen = !isMobileNavOpen;
    }
  
    function handleKeyDown(event: KeyboardEvent) {
        if (event.key === "Enter" || event.key === " ") {
            toggleMobileNav();
        }
    }
</script>

<Router>
    <nav class={isDark ? 'nav-dark ' : 'nav-light '}{isWide ? 'nav-wide' : 'nav-thin'}>
        <Link to="/" style="text-decoration: none;">
            <div class="logo">Healthy</div>
        </Link>

        <div on:click={toggleMobileNav} on:keydown={handleKeyDown}>
            <MobileNavToggle isColoredDark={!isDark} isMobileNavOpen={isMobileNavOpen} />
        </div>
        
        <div class="links" aria-expanded={isMobileNavOpen}>
            <ul>
                {#each routes as route}
                    <Link to={route.path} style={isMobileNavVisible ? "text-decoration: none;" : "text-decoration: none; height: 100%;"}>
                        <li on:mouseenter={() => route.isHovered = true} on:mouseleave={() => route.isHovered = false}>
                            <SvgIcon name={(isDark && !route.isHovered || !isDark && route.isHovered) ? route.icon.dark : route.icon.light}></SvgIcon>
                            <div>{route.title}</div>
                        </li>
                    </Link>
                {/each}
            </ul>
        </div>
    </nav>
    <Routes />
</Router>
  
<style>
    nav {
        top: 0;
        left: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding-inline: 30px;
        box-sizing: border-box;
        z-index: 100;
    }

    .nav-dark {
        background-color: var(--color-green);
    }

    .nav-light {
        background-color: var(--color-light);
    }

    .nav-wide {
        position: absolute;
        height: 100px;
    }

    .nav-thin {
        position: fixed;
        height: 60px;
        padding-inline: 30px;
    }

    .links {
        height: 100%;
    }

    nav ul {
        display: flex;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    nav ul li {
        display: flex;
        gap: 10px;
        font-size: 20px;
        font-family: 'Anton', sans-serif;
        cursor: pointer;
    }

    .nav-dark ul li {
        color: var(--color-light);
    }

    .nav-light ul li {
        color: #000;
    }

    .nav-dark ul li:hover {
        color: #000;
    }

    .nav-light ul li:hover {
        color: var(--color-light);
    }
    
    .logo {
        position: relative;
        font-size: 25px;
        font-family: 'Anton', sans-serif;
        z-index: 1000;
    }

    .nav-dark .logo {
        color: var(--color-light);
    }

    .nav-light .logo {
        color: #000;
    }

    @keyframes slideDown {
        0% {
            top: -50%;
        }
        100% {
            top: 0;
        }
    }

    @media only screen and (min-width: 801px)
    {
        nav ul {
            gap: 15px;
            height: 100%;
        }

        nav ul li {
            height: 100%;
            align-items: center;
            padding-inline: 20px;
        }

        .nav-dark ul li:hover {
            background-color: var(--color-light);
        }

        .nav-light ul li:hover {
            background-color: var(--color-green);
        }

        .nav-thin {
            animation: slideDown 0.5s forwards;
        }
    }

    @media only screen and (max-width: 800px)
    {
        .links[aria-expanded="true"] {
            top: 0;
        }

        .links[aria-expanded="false"] {
            top: -100vh;
        }

        .links {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
        }

        .links {
            background-color: var(--color-green);
        }

        nav ul {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        nav ul li {
            font-size: 50px;
            font-family: 'Anton', sans-serif;
        }
    }
</style>
