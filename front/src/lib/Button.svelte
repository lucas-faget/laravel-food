<script lang="ts">
    export let handleClick: () => void;
</script>

<button class="button" on:click={handleClick}>
    <slot></slot>
</button>
  
<style>
    .button {
        color: #fff;
        background-color: var(--color-green);
        height: 50px;
        padding-inline: 20px;
        border: none;
        outline: none;
        font-size: 20px;
        font-family: 'Anton', sans-serif;
        text-transform: uppercase;
        cursor: pointer;
    }

    .button:hover {
        background-color: var(--color-light-green);
    }
</style>
