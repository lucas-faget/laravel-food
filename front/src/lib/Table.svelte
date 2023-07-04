<script lang="ts">
    export let header: Array<String>;
    export let rows: Array<Array<String>>;
</script>

<table>
    <tr>
        {#each header as value}
            <th>{value}</th>
        {/each}
    </tr>
    {#each rows as row}
        <tr>
            {#each row as value}
                <td>{value}</td>
            {/each}
        </tr>
    {/each}
</table>
  
<style>
    table {
        width: 100%;
        color: var(--color-green);
        text-align: left;
        font-size: 20px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    tr {
        border-top: 1px solid var(--color-light-green);
    }

    th, td {
        padding-block: 25px;
    }
</style>
