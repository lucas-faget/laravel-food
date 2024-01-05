<script lang="ts">
    import SvgIcon from "./SvgIcon.svelte";

    export let product;
</script>
  
<div class="product-card">
    <div class="favorite-icon">
        <SvgIcon name="favorite"></SvgIcon>
    </div>
    <div class="square">
        <img class="product-image" src={product.image} alt={product.name} />
    </div>
    <div>
        <div class="product-name">
            {product.name}
        </div>
        <div class="product-brand">
            {product.brand}
        </div>
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
        width: 100px;
    }

    .product-name {
        color: var(--color-green);
        font-size: 18px;
        font-family: 'Anton', sans-serif;
    }

    .product-brand {
        color: var(--color-light-green);
    }
</style>
