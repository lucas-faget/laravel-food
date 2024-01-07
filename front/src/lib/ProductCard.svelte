<script lang="ts">
    import SvgIcon from "./SvgIcon.svelte";

    export let product;
</script>
  
<div class="product-card">
    <div class="favorite-icon">
        <SvgIcon name="favorite_fill"></SvgIcon>
    </div>
    <div class="square">
        {#if product.image}
            <img class="product-image" src={product.image} alt={product.name} />
        {:else}
            <img class="product-image" src="/food/apple.svg" alt={product.name} />
        {/if}
    </div>
    <div class="flex flex-column" style="gap: 5px;">
        <div class="product-name">
            {product.name}
        </div>
        {#if product.brand}
            <div class="product-brand">
                {product.brand}
            </div>
        {/if}
    </div>
</div>

<style>
    .product-card {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 250px;
    }

    .favorite-icon {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .square {
        background-color: hsl(0, 0%, 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 350px;
        width: 100%;
        border-radius: 20px;
    }

    .product-image {
        width: 150px;
    }

    .product-name {
        color: var(--color-green);
        font-size: 18px;
        text-transform: capitalize;
        font-family: 'Anton', sans-serif;
    }

    .product-brand {
        color: var(--color-light-green);
        text-transform: uppercase;
    }
</style>
