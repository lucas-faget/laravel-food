<script lang="ts">
    import { onMount } from 'svelte';
    import { getProduct, fakeProducts } from '../api';

    export let code: number;

    let product = null;

    onMount(async () => {
        const data = await getProduct(code);
        if (data) {
            product = data;
        } else {
            product = fakeProducts(1).shift();
        }
    });
</script>

<div>
    {#if product}
        <div class="product">
            <div class="left">
                <img class="product-image" src={product.image_url} alt={product.product_name} />
            </div>
            <div class="right">
                <div class="product-details">
                    <div class="product-name">
                        <h2>{product.product_name}</h2>
                        <p class="brand">{product.brands}</p>
                    </div>
                    <div class="labels">
                        <div class="label">Product</div>
                        <div class="label">Fruit And Vegetables</div>
                    </div>
                    <p>
                        Food is any substance consumed by an organism for nutritional support. Food is usually of plant, animal, or fungal origin, and contains essential nutrients, such as carbohydrates, fats, proteins, vitamins, or minerals.
                    </p>
                </div>
            </div>
        </div>
    {:else}
        <img src="/loading-icon.gif" alt="Loading icon" />
    {/if}
</div>

<style>
    .product {
        display: flex;
    }

    .left, .right {
        height: 100vh;
        display: flex;
        align-items: center;
        width: 50vw;
    }

    .left {
        background-color: var(--color-green);
        justify-content: center;
    }

    .product-details {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin: 100px;
    }

    .product-details > p {
        color: var(--color-green);
        font-size: 20px;
    }

    .product-name {
        display: flex;
        flex-direction: column;
    }

    .product-name > h2 {
        color: var(--color-green);
        font-size: 50px;
        font-family: 'Anton', sans-serif;
        text-transform: uppercase;
    }

    .product-name > .brand {
        color: var(--color-light-green);
        font-size: 30px;
        font-family: 'Anton', sans-serif;
        text-transform: capitalize;
    }

    .labels {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .label {
        color: var(--color-green);
        padding: 10px 20px;
        border: 1px solid var(--color-green);
        border-radius: 20px;
        font-size: 15px;
    }
</style>
