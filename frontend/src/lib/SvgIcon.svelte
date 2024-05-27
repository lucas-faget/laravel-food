<script lang="ts">
    export let name: string;
    export let size: number = 40; // in pixels

    $: src = `/icon/${name}.svg`;
</script>

<div class="svg-icon" style="height: {size}px; width: {size}px;">
    <img {src} alt={name} />
</div>

<style>
    img {
        width: 100%;
        height: 100%;
    }
</style>
