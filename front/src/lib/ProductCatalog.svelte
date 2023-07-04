<script lang="ts">
    import { Link } from "svelte-routing";
    import InputText from './InputText.svelte';
    import Button from './Button.svelte';
    import ProductCard from './ProductCard.svelte';
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getProducts, getFilteredProducts, fakeProducts } from '../api';

    let products = writable([]);
    products.set(fakeProducts(20));
    let searchTerm: string = "";
    let isLoading: boolean = false;

    onMount(async () => {
        // handleProductSearch();
    });

    const handleProductSearch = async () => {
        // isLoading = true;
        // let data: any;
        // if (searchTerm === "") {
        //     data = await getProducts();
        // } else {
        //     data = await getFilteredProducts(searchTerm);
        // }
        // products.set(data);
        // isLoading = false;
    }
</script>
  
<div class="product-catalog">

    <div class="search-filter">
        <div>
            <Button text="Search" handleClick={handleProductSearch} iconName="search"></Button>
        </div>
        <div class="input-text">
            <InputText bind:searchTerm={searchTerm} />
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
                    <Link to={`/products/${product.code}`} style="text-decoration: none;">
                        <ProductCard product={product} />
                    </Link>
                {/each}
            </div>
        {:else}
            <p>No product found</p>
        {/if}
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

    .input-text {
        flex: 1;
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
