<script lang="ts">
    export let searchTerm: string;
</script>

<input class="input-text" type="text" placeholder="What are you searching for ?" bind:value={searchTerm} />

<style>
    .input-text {
        background-color: hsl(0, 0%, 85%);
        height: 50px;
        width: 100%;
        padding-inline: 20px;
        box-sizing: border-box;
        border: none;
        border-bottom: 5px solid var(--color-light-green);
        outline: none;
        font-size: 18px;
        font-family: 'Roboto';
    }

    .input-text:focus {
        border-bottom: 5px solid var(--color-green);
    }
</style>
