<script>
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getProducts } from '../api';

    let products = null;

    onMount(async () => {
        const data = await getProducts(1);
        products = writable([]);
        products.set(data);
    });
</script>
  
<div>
    {#if products}
        {#each $products as product}
            <div>
                <h2>{product.product_name}</h2>
                <p>{product.brands}</p>
                <p>{product.code}</p>
                <img src={product.image_url} alt={product.product_name} />
            </div>
        {/each}
    {:else}
        <img src="/loading-icon.gif" alt="Loading icon" />
    {/if}
</div>
  