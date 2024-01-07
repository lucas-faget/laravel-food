<script lang="ts">
    import { Route } from "svelte-routing";

    import Home from "../views/Home.svelte";
    import Products from "../views/Products.svelte";
    import Product from "../views/Product.svelte";
    import Basket from "../views/Basket.svelte";
</script>

<div>
    <Route path="/" component="{Home}" />
    <Route path="/products" component="{Products}" />
    <Route path="/products/:id" component="{Product}" />
    <Route path="/basket" component="{Basket}" />
</div>
