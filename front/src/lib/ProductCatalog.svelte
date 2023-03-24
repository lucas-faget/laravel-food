<script lang="ts">
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getProducts } from '../api';
    import { getFilteredProducts } from '../api';
    import ProductCard from './ProductCard.svelte';

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
  
<div class="product-catalog">

    <div class="search-filter">
        <input type="text" bind:value={searchTerm} />
        <button on:click={handleSearch}>Search</button>
    </div>

    {#if isLoading}
        <img class="loading-icon" src="/loading-icon.gif" alt="Loading icon" />
    {:else}
        {#if products && $products.length !== 0}
            <div class="product-list">
                {#each $products as product}
                    <ProductCard product={product} />
                {/each}
            </div>
        {:else}
            <p>No product found</p>
        {/if}
    {/if}
</div>

<style>
    .product-catalog {
        display: flex;
        flex-direction: column;
        gap: 50px;
        padding-bottom: 50px;
    }

    .loading-icon {
        height: 50px;
        width: 50px;
    }

    .search-filter {
        display: flex;
    }

    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 50px 20px;
    }
</style>
  