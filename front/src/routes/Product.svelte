<script lang="ts">
    import { onMount } from 'svelte';
    import { getFood, fakeProducts } from '../api/FdcApiClient';
    import List from '../lib/List.svelte';
    import Table from '../lib/Table.svelte';
    import SvgIcon from '../lib/SvgIcon.svelte';

    export let id: number|string;

    const MinServingSize = 0;
    const MaxServingSize = 10000;
    const StandardServingSize: number = 100;

    let product = null;
    let servingSize = 0;

    onMount(async () => {
        const data = await getFood(id);
        if (data) {
            product = data;
        } else {
            product = fakeProducts(1).shift();
        }
    });

    function getAmountString(amount: number): string {
        return `${Math.round(amount)} ${product.serving_size_unit}`;
    }

    function getProportionalAmount(amount: number, servingSize: number): number {
        return (amount * servingSize) / product.serving_size;
    }

    function getProportionalAmountString(amount: number, servingSize: number): string {
        return getAmountString(getProportionalAmount(amount, servingSize));
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
                        {#if product.brand}
                            <h3>{product.brand}</h3>
                        {/if}
                    </div>
                    {#if product.tags}
                        <div class="labels">
                            {#each product.tags.split(',') as tag}
                                <div class="label">{tag}</div>
                            {/each}
                        </div>
                    {/if}
                    {#if product.description}
                        <p class="text-capitalize">{product.description}</p>
                    {/if}
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
        <!-- <div class="bottom flex flex-column" style="gap: 20px;">
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
        </div> -->
        <div class="bottom">
            <Table header={
                ["Serving size", getAmountString(StandardServingSize), getAmountString(product.serving_size), getAmountString(servingSize)]
            } rows={[
                ["Calories",      getProportionalAmountString(product.calories, StandardServingSize),      getAmountString(product.calories),      getProportionalAmountString(product.calories, servingSize),    ],
                ["Fat",           getProportionalAmountString(product.fat, StandardServingSize),           getAmountString(product.fat),           getProportionalAmountString(product.fat, servingSize),         ],
                ["Carbohydrates", getProportionalAmountString(product.carbohydrates, StandardServingSize), getAmountString(product.carbohydrates), getProportionalAmountString(product.carbohydrates, servingSize)],
                ["Protein",       getProportionalAmountString(product.protein, StandardServingSize),       getAmountString(product.protein),       getProportionalAmountString(product.protein, servingSize),     ],
            ]}></Table>
        </div>
        {#if product.ingredients}
            <div class="bottom">
                <List title="composition" items={product.ingredients.split(',')}></List>
            </div>
        {/if}
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

    .product-image {
        height: 500px;
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
