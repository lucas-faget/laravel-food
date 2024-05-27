<script lang="ts">
    import { onMount } from "svelte";
    import { getFood } from "../api/FdcClient";
    import { randomFruitImage } from "../api/fruits";
    import { createProduct } from "../api/ProductClient";
    import List from "../lib/List.svelte";
    import Table from "../lib/Table.svelte";
    import SvgIcon from "../lib/SvgIcon.svelte";

    export let id: number | string;

    const MinServingSize = 0;
    const MaxServingSize = 999999;
    const StandardServingSize: number = 100;

    let product = null;
    let servingSize = 0;

    $: {
        servingSize = clamp(servingSize, MinServingSize, MaxServingSize);
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
            console.log(product);
            await createProduct(product);
        } catch (error) {
            console.error(error);
        }
    };
</script>

<div class="product">
    {#if product}
        <div class="top bg-light-green">
            <div class="left">
                {#if product.image}
                    <img class="product-image" src={product.image} alt={product.name} />
                {:else}
                    <img class="product-image" src={randomFruitImage()} alt={product.name} />
                {/if}
            </div>
            <div class="right">
                <div class="flex flex-column bg-light padding border-radius" style="gap: 30px;">
                    <div class="flex flex-column" style="gap: 10px;">
                        <h2 class="text-capitalize">{product.name}</h2>
                        {#if product.brand}
                            <h3 class="text-uppercase">{product.brand}</h3>
                        {/if}
                    </div>
                    {#if product.tags}
                        <div class="labels">
                            {#each product.tags.split(",") as tag}
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
                    <button
                        class="button button-dark justify-between"
                        style="border-radius: 50px;"
                        on:click={createProductHandler}
                    >
                        <span>Add to favorite</span>
                        <SvgIcon name="favorite_white"></SvgIcon>
                    </button>
                </div>
            </div>
        </div>
        <div class="bottom intake-form-grid bg-light-green padding-relative">
            <div class="flex">
                <button
                    class="square-button button-dark"
                    style="border-radius: 100% 0 0 100%;"
                    on:click={() => servingSize--}
                >
                    <SvgIcon name="remove_circle" size={35}></SvgIcon>
                </button>
                <input
                    class="input flex-1"
                    type="number"
                    placeholder="Serving size"
                    bind:value={servingSize}
                    min={MinServingSize}
                    max={MaxServingSize}
                />
                <button
                    class="square-button button-dark"
                    style="border-radius: 0 100% 100% 0;"
                    on:click={() => servingSize++}
                >
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
        <div class="bottom padding-relative">
            <Table
                title="nutrition facts label"
                header={[
                    "Serving size",
                    getAmountString(StandardServingSize),
                    getAmountString(product.serving_size),
                    getAmountString(servingSize),
                ]}
                rows={[
                    [
                        "Calories",
                        getProportionalAmountString(product.calories, StandardServingSize),
                        getAmountString(product.calories),
                        getProportionalAmountString(product.calories, servingSize),
                    ],
                    [
                        "Fat",
                        getProportionalAmountString(product.fat, StandardServingSize),
                        getAmountString(product.fat),
                        getProportionalAmountString(product.fat, servingSize),
                    ],
                    [
                        "Carbohydrates",
                        getProportionalAmountString(product.carbohydrates, StandardServingSize),
                        getAmountString(product.carbohydrates),
                        getProportionalAmountString(product.carbohydrates, servingSize),
                    ],
                    [
                        "Protein",
                        getProportionalAmountString(product.protein, StandardServingSize),
                        getAmountString(product.protein),
                        getProportionalAmountString(product.protein, servingSize),
                    ],
                ]}
            ></Table>
        </div>
        {#if product.ingredients}
            <div class="bg-light-green padding-relative">
                <div class="bottom bg-light padding border-radius">
                    <List title="composition" items={product.ingredients.split(",")}></List>
                </div>
            </div>
        {/if}
    {:else}
        <div class="loading-icon">
            <img src="/loading-icon.gif" alt="Loading icon" style="height: 100%; width: 100%;" />
        </div>
    {/if}
</div>

<style>
    :root {
        --padding: 50px;
        --relative-padding: min(5vw, 50px);
        --border-radius: 50px;
    }

    .loading-icon {
        position: fixed;
        top: calc(50vh - 50px);
        left: calc(50vw - 50px);
        height: 100px;
        width: 100px;
    }

    .padding {
        padding: var(--padding);
    }

    .padding-relative {
        padding: var(--relative-padding);
    }

    .border-radius {
        border-radius: var(--border-radius);
    }

    .product {
        display: flex;
        flex-direction: column;
        margin-top: 100px;
    }

    .top {
        padding-top: var(--relative-padding);
        padding-inline: var(--relative-padding);
        display: flex;
        gap: var(--relative-padding);
    }

    @media only screen and (max-width: 1000px) {
        .top {
            flex-direction: column-reverse;
        }
    }

    .product-image {
        max-width: min(100%, 400px);
        max-height: min(100%, 400px);
    }

    .left {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media only screen and (min-width: 1001px) {
        .left {
            flex-basis: 40%;
        }

        .right {
            flex-basis: 60%;
        }
    }

    .intake-form-grid {
        display: grid;
        grid-gap: 20px;
    }

    .intake-form-grid > div:nth-child(1) {
        grid-area: a;
    }
    .intake-form-grid > div:nth-child(2) {
        grid-area: b;
    }
    .intake-form-grid > div:nth-child(3) {
        grid-area: c;
    }

    @media only screen and (min-width: 1001px) {
        .intake-form-grid {
            grid-template-columns: repeat(3, 1fr);
            grid-template-areas: "a b c";
        }
    }

    @media only screen and (min-width: 801px) and (max-width: 1000px) {
        .intake-form-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-template-areas:
                "a a"
                "b c";
        }
    }

    @media only screen and (max-width: 800px) {
        .intake-form-grid {
            grid-template-columns: 1fr;
            grid-template-areas:
                "a"
                "b"
                "c";
        }
    }
</style>
