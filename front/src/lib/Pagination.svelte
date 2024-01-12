<script lang="ts">
    import { afterUpdate, createEventDispatcher, onMount } from "svelte";
    import SvgIcon from "./SvgIcon.svelte";

    const dispatch = createEventDispatcher();

    export let pageCount: number = 1;
    export let currentPageNumber: number;

    const FirstPageNumber: number = 1;
    $: lastPageNumber = pageCount;
    let previousPageNumber: number;

    const pageRange: number = 2;
    let pageList: number[];

    $: {
        let start: number = currentPageNumber - pageRange;
        let end: number = currentPageNumber + pageRange;

        if (start < FirstPageNumber) {
            start = FirstPageNumber;
            end = Math.min(start + 4, lastPageNumber);
        }

        if (end > lastPageNumber) {
            end = lastPageNumber;
            start = Math.max(end - 4, FirstPageNumber);
        }

        pageList = Array.from({ length: end - start + 1 }, (_, index) => start + index);
    }

    onMount(() => {
        previousPageNumber = currentPageNumber;
    });

    function setCurrentPage(page: number): void {
        if (page >= FirstPageNumber && page <= lastPageNumber)
            currentPageNumber = page;
    }

    afterUpdate(() => {
        if (currentPageNumber !== previousPageNumber) {
            previousPageNumber = currentPageNumber;
            dispatch("pageChanged");
        }
    });
</script>

<div class="pagination flex" style="gap: 5px;">
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(FirstPageNumber)}
        on:keypress={() => setCurrentPage(FirstPageNumber)}
    ><SvgIcon name="first_page"></SvgIcon></div>
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(currentPageNumber - 1)}
        on:keypress={() => setCurrentPage(currentPageNumber - 1)}
    ><SvgIcon name="chevron_left"></SvgIcon></div>
    {#each pageList as page}
        <div
            class={page === currentPageNumber ? "square-button button-light" : "square-button button-dark"}
            on:click={() => setCurrentPage(page)}
            on:keypress={() => setCurrentPage(page)}
        >{page}</div>
    {/each}
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(currentPageNumber + 1)}
        on:keypress={() => setCurrentPage(currentPageNumber + 1)}
    ><SvgIcon name="chevron_right"></SvgIcon></div>
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(lastPageNumber)}
        on:keypress={() => setCurrentPage(lastPageNumber)}
    ><SvgIcon name="last_page"></SvgIcon></div>
</div>

<style>
    .pagination {
        height: 60px;
    }
    .pagination > div {
        width: 60px;
    }

    .pagination > div:first-child,
    .pagination > div:last-child {
        width: 80px;
    }
</style>
