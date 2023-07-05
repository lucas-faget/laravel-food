<script lang="ts">
    import SvgIcon from "./SvgIcon.svelte";

    const MinPageIndex = 1;
    const MaxPageIndex = 100;
    let pageIndexList: number[] = [1,2,3,4,5];

    let currentPageIndex: number = 1;

    function setCurrentPageIndex(pageIndex: number): void {
        if (pageIndex >= MinPageIndex && pageIndex <= MaxPageIndex)
            currentPageIndex = pageIndex;
    }
</script>

<div class="pagination flex" style="gap: 5px;">
    <div
        class="button-light"
        on:click={() => setCurrentPageIndex(currentPageIndex - 1)}
        on:keypress={() => setCurrentPageIndex(currentPageIndex - 1)}
    ><SvgIcon name="chevron_left"></SvgIcon></div>
    {#each pageIndexList as pageIndex}
        <div
            class={pageIndex === currentPageIndex ? "button-light" : "button"}
            on:click={() => setCurrentPageIndex(pageIndex)}
            on:keypress={() => setCurrentPageIndex(pageIndex)}
        >{pageIndex}</div>
    {/each}
    <div
        class="button-light"
        on:click={() => setCurrentPageIndex(currentPageIndex + 1)}
        on:keypress={() => setCurrentPageIndex(currentPageIndex + 1)}
    ><SvgIcon name="chevron_right"></SvgIcon></div>
</div>

<style>
    
</style>