<script lang="ts">
    import { Category } from "../enums/Category";

    const categories = Object.values(Category);

    export let currentCategory: Category;
    
    function handleClickCategory(category: Category) {
        currentCategory = category;
    }
</script>
  
<div class="product-categories">
    {#each categories as category}
        <div tabindex="0" on:click={() => handleClickCategory(category)} class={currentCategory === category ? "category color-green" : "category color-light-green"}>
            { category }
        </div>
    {/each}
</div>

<style>
    .product-categories {
        display: flex;
        flex-direction: column;
        padding-left: 20px;
        font-size: 40px;
        font-family: 'Anton', sans-serif;
        text-transform: capitalize;
    }

    .category {
        cursor: pointer;
    }

    .color-green {
        color: var(--color-green);
    }

    .color-light-green {
        color: var(--color-light-green);
    }
</style>
  