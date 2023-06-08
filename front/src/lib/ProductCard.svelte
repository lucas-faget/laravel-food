<script lang="ts">
    export let product;
</script>
  
<div class="product-card">
    <!-- <p>{product.code}</p> -->
    <div class="icon">
        <img src="icons/heart.svg" alt="hearth" />
    </div>
    <div class="square">
        <img class="product-image" src={product.image_url} alt={product.product_name} />
    </div>
    <div>
        <div class="product-name">
            {product.product_name}
        </div>
        <div class="product-brand">
            {product.brands}
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

    .icon {
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
