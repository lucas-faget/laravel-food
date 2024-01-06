<script lang="ts">
    import { Route } from "svelte-routing";

    import Home from "../views/Home.svelte";
    import Product from "../views/Product.svelte";
    import Products from "../views/Products.svelte";
</script>

<div>
    <Route path="/" component="{Home}" />
    <Route path="/products" component="{Products}" />
    <Route path="/products/:id" component="{Product}" />
</div>
