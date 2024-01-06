<script lang="ts">
    export let header: Array<String>;
    export let rows: Array<Array<String>>;
</script>

<table>
    <tr>
        {#each header as value, index}
            <th class:with-padding-right={index !== header.length - 1}>{value}</th>
        {/each}
    </tr>
    {#each rows as row}
        <tr>
            {#each row as value, index}
                <td class:with-padding-right={index !== row.length - 1}>{value}</td>
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
        /* table-layout: fixed; */
    }

    tr {
        border-top: 1px solid var(--color-light-green);
    }

    th, td {
        padding-block: 25px;
    }

    td.with-padding-right,
    th.with-padding-right {
        padding-right: 25px;
    }
</style>
