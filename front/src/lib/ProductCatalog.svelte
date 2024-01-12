<script lang="ts">
    import { createEventDispatcher } from 'svelte';
    import SvgIcon from "./SvgIcon.svelte";
    import SearchBar from './SearchBar.svelte';
    import ProductCard from './ProductCard.svelte';
    import Pagination from "./Pagination.svelte";

    const dispatch = createEventDispatcher();

    export let productList: any;
    export let isLoading: boolean;

    function handleProductSearch() {
        dispatch('handleProductSearch');
    }

    function handlePageChange() {
        dispatch('handlePageChange');
    }
</script>
  
<div class="product-catalog">
    <div class="search-filter">
        <div>
            <button class="button button-dark flex" style="height: 50px; gap: 8px;" on:click={handleProductSearch}>
                <span>SEARCH</span>
                <SvgIcon name="search_white" size={30}></SvgIcon>
            </button>
        </div>
        <div class="flex-1">
            <SearchBar bind:searchQuery={productList.searchQuery}></SearchBar>
        </div>
    </div>

    {#if isLoading}
        <div class="loading-icon">
            <img src="/loading-icon.gif" alt="Loading icon" style="height: 100%; width: 100%;"/>
        </div>
    {:else}
        {#if productList.products && productList.products.length !== 0}
            <div class="product-list">
                {#each productList.products as product}
                    <a href="/products/{product.api_id}" style="text-decoration: none;">
                        <ProductCard product={product} />
                    </a>
                {/each}
            </div>
        {:else}
            <p>No product found</p>
        {/if}
    {/if}

    <Pagination bind:currentPageNumber={productList.currentPageNumber} bind:pageCount={productList.pageCount} on:pageChanged={handlePageChange}></Pagination>
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
