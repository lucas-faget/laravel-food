<script lang="ts">
    import { afterUpdate, createEventDispatcher, onMount } from "svelte";
    import SvgIcon from "./SvgIcon.svelte";

    const dispatch = createEventDispatcher();

    const MinPage: number = 1;
    export let maxPage: number = 1;
    export let currentPage: number;
    let previousPage: number;

    const pageRange: number = 2;
    let pageList: number[];

    $: {
        let start: number = currentPage - pageRange;
        let end: number = currentPage + pageRange;

        if (start < MinPage) {
            start = MinPage;
            end = Math.min(start + 4, maxPage);
        }

        if (end > maxPage) {
            end = maxPage;
            start = Math.max(end - 4, MinPage);
        }

        pageList = Array.from({ length: end - start + 1 }, (_, index) => start + index);
    }

    onMount(() => {
        previousPage = currentPage;
    });

    function setCurrentPage(page: number): void {
        if (page >= MinPage && page <= maxPage)
            currentPage = page;
    }

    afterUpdate(() => {
        if (currentPage !== previousPage) {
            previousPage = currentPage;
            dispatch("pageChanged");
        }
    });
</script>

<div class="pagination flex" style="gap: 5px;">
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(currentPage - 1)}
        on:keypress={() => setCurrentPage(currentPage - 1)}
    ><SvgIcon name="chevron_left"></SvgIcon></div>
    {#each pageList as page}
        <div
            class={page === currentPage ? "square-button button-light" : "square-button button-dark"}
            on:click={() => setCurrentPage(page)}
            on:keypress={() => setCurrentPage(page)}
        >{page}</div>
    {/each}
    <div
        class="square-button button-light"
        on:click={() => setCurrentPage(currentPage + 1)}
        on:keypress={() => setCurrentPage(currentPage + 1)}
    ><SvgIcon name="chevron_right"></SvgIcon></div>
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
