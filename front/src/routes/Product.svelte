<script lang="ts">
    import { onMount } from 'svelte';
    import { getProduct, fakeProducts } from '../api/SpoonacularApiClient';
    import List from '../lib/List.svelte';
    import Table from '../lib/Table.svelte';
    import SvgIcon from '../lib/SvgIcon.svelte';

    export let id: number|string;

    const Unit = 'g';
    const MinQuantity = 0;
    const MaxQuantity = 10000;

    let product = null;
    let quantity = 0;
    $: quantityString = (quantity ?? 0) + Unit;

    onMount(async () => {
        const data = await getProduct(id);
        if (data) {
            product = data;
        } else {
            product = fakeProducts(1).shift();
        }
    });

    function changeQuantity(grams: number)
    {
        if (quantity + grams < 0) {
            quantity = 0;
        } else {
            quantity += grams
        }
    }
</script>

<div class="product">
    {#if product}
        <div class="top">
            <div class="left">
                <img class="product-image" src={product.image} alt={product.name} />
            </div>
            <div class="right">
                <div class="flex flex-column" style="gap: 30px;">
                    <div class="flex flex-column">
                        <h2>{product.name}</h2>
                        <h3>{product.brand}</h3>
                    </div>
                    <div class="labels">
                        <div class="label">Product</div>
                        <div class="label">Fruit And Vegetables</div>
                    </div>
                    <p>
                        Food is any substance consumed by an organism for nutritional support. Food is usually of plant, animal, or fungal origin, and contains essential nutrients, such as carbohydrates, fats, proteins, vitamins, or minerals.
                    </p>
                    <button class="button justify-between" style="border-radius: 50px;">
                        <span>Add to favorite</span>
                        <SvgIcon name="favorite"></SvgIcon>
                    </button>
                    <button class="button justify-between" style="border-radius: 50px;">
                        <span>Add an intake</span>
                        <SvgIcon name="add"></SvgIcon>
                    </button>
                </div>
            </div>
        </div>
        <div class="bottom flex flex-column" style="gap: 20px;">
            <div class="flex align-stretch" style="gap: 1px;">
                <div class="flex flex-column flex-1" style="gap: 1px;">
                    <button class="button justify-center" on:click={() => changeQuantity(-10)}>-10</button>
                    <button class="button justify-center" on:click={() => changeQuantity(-100)}>-100</button>
                </div>
                <div class="flex-2">
                    <button class="button justify-center h-100 w-100" on:click={() => changeQuantity(-1)}>
                        <SvgIcon name="remove_circle"></SvgIcon>
                    </button>
                </div>
                <div class="flex-5">
                    <input class="input text-center" style="height: 100%; width: 100%; font-size: 30px;" type="number" min="{MinQuantity}" max="{MaxQuantity}" placeholder="Quantity" bind:value="{quantity}" />
                </div>
                <div class="flex-2">
                    <button class="button justify-center h-100 w-100" on:click={() => changeQuantity(1)}>
                        <SvgIcon name="add_circle"></SvgIcon>
                    </button>
                </div>
                <div class="flex flex-column flex-1" style="gap: 1px;">
                    <button class="button justify-center" on:click={() => changeQuantity(10)}>+10</button>
                    <button class="button justify-center" on:click={() => changeQuantity(100)}>+100</button>
                </div>
            </div>
              
              
            
            <div class="flex" style="gap: 10px;">
                <input class="input" style="flex: 2;" type="date" />
                <button class="button justify-center" style="flex: 1;">Add intake</button>
            </div>
        </div>
        <div class="bottom">
            <Table header={
                [product.name, "100g", quantityString]
            } rows={[
                ["Protein", "20g", "0g"],
                ["Carbohydrates", "20g", "0g"],
                ["Lipids", "20g", "0g"]
            ]}></Table>
        </div>
        <div class="bottom">
            <List title="composition" items={["water", "protein", "sugar", "salt",]}></List>
        </div>
    {:else}
        <div class="loading-icon">
            <img src="/loading-icon.gif" alt="Loading icon" style="height: 100%; width: 100%;"/>
        </div>
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

    .product {
        display: flex;
        flex-direction: column;
        padding-bottom: min(100px, 10vw);
    }

    .top {
        display: flex;
    }

    .left, .right {   
        display: flex;
        align-items: center;
        flex: 0 0 50%;
    }

    .left {
        background-color: var(--color-green);
        justify-content: center;
        border-radius: 0 10vw 0 10vw;
    }

    .right {
        padding-inline: min(100px, 10vw);
    }

    @media only screen and (max-width: 800px) {
        .top {
            flex-direction: column;
            margin-top: 100px;
        }

        .left, .right {
            padding-block: min(100px, 10vw);
        }
    }

    @media only screen and (min-width: 801px) {
        .left, .right {
            min-height: 100vh;
        }

        .right {
            padding-block: calc(100px + 5vw);
        }
    }

    .bottom {
        padding-top: min(100px, 10vw);
        padding-inline: min(100px, 10vw);
    }
</style>
