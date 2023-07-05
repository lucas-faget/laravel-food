<script lang="ts">
    import { afterUpdate, createEventDispatcher, onMount } from "svelte";
    import SvgIcon from "./SvgIcon.svelte";

    const dispatch = createEventDispatcher();

    const MinPage = 1;
    const MaxPage = 100;
    let pageList: number[] = [1,2,3,4,5];

    export let currentPage: number;
    let previousPage: number;

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

<style>
    
</style>