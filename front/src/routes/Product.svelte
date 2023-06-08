<script lang="ts">
    import { onMount } from 'svelte';
    import { getProduct, fakeProducts } from '../api';
    import List from '../lib/List.svelte';

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

<div class="product">
    {#if product}
        <div class="top">
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
        <div class="bottom">
            <List title="composition" items={["water", "protein", "sugar", "salt",]}></List>
        </div>
    {:else}
        <div class="loading-icon">
            <img src="/loading-icon.gif" alt="Loading icon" style="height: 100%; width: 100%;"/>
        </div>
    {/if}
</div>

<style>
    .loading-icon {
        position: fixed;
        top: calc(50vh - 50px);
        left: calc(50vw - 50px);
        height: 100px;
        width: 100px;
    }

    .product {
        display: flex;
        flex-direction: column;
    }

    .top {
        display: flex;
    }

    .left, .right {   
        display: flex;
        align-items: center;
        flex: 0 0 50%;
    }

    .left {
        background-color: var(--color-green);
        justify-content: center;
        border-radius: 0 10vw 0 10vw;
    }

    .right {
        padding-inline: min(100px, 10vw);
    }

    .product-details {
        display: flex;
        flex-direction: column;
        gap: 30px;
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

    @media only screen and (max-width: 800px) {
        .top {
            flex-direction: column;
            margin-top: 100px;
        }

        .left, .right {
            padding-block: min(100px, 10vw);
        }
    }

    @media only screen and (min-width: 801px) {
        .left, .right {
            min-height: 100vh;
        }

        .right {
            padding-block: calc(100px + 5vw);
        }
    }

    .bottom {
        padding: min(100px, 10vw);
    }
</style>
