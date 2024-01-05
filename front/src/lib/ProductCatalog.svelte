<script lang="ts">
    import SearchBar from './SearchBar.svelte';
    import ProductCard from './ProductCard.svelte';
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getProductSearch, fakeProducts } from '../api/SpoonacularApiClient';
    import SvgIcon from "./SvgIcon.svelte";
    import Pagination from "./Pagination.svelte";

    let products = writable([]);
    //products.set(fakeProducts(20));
    let currentPage: number = 1;
    let searchQuery: string = "";
    let isLoading: boolean = false;

    onMount(async () => {
        handleProductSearch();
    });

    const handleProductSearch = async () => {
        isLoading = true;
        let data: any;
        if (searchQuery === "") {
            data = await getProductSearch("apple");
        } else {
            data = await getProductSearch(searchQuery, currentPage);
        }
        products.set(data);
        isLoading = false;
    }

    function handlePageChange() {
        handleProductSearch();
    }
</script>
  
<div class="product-catalog">
    <div class="search-filter">
        <div>
            <button class="button flex" style="height: 50px; gap: 8px;" on:click={handleProductSearch}>
                <span>SEARCH</span>
                <SvgIcon name="search"></SvgIcon>
            </button>
        </div>
        <div class="flex-1">
            <SearchBar bind:searchQuery={searchQuery}></SearchBar>
        </div>
    </div>

    {#if isLoading}
        <div class="loading-icon">
            <img src="/loading-icon.gif" alt="Loading icon" style="height: 100%; width: 100%;"/>
        </div>
    {:else}
        {#if products && $products.length !== 0}
            <div class="product-list">
                {#each $products as product}
                    <a href="/products/{product.api_id}" style="text-decoration: none;">
                        <ProductCard product={product} />
                    </a>
                {/each}
            </div>
        {:else}
            <p>No product found</p>
        {/if}
    {/if}

    <Pagination bind:currentPage={currentPage} on:pageChanged={handlePageChange}></Pagination>
</div>

<style>
    .loading-icon {
        position: relative;
        height: 100px;
        width: 100px;
    }

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
        gap: 20px;
        padding-right: 50px;
    }

    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 50px 20px;
        padding-right: 20px;
    }

    @media (max-width: 800px) {
        .search-filter {
            padding-inline: 20px;
        }

        .product-list {
            justify-content: center;
            padding-inline: 20px;
        }
    }
</style>
