<script lang="ts">
    import { Router, Link, Route } from "svelte-routing";
    import Home from "../routes/Home.svelte";
    import Product from "../routes/Product.svelte";
    import Products from "../routes/Products.svelte";
</script>

<Router>
    <nav>
        <ul>
            <Link style="color: white;" to="/"><li>Home</li></Link>
            <Link style="color: white;" to="/products"><li>Products</li></Link>
        </ul> 
    </nav>
    <div>
        <Route path="/" component="{Home}" />
        <Route path="/products" component="{Products}" />
        <Route path="/products/:code" component="{Product}" />
    </div>
</Router>
  
<style>
    nav {
        background-color: black;
    }
</style>
  