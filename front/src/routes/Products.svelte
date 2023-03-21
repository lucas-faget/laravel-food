<script lang="ts">
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getProducts } from '../api';
    import { getFilteredProducts } from '../api';

    let products = writable([]);
    let searchTerm: string = "";
    let isLoading: boolean = false;

    onMount(async () => {
        handleSearch();
    });

    const handleSearch = async () => {
        isLoading = true;
        let data: any;
        if (searchTerm === "") {
            data = await getProducts();
        } else {
            data = await getFilteredProducts(searchTerm);
        }
        products.set(data);
        isLoading = false;
    }
</script>
  
<div class="products">
    <br>
    <div class="search-filter">
        <input type="text" bind:value={searchTerm} />
        <button on:click={handleSearch}>Search</button>
    </div>

    {#if isLoading}
        <img src="/loading-icon.gif" alt="Loading icon" />
    {:else}
        {#if products && $products.length !== 0}
            {#each $products as product}
                <div>
                    <h2>{product.product_name}</h2>
                    <p>{product.brands}</p>
                    <p>{product.code}</p>
                    <!-- <img class="product-image" src={product.image_url} alt={product.product_name} /> -->
                </div>
            {/each}
        {:else}
            <p>No product found</p>
        {/if}
    {/if}
</div>

<style>
    .products {
        display: flex;
        flex-direction: column;
    }

    .search-filter {
        display: flex;
    }

    .product-image {
        width: 80px;
    }
</style>
  