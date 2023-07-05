<script lang="ts">
    export let title: String;
    export let items: Array<String>
</script>

<div class="list">
    {#if title}
        <span class="list-title">
            {title}
        </span>
    {/if}
    <ul>
        {#each items as item}
            <li class="list-item">
                <span>{item}</span>
            </li>
        {/each}
    </ul>
</div>
  
<style>
    .list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .list-title {
        color: var(--color-green);
        font-size: 20px;
        text-transform: capitalize;
    }

    .list > ul {
        list-style: none;
    }

    .list-item {
        color: var(--color-green);
        text-align: left;
        border-bottom: 1px solid var(--color-light-green);
        font-family: 'Anton', sans-serif;
        font-size: 40px;
        text-transform: uppercase;
    }
</style>
