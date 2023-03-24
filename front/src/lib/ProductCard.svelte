<script lang="ts">
    export let product;
</script>
  
<div class="product-card">
    <!-- <p>{product.code}</p> -->
    <div class="square">
        <!-- <img class="product-image" src={product.image_url} alt={product.product_name} /> -->
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
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 300px;
    }

    .square {
        background-color: hsl(0, 0%, 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
        width: 300px;
        border-radius: 20px;
    }

    .product-image {
        width: 80px;
    }

    .product-name {
        font-size: 18px;
        font-family: 'Anton', sans-serif;
    }

    .product-brand {

    }
</style>
  