<script lang="ts">
    export let name: string;
    export let size: number = 40; // in pixels
    export let color: string = "#000";

    $: src = `/icons/${name}.svg`;
</script>

<div class="svg-icon" style="height: {size}px; width: {size}px; fill: {color};">
    <embed src="{src}" type="image/svg+xml" />
</div>

<style>
    .svg-icon embed {
        width: 100%;
        height: 100%;
    }
</style>
