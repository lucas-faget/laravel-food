<script lang="ts">
    import { onMount } from 'svelte';
    import { getFood } from '../api/FdcClient';
    import { createProduct } from '../api/ProductClient';
    import List from '../lib/List.svelte';
    import Table from '../lib/Table.svelte';
    import SvgIcon from '../lib/SvgIcon.svelte';
    import { randomFruitImage } from '../api/fruits';

    export let id: number|string;

    const MinServingSize = 0;
    const MaxServingSize = 999999;
    const StandardServingSize: number = 100;

    let product = null;
    let servingSize = 0;

    $: {
        servingSize = clamp(servingSize, MinServingSize, MaxServingSize)
    }

    onMount(async () => {
        const data = await getFood(id);
        product = data;
    });

    function clamp(value: number, min: number, max: number) {
        return value > max ? max : value < min ? min : value;
    }

    function getAmountString(amount: number): string {
        return `${Math.round(amount)} ${product.serving_size_unit}`;
    }

    function getProportionalAmount(amount: number, servingSize: number): number {
        return (amount * servingSize) / product.serving_size;
    }

    function getProportionalAmountString(amount: number, servingSize: number): string {
        return getAmountString(getProportionalAmount(amount, servingSize));
    }

    const createProductHandler = async () => {
        try {
            product.user_id = 1;
            console.log(product);
            await createProduct(product);
        } catch (error) {
            console.error(error);
        }
    };
</script>

<div class="product">
    {#if product}
        <div class="top">
            <div class="left">
                {#if product.image}
                    <img class="product-image" src={product.image} alt={product.name} />
                {:else}
                    <img class="product-image" src={randomFruitImage()} alt={product.name} />
                {/if}
            </div>
            <div class="right">
                <div class="flex flex-column" style="gap: 30px;">
                    <div class="flex flex-column" style="gap: 10px;">
                        <h2 class="text-capitalize">{product.name}</h2>
                        {#if product.brand}
                            <h3 class="text-uppercase">{product.brand}</h3>
                        {/if}
                    </div>
                    {#if product.tags}
                        <div class="labels">
                            {#each product.tags.split(',') as tag}
                                <div class="label">{tag}</div>
                            {/each}
                            {#if product.country}
                                <div class="label">{product.country}</div>
                            {/if}
                        </div>
                    {/if}
                    {#if product.description}
                        <p class="text-capitalize">{product.description}</p>
                    {/if}
                    <button class="button button-dark justify-between" style="border-radius: 50px;" on:click={createProductHandler}>
                        <span>Add to favorite</span>
                        <SvgIcon name="favorite_white"></SvgIcon>
                    </button>
                    <button class="button button-dark justify-between" style="border-radius: 50px;">
                        <span>Add an intake</span>
                        <SvgIcon name="add_white"></SvgIcon>
                    </button>
                </div>
            </div>
        </div>
        <div class="bottom grid">
            <div class="flex">
                <button class="square-button button-dark" style="border-radius: 100% 0 0 100%;" on:click={() => servingSize--}>
                    <SvgIcon name="remove_circle" size={35}></SvgIcon>
                </button>
                <input class="input flex-1" type="number" placeholder="Serving size" bind:value="{servingSize}" min="{MinServingSize}" max={MaxServingSize} />
                <button class="square-button button-dark" style="border-radius: 0 100% 100% 0;" on:click={() => servingSize++}>
                    <SvgIcon name="add_circle" size={35}></SvgIcon>
                </button>
            </div>
            <div>
                <input class="input w-100" type="date" />
            </div>
            <div>
                <button class="button button-dark w-100 text-center">Add intake</button>
            </div>
        </div>
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

    .grid {
        display: grid;
        grid-gap: 20px;
    }

    .grid > div:nth-child(1) { grid-area: a; }
    .grid > div:nth-child(2) { grid-area: b; }
    .grid > div:nth-child(3) { grid-area: c; }

    @media only screen and (min-width: 1001px) {
        .grid {
            grid-template-columns: repeat(3, 1fr);
            grid-template-areas: 
                "a b c";
        }
    }

    @media only screen and (min-width: 801px) and (max-width: 1000px) {
        .grid {
            grid-template-columns: repeat(2, 1fr);
            grid-template-areas: 
                "a a"
                "b c";
        }
    }

    @media only screen and (max-width: 800px) {
        .grid {
            grid-template-columns: 1fr;
            grid-template-areas: 
                "a"
                "b"
                "c";
        }
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
