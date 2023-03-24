<script lang="ts">
    import ProductCategories from '../lib/ProductCategories.svelte';
    import ProductCatalog from '../lib/ProductCatalog.svelte';
</script>
  
<div class="products">
    <div class="header">
        <div class="title">
            All Products
        </div>
    </div>
    <div class="catalog">
        <div class="categories">
            <ProductCategories />
        </div>
        <div class="list">
            <ProductCatalog />
        </div>
    </div>
</div>

<style>
    .products {
        display: flex;
        flex-direction: column;
    }

    .header {
        align-self: flex-end;
        display: flex;
        padding-block: 40px;
        width: 70%;
    }

    .catalog {
        display: flex;
    }

    .title {
        font-size: 100px;
        font-family: 'Anton', sans-serif;
        text-transform: uppercase;
    }

    .categories {
        width: 30%;
    }

    .list {
        width: 70%;
    }
</style>
  