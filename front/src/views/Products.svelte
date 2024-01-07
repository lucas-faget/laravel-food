<script lang="ts">
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { getFoodSearch } from '../api/FdcClient';
    import { Category } from '../enums/Category';
    import ProductCategories from '../lib/ProductCategories.svelte';
    import ProductCatalog from '../lib/ProductCatalog.svelte';

    let currentCategory: Category = Category.All_products;
    let isLoading: boolean = false;

    let productList = writable({
        products: [],
        currentPageNumber: 1,
        maxPageNumber: 1,
        searchQuery: "",
    });

    onMount(async () => {
        updateProductList();
    });

    const updateProductList = async () => {
        isLoading = true;
        let data = await getFoodSearch($productList.searchQuery, $productList.currentPageNumber);
        productList.update((previous) => ({
            ...previous,
            products: data.products,
            maxPageNumber: Math.max(1, data.totalPages),
        }));
        isLoading = false;
    }

    const handleProductSearch = async () => {
        productList.update((previous) => ({
            ...previous,
            currentPageNumber: 1,
        }));
        updateProductList()
    }

    const handlePageChange = () => {
        updateProductList();
    }
</script>
  
<div class="products">
    <div class="header">
        <div class="title">
            { currentCategory }
        </div>
    </div>
    <div class="catalog-with-categories">
        <div class="categories">
            <ProductCategories bind:currentCategory={currentCategory} />
        </div>
        <div class="catalog">
            <ProductCatalog bind:productList={$productList} isLoading={isLoading} on:handleProductSearch={handleProductSearch} on:handlePageChange={handlePageChange} />
        </div>
    </div>
</div>

<style>
    .products {
        padding-top: 100px;
        display: flex;
        flex-direction: column;
    }

    .header {
        align-self: flex-end;
        display: flex;
        padding-block: 40px;
        width: 70%;
    }

    .catalog-with-categories {
        display: flex;
    }

    .title {
        color: var(--color-green);
        font-size: 100px;
        font-family: 'Anton', sans-serif;
        text-transform: uppercase;
    }

    .categories {
        width: 30%;
    }

    .catalog {
        width: 70%;
    }

    @media (max-width: 800px) {
        .header {
            display: none;
        }

        .catalog-with-categories {
            flex-direction: column;
        }

        .categories {
            width: 100%;
        }

        .catalog {
            width: 100%;
        }
    }
</style>
