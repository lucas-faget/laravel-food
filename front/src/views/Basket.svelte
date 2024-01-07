<script lang="ts">
    import { onMount } from 'svelte';
    import { writable } from "svelte/store";
    import { getAllProducts } from "../api/ProductClient";

    let basket = writable([]);

    onMount(async () => {
        handleGetAllProducts();
    });

    const handleGetAllProducts = async () => {
        let data: any = await getAllProducts();
        console.log(data);
        basket.set(data);
    }
</script>
  
<div class="basket">
    
</div>

<style>
    
</style>
