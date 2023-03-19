<script lang="ts">
    import { onMount } from 'svelte';
    import { getProduct } from '../api';

    export let code: number;

    let product = null;

    onMount(async () => {
        const data = await getProduct(code);
        if (data) {
            product = data;
        }
    });
</script>

<div>
    <h1>Produit</h1>

    {#if product}
        <div>
            <h2>{product.product_name}</h2>
            <p>{product.brands}</p>
            <img src={product.image_url} alt={product.product_name} />
        </div>
    {:else}
        <img src="/loading-icon.gif" alt="Loading icon" />
    {/if}
</div>
