<script lang="ts">
    import { Router, Link, Route } from "svelte-routing";
    import Home from "../routes/Home.svelte";
    import Product from "../routes/Product.svelte";
    import Products from "../routes/Products.svelte";
    import MobileNavToggle from "./MobileNavToggle.svelte";
  
    const maxMobileNavViewportWidth: number = 600;
    let viewportHeight: number = window.innerHeight || document.documentElement.clientHeight;
    let viewportWidth: number = window.innerWidth || document.documentElement.clientWidth;
    let scrollTop: number = window.pageYOffset || document.documentElement.scrollTop;
    let isMobileNavOpen: boolean = false;

    window.addEventListener('resize', () => {
        viewportWidth = window.innerWidth || document.documentElement.clientWidth;
        viewportHeight = window.innerHeight || document.documentElement.clientHeight;
    });

    window.addEventListener('scroll', () => {
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    });

    $: hasScrolled = scrollTop < (50 * viewportHeight) / 100;

    $: isWideNav = hasScrolled && !isMobileNavVisible;

    $: isDarkNav = !isWideNav;

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
    <nav class={isDarkNav ? 'nav-dark ' : 'nav-light '}{isWideNav ? 'nav-wide' : 'nav-thin'}>
        <Link to="/" style="text-decoration: none;">
            <div class="logo">Healthy</div>
        </Link>

        <div on:click={toggleMobileNav} on:keydown={handleKeyDown}>
            <MobileNavToggle isColoredDark={!isDarkNav} isMobileNavOpen={isMobileNavOpen} />
        </div>
        
        <ul aria-expanded={isMobileNavOpen}>
            <Link to="/" style={isMobileNavVisible ? "text-decoration: none;" : "text-decoration: none; height: 100%;"}>
                <li>Home</li>
            </Link>
            <Link to="/products" style={isMobileNavVisible ? "text-decoration: none;" : "text-decoration: none; height: 100%;"}>
                <li>Products</li>
            </Link>
            <Link to="/" style={isMobileNavVisible ? "text-decoration: none;" : "text-decoration: none; height: 100%;"}>
                <li>Home</li>
            </Link>
        </ul>
    </nav>
    <div>
        <Route path="/" component="{Home}" />
        <Route path="/products" component="{Products}" />
        <Route path="/products/:code" component="{Product}" />
    </div>
</Router>
  
<style>
    nav {
        top: 0;
        left: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100vw;
        padding-inline: 30px;
        box-sizing: border-box;
        z-index: 100;
    }

    .nav-dark {
        background-color: var(--color-green);
    }

    .nav-light {
        background-color: transparent;
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

    nav ul {
        display: flex;
        align-items: center;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    nav ul li {
        display: flex;
        align-items: center;
        border-radius: 20px 0 20px 0;
        font-size: 20px;
        font-family: 'Anton', sans-serif;
        cursor: pointer;
    }

    .nav-dark ul li {
        color: #fff;
    }

    .nav-light ul li {
        color: #000;
    }

    .nav-dark ul li:hover {
        color: #000;
    }

    .nav-light ul li:hover {
        color: #fff;
    }
    
    .logo {
        position: relative;
        font-size: 25px;
        font-family: 'Anton', sans-serif;
        z-index: 1000;
    }

    .nav-dark .logo {
        color: #fff;
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

    @media only screen and (min-width: 601px)
    {
        nav ul {
            gap: 15px;
            height: 100%;
        }

        nav ul li {
            height: 100%;
            padding-inline: 20px;
        }

        .nav-dark ul li:hover {
            background-color: #fff;
        }

        .nav-light ul li:hover {
            background-color: var(--color-green);
        }

        .nav-thin {
            animation: slideDown 0.5s forwards;
        }
    }

    @media only screen and (max-width: 600px)
    {
        nav ul[aria-expanded="true"] {
            top: 0;
        }

        nav ul[aria-expanded="false"] {
            top: -100vh;
        }

        nav ul {
            position: fixed;
            top: 0;
            left: 0;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            width: 100%;
            z-index: 10;
        }

        .nav-dark ul, .nav-light ul {
            background-color: var(--color-green);
        }

        nav ul li {
            padding-inline: 50px;
            padding-block: 20px;
            font-size: 50px;
            font-family: 'Anton', sans-serif;
        }
    }
</style>
  