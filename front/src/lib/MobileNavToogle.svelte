<script lang="ts">
    export let isColoredDark: boolean;
    export let isMobileNavOpen: boolean;
</script>

<div class={isColoredDark ? "mobile-nav-toggle color-dark" : "mobile-nav-toggle color-light"} aria-expanded={isMobileNavOpen}>
    <div></div>
</div>

<style scoped>
    .mobile-nav-toggle
    {
        display: none;
        width: 30px;
        aspect-ratio: 1/1;
        z-index: 1000;
        cursor: pointer;
    }

    .mobile-nav-toggle.color-dark:before, .mobile-nav-toggle.color-dark:after, .mobile-nav-toggle.color-dark > div
    {
        background-color: #000;
    }

    .mobile-nav-toggle.color-light:before, .mobile-nav-toggle.color-light:after, .mobile-nav-toggle.color-light > div
    {
        background-color: #fff;
    }

    .mobile-nav-toggle:before, .mobile-nav-toggle:after, .mobile-nav-toggle > div
    {
        content: '';
        display: block;
        height: 3px;
        margin: 8px 0;
        border-radius: 5px;
        transition: all .2s ease-in-out;
    }

    .mobile-nav-toggle[aria-expanded="true"]:before
    {
        transform: translateY(11px) rotate(135deg);
    }
    
    .mobile-nav-toggle[aria-expanded="true"]:after
    {
        transform: translateY(-11px) rotate(-135deg);
    }
    
    .mobile-nav-toggle[aria-expanded="true"] > div
    {
        transform: scale(0);
    }

    @media (max-width: 600px)
    {
        .mobile-nav-toggle
        {
            display: block;
        }
    }
</style>
