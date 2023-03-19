<script lang="ts">
    import { Router, Route, Link } from "svelte-routing";
    import Home from "./routes/Home.svelte";
    import Products from "./routes/Products.svelte";
</script>
  
<Router>
    <nav>
        <Link to="/">Home</Link>
        <Link to="/products">Products</Link>
    </nav>
    
    <Route path="/" component="{Home}" />
    <Route path="/products" component="{Products}" />
</Router>
