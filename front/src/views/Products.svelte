<script lang="ts">
    import ProductCategories from '../lib/ProductCategories.svelte';
    import ProductCatalog from '../lib/ProductCatalog.svelte';
    import { Category } from '../enums/Category';

    let currentCategory: Category = Category.All_products;
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
            <ProductCatalog />
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
