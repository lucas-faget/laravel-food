<script lang="ts">
    import { afterUpdate, createEventDispatcher, onMount } from "svelte";
    import SvgIcon from "./SvgIcon.svelte";

    const dispatch = createEventDispatcher();

    const MinPage = 1;
    const MaxPage = 10;

    export let currentPage: number;
    let previousPage: number;

    const pageRange: number = 2;
    let pageList: number[];

    $: {
        let start = currentPage - pageRange;
        let end = currentPage + pageRange;

        if (start < MinPage) {
            start = MinPage;
            end = Math.min(start + 4, MaxPage);
        }

        if (end > MaxPage) {
            end = MaxPage;
            start = Math.max(end - 4, MinPage);
        }

        pageList = Array.from({ length: end - start + 1 }, (_, index) => start + index);
    }

    onMount(() => {
        previousPage = currentPage;
    });

    function setCurrentPage(page: number): void {
        if (page >= MinPage && page <= MaxPage)
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
        class="button-light"
        on:click={() => setCurrentPage(currentPage - 1)}
        on:keypress={() => setCurrentPage(currentPage - 1)}
    ><SvgIcon name="chevron_left"></SvgIcon></div>
    {#each pageList as page}
        <div
            class={page === currentPage ? "button-light" : "button"}
            on:click={() => setCurrentPage(page)}
            on:keypress={() => setCurrentPage(page)}
        >{page}</div>
    {/each}
    <div
        class="button-light"
        on:click={() => setCurrentPage(currentPage + 1)}
        on:keypress={() => setCurrentPage(currentPage + 1)}
    ><SvgIcon name="chevron_right"></SvgIcon></div>
</div>
