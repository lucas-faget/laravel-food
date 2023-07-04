<script lang="ts">
    import SvgIcon from "./SvgIcon.svelte";

    export let text: string;
    export let handleClick: () => void;
    export let iconName: string|null = null;
</script>

<button class="button" on:click={handleClick}>
    <span>{text}</span>
    {#if iconName}
        <SvgIcon name={iconName}></SvgIcon>
    {/if}
</button>
  
<style>
    .button {
        color: #fff;
        background-color: var(--color-green);
        height: 50px;
        padding-inline: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: none;
        outline: none;
        font-size: 20px;
        font-family: 'Anton', sans-serif;
        cursor: pointer;
    }

    .button:hover {
        background-color: var(--color-light-green);
    }
</style>
